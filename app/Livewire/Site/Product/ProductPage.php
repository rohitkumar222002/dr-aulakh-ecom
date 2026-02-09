<?php

namespace App\Livewire\Site\Product;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
class ProductPage extends Component
{
    use WithPagination;
    
    public $categories;
    public $selectedCategory = '';
    public $selectedSubcategory = '';
    public $search = '';
    public $sortBy = 'recommended';
    public $minPrice = 0;
    public $maxPrice = 1000000;
    public $perPage = 12;
    
    // Filters
    public $productTypes = [];
    public $healthCategories = [];
    public $priceRanges = [
        'under_500' => [0, 500],
        '500_1000' => [500, 1000],
        '1000_2000' => [1000, 2000],
        'over_2000' => [2000, 1000000]
    ];
    public $selectedPriceRange = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'selectedSubcategory' => ['except' => ''],
        'sortBy' => ['except' => 'recommended'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
    
    $this->categories = Category::with('subcategories')
        ->withCount(['products' => function ($q) {
            $q->where('is_active', true);
        }])
        ->where('is_active', true)
        ->get();


            
    }

    public function updated($property)
{
    if ($property === 'selectedCategory') {
        $this->selectedSubcategory = '';
    }

    if (in_array($property, [
        'search',
        'selectedCategory',
        'selectedSubcategory',
        'sortBy',
        'selectedPriceRange'
    ])) {
        $this->resetPage();
    }
}


    public function applyFilter($filterType, $value)
    {
        if ($filterType === 'category') {
            $this->selectedCategory = $value;
        } elseif ($filterType === 'subcategory') {
            $this->selectedSubcategory = $value;
        } elseif ($filterType === 'price') {
            $this->selectedPriceRange = $value;
        }
        
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'selectedCategory', 
            'selectedSubcategory', 
            'search', 
            'sortBy',
            'selectedPriceRange'
        ]);
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with(['category', 'subcategory'])
            ->where('is_active', true)
            ->when($this->selectedCategory, function ($q) {
    $q->whereHas('category', function ($c) {
        $c->where('slug', $this->selectedCategory);
    });
})
            ->when($this->selectedSubcategory, function ($q) {
                $q->where('subcategory_id', $this->selectedSubcategory);
            })
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('short_description', 'like', '%' . $this->search . '%')
                          ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedPriceRange && isset($this->priceRanges[$this->selectedPriceRange]), function ($q) {
                $range = $this->priceRanges[$this->selectedPriceRange];
                $q->whereBetween('price', $range);
            });

        switch ($this->sortBy) {
    case 'recommended':
        $query->orderBy('id', 'desc'); 
        break;

    case 'newest':
        $query->orderBy('created_at', 'desc');
        break;

    case 'price_low':
        $query->orderBy('price', 'asc');
        break;

    case 'price_high':
        $query->orderBy('price', 'desc');
        break;

    case 'rating':
        $query->orderBy('rating_avg', 'desc');
        break;

    case 'popular':
        $query->orderBy('rating_count', 'desc');
        break;
}


        $products = $query->paginate($this->perPage);
        
        // Get counts for filters
        $categoryCounts = $this->getCategoryCounts();
        $priceCounts = $this->getPriceCounts();

        return view('livewire.site.product.product-page', compact('products', 'categoryCounts', 'priceCounts'));
    }

    private function getCategoryCounts()
    {
        return Category::withCount(['products' => function ($query) {
            $query->where('is_active', true);
        }])->where('is_active', true)->get();
    }

    private function getPriceCounts()
    {
        $counts = [];
        
        foreach ($this->priceRanges as $key => $range) {
            $counts[$key] = Product::where('is_active', true)
                ->whereBetween('price', $range)
                ->count();
        }
        
        return $counts;
    }
  public function addToCart($productId)
{
    $product = Product::findOrFail($productId);

    $identifier = auth()->check()
        ? ['user_id' => auth()->id()]
        : ['session_id' => session()->getId()];

    $cart = Cart::firstOrCreate(
        array_merge($identifier, ['product_id' => $productId]),
        ['quantity' => 0]
    );

    $cart->quantity += 1;
    $cart->price_at_that_time = $product->discount_price ?? $product->price;
    $cart->save();

    $this->dispatch('cart-updated');
    $this->dispatch('toast', 'Added to cart!');

}


}
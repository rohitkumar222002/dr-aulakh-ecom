<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fund;
use App\Models\Maid;
use App\Models\User;
use DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Location\City;
use App\Models\Location\Block;
use App\Models\State;
use App\Models\Inc\CustomPages;
use App\Models\Inc\BusinessSetting;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Models\Order;
use Carbon\Carbon;
use Nette\Utils\Json;
class AdminController extends Controller
{
    function toAdminLogin()
    {
        return view('admin.auth.login');
    }

    public function toAdminDashboard(Request $request)
    {
        
        // Return totals and data for the chart
        return view('admin.home.dashboard');
    }
    
    

    function toSettings()
    {
        $states=State::all();
        return  view('admin.getSetting.getsetting',compact('states'));
    }

    public function toSettingUpload(Request $request)
    {
        $settings = $request->except('_token');
        foreach ($settings as $type => $value) {
            $businessSetting = BusinessSetting::firstOrNew(['type' => $type]);
            $businessSetting->value = $value;
            $businessSetting->save();
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }





    public function State()
    {
        $states = State::paginate(10);
        return view('admin.location.state', compact('states'));
    }


    public function StateSave(Request $request)
    {
        $request->validate([
            'state' => 'required|unique:states,name|string',
        ]);

        $state = new State();
        $state->name = $request->state;
        $state->slug = Str::slug($request->state);
        $state->status = $request->status ?? 1;
        $state->save();
        return redirect()->back()->with('success', 'State created successfully.');
    }


    public function StateUpdate(Request $request, $id)
    {
        $request->validate([
            'state' => 'required|unique:states,name,' . $id . ',id|string',
        ]);
        $state = State::findOrFail($id);
        $state->name = $request->state;
        $state->slug = Str::slug($request->state);
        $state->status = $request->status ?? 1;
        $state->save();
        return redirect()->back()->with('success', 'State updated successfully.');
    }


    public function StateDelete($id)
    {

        $state = State::findOrFail($id);
        if ($state->cities()->exists() || $state->blocks()->exists()) {
            return response()->json(['error' => 'State cannot be deleted as it is associated with cities or blocks.']);
        }
        if ($state->delete()) {
            return response()->json(['success' => 'Item deleted successfully.']);
        }
        return response()->json(['error' => 'Item not deleted.']);
    }

    public function City()
    {
        $cities = City::paginate(10);
        $states = State::all();
        return view('admin.location.city', compact('cities', 'states'));
    }

    public function CityStore(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'city' => 'required|string|max:255|unique:cities,name',
        ]);

        City::create([
            'state_id' => $request->state_id,
            'name' => $request->city,
            'slug' => Str::slug($request->city),
        ]);

        return redirect()->back()->with('success', 'City added successfully.');
    }

    public function CityUpdate(Request $request, $id)
    {
        $request->validate([
            'city' => 'required|string|max:255|unique:cities,name,' . $id,
            'state_id' => 'required|exists:states,id',
        ]);

        $city = City::findOrFail($id);
        $city->update([
            'name' => $request->city,
            'state_id' => $request->state_id,
            'slug' => Str::slug($request->city),
        ]);

        return redirect()->back()->with('success', 'City updated successfully.');
    }


    public function CityDelete($id)
    {
        $city = City::findOrFail($id);

        if ($city->blocks()->exists()) {
            return response()->json(['error' => 'City cannot be deleted as it is associated with blocks.']);
        }

        if ($city->delete()) {
            return response()->json(['success' => 'City deleted successfully.']);
        }

        return response()->json(['error' => 'City not deleted.']);
    }

    public function Block()
    {
        $blocks = Block::paginate(10);
        $states = State::all();
        $cities = City::all();
        return view('admin.location.block', compact('blocks', 'states', 'cities'));
    }
    public function saveBlock(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'block_name' => 'required|string|max:255|unique:blocks,name',
        ]);

        Block::create([
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'name' => $request->block_name,
            'slug' => Str::slug($request->block_name),
        ]);

        return redirect()->back()->with('success', 'Block added successfully!');
    }

    public function updateBlock(Request $request, $id)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'block_name' => 'required|string|max:255|unique:blocks,name,' . $id,
        ]);

        $block = Block::findOrFail($id);
        $block->update([
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'name' => $request->block_name,
            'slug' => Str::slug($request->block_name),
        ]);

        return redirect()->back()->with('success', 'Block updated successfully!');
    }


    public function BlockDestroy($id)
    {
        $block = Block::findOrFail($id);
        if ($block->delete()) {
            return response()->json(['success' => 'Item deleted successfully.']);
        }
        return response()->json(['error' => 'Item not deleted.']);
    }
    // ------------------------------------------------------------------------------------------------------------------
    // -----------------------------------------Custom Pages-------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------

    function toCustomPage()
    {
        $custompages = CustomPages::with(['childs', 'parent'])->get();
        return view('admin.custompages.pages', compact('custompages'));
    }

    function toCustom(Request $request)
    {
        $custompages = CustomPages::with(['childs', 'parent'])->orderBy('id', 'Desc')->get();
        return view('admin.custompages.allpages', compact('custompages'));
    }

    function toCustomPageSave(Request $request)
    {
        $request->validate([
            "parent_id" => "required|string",
            "page_name" => "required|string|max:100|unique:custompages,page_name",
            "page_desc" => "required|string",
        ]);

        $custompage = new CustomPages();
        $custompage->page_name = ucfirst($request->page_name);
        $custompage->slug = Str::slug($request->page_name);
        $custompage->parent_id = $request->parent_id;
        $custompage->status = $request->status;
        $custompage->banner = $request->banner;
        $custompage->priority = $request->priority;
        $custompage->page_desc = $request->page_desc;
        $custompage->meta_title = $request->meta_title;
        $custompage->meta_keyword = $request->meta_keyword;
        $custompage->meta_description = $request->meta_description;
        if ($custompage->save()) {
            return redirect()->back()->with('success', 'Page created successfully.');
        }
        return redirect()->back()->with('error', 'Page not created.');
    }

    function toCustomPageEdit($id)
    {
        $custompage = CustomPages::findOrFail($id);
        if (!$custompage) {
            return redirect()->back()->with('error', 'Page not found.');
        }
        $custompages = CustomPages::where('parent_id', 0)->get();
        return view('admin.custompages.edit', compact('custompage', 'custompages'));
    }

    function toCustomPageUpdate(Request $request, $id)
    {

        $request->validate([
            "parent_id" => "required|string",
            "page_name" => "required|string|max:100|unique:custompages,page_name,$id",
            "page_desc" => "required|string",
        ]);
        $custompage = CustomPages::findOrFail($id);
        $custompage->page_name = ucfirst($request->page_name);
        $custompage->slug = Str::slug($request->page_name);
        $custompage->parent_id = $request->parent_id;
        $custompage->status = $request->status;

        $custompage->Show_in = $request->Show_in;

        $custompage->banner = $request->banner;
        $custompage->priority = $request->priority;
        $custompage->page_desc = $request->page_desc;
        $custompage->meta_title = $request->meta_title;
        $custompage->meta_keyword = $request->meta_keyword;
        $custompage->meta_description = $request->meta_description;
        if ($custompage->save()) {
            return redirect()->back()->with('success', 'Page updated successfully.');
        }
        return redirect()->back()->with('error', 'Page not updated.');
    }


    public function toCustomPageDelete($id)
    {
        try {
            // Fetch the CustomPage with its relations
            $customPage = CustomPages::with(['childs', 'parent'])->findOrFail($id);

            // Check if the page has child pages
            if ($customPage->childs->isNotEmpty()) {
                return response()->json(['error' => 'Page cannot be deleted as it has child pages.'], 400);
            }

            // Attempt to delete the page
            if ($customPage->delete()) {
                return response()->json(['success' => 'Item deleted successfully.'], 200);
            }

            // Handle unexpected failure to delete
            return response()->json(['error' => 'Item could not be deleted.'], 500);
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    public function downloadUsers()
    {
        $users = User::all(); 
        return Excel::download(new UsersExport($users), 'users.xlsx');
    }


    public function AddMaid(){
        return view('admin.maid.add-maid');
    }
    
    public function AddMaidStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:7,15|unique:maids,phone',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:18|max:80',
            'experience' => 'nullable|integer|min:0|max:60',
            'work_type' => 'nullable',
            'availability' => 'nullable',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'block_id' => 'nullable|exists:blocks,id',
            'address' => 'nullable|string|max:1000',
        ]);
    
        $maid = new Maid();
        $maid->name = $request->name;
        $maid->phone = $request->phone;
        $maid->gender = $request->gender;
        $maid->age = $request->age;
        $maid->experience = $request->experience;
        $maid->work_type = $request->work_type;
        $maid->availability = $request->availability;
        $maid->state_id = $request->state_id;
        $maid->city_id = $request->city_id;
        $maid->block_id = $request->block_id;
        $maid->address = $request->address;
    
      
        $maid->status = 1;
        $maid->save();
    
        return redirect()->back()->with('success', 'Maid added successfully.');
    }
    
        public function MaidList(){
        $maids = Maid::paginate(10);
        return view('admin.maid.maid-list', compact('maids'));
        }


        public function Maidupdate(Request $request, $id){
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|numeric|digits_between:7,15|unique:maids,phone,' . $id,
                'gender' => 'nullable|in:male,female',
                'age' => 'nullable|integer|min:18|max:80',
                'experience' => 'nullable|integer|min:0|max:60',
                'work_type' => 'nullable',
                'availability' => 'nullable',
                'state_id' => 'nullable|exists:states,id',
                'city_id' => 'nullable|exists:cities,id',
                'block_id' => 'nullable|exists:blocks,id',
                'address' => 'nullable|string|max:1000',
            ]);

            $maid = Maid::findOrFail($id);
            $maid->name = $request->name;
            $maid->phone = $request->phone;
            $maid->gender = $request->gender;
            $maid->age = $request->age;
            $maid->experience = $request->experience;
            $maid->work_type = $request->work_type;
            $maid->availability = $request->availability;
            $maid->state_id = $request->state_id;
            $maid->city_id = $request->city_id;
            $maid->block_id = $request->block_id;
            $maid->address = $request->address;
            $maid->save();
        return redirect()->back()->with('success', 'Maid updated successfully.');
        }


        public function MaidDelete($id)
{
    try {
        $maid = Maid::findOrFail($id);
        $maid->delete();

        return response()->json([
            'status' => true,
            'message' => 'Maid deleted successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong!',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function Orders(Request $request) {
    // Get all orders with search and filter
    $orders = Order::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('order_number', 'like', '%' . $request->search . '%')
                      ->orWhere('phone', 'like', '%' . $request->search . '%')
                      ->orWhereHas('user', function ($userQuery) use ($request) {
                          $userQuery->where('name', 'like', '%' . $request->search . '%')
                                    ->orWhere('email', 'like', '%' . $request->search . '%');
                      })
                      ->orWhereHas('address', function ($addressQuery) use ($request) {
                          $addressQuery->where('full_name', 'like', '%' . $request->search . '%')
                                      ->orWhere('phone', 'like', '%' . $request->search . '%')
                                      ->orWhere('pincode', 'like', '%' . $request->search . '%');
                      });
                });
            })
            ->when($request->status && $request->status !== 'all', function ($query) use ($request) {
                $query->where('order_status', $request->status);
            })
            ->with(['items.product', 'address', 'user'])
            ->latest()
            ->paginate(10);
$todayOrders = Order::whereDate('created_at', today())->count();

    // Get counts for stats
    $totalOrders = Order::count();
    $pendingOrders = Order::where('order_status', 'pending')->count();
    $processingOrders = Order::where('order_status', 'processing')->count();
    $shippedOrders = Order::where('order_status', 'shipped')->count();
    $deliveredOrders = Order::where('order_status', 'delivered')->count();
    $cancelledOrders = Order::where('order_status', 'cancelled')->count();

    return view('admin.orders.orders-list', compact(
        'orders', 
        'totalOrders',
        'pendingOrders',
        'processingOrders',
        'shippedOrders',
        'deliveredOrders',
        'cancelledOrders',
        'todayOrders'
    ));
}

public function updateOrderStatus(Request $request, $id)
{
    $request->validate([
        'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled'
    ]);

    $order = Order::findOrFail($id);
    $order->update([
        'order_status' => $request->order_status
    ]);

    return back()->with('success', 'Order status updated successfully');
}


public function viewOrder($id) {
    $order = Order::with(['items.product', 'address', 'user'])->findOrFail($id);
    return view('admin.orders.order-detail', compact('order'));
}

}
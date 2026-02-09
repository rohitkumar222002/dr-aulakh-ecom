<?php

namespace App\Livewire\Site\Checkout;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CheckoutPage extends Component
{
    public $couponCode;
    protected $listeners = ['razorpaySuccess' => 'verifyPayment'];

public $couponApplied = false;
public $couponError = null;

    public $selectedAddressId = null;
    public $addresses;
    public $showNewAddressForm = false;
    public $showGuestLoginForm = false;
    public $isGuest = true;
    
    public $guestPhone = '';
    public $guestName = '';
    public $guestEmail = '';
    
    public $full_name = '';
    public $phone = '';
    public $address_line1 = '';
    public $address_line2 = '';
    public $city = '';
    public $state_id = '';
    public $states = [];

    public $pincode = '';
    public $landmark = '';
    public $address_type = 'home';
    public $save_address = true;
    
    public $paymentMethod = 'cod';
    public $adminGstStateId;
    
    public $cartItems = [];
    public $totalAmount = 0;
    public $subtotal = 0;
    public $shipping = 0;
    public $discount = 0;
    
    public $cgst = 0;
    public $sgst = 0;
    public $igst = 0;
    public $taxableAmount = 0;
    public $taxAmount = 0;
    public $gstRate = 18;
    public $grandTotal = 0;

    public function mount() 
    {
        $this->isGuest = !auth()->check();
        
        if ($this->isGuest) {
            $this->showGuestLoginForm = true;
        }
        
        $this->adminGstStateId = get_setting('gst_state');
        
        $this->states = State::orderBy('name')->get();
        
        if (!$this->isGuest) {
            $this->loadAddresses();
            
            if ($this->addresses && $this->addresses->count() > 0) {
                $defaultAddress = $this->addresses->where('is_default', true)->first();
                
                if ($defaultAddress) {
                    $this->selectedAddressId = $defaultAddress->id;
                } else {
                    $this->selectedAddressId = $this->addresses->first()->id;
                }
            }
        }
         
        $this->loadCart();
        if (auth()->check()) {
            $this->full_name = auth()->user()->name ?? '';
            $this->phone = auth()->user()->phone ?? '';
        }
        
        if ($this->cartItems->count() == 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }
    }

    public function loadCart()
    {
        $this->cartItems = Cart::where(auth()->check() ? 'user_id' : 'session_id', 
            auth()->check() ? auth()->id() : session()->getId())
            ->with('product')
            ->get();

        if ($this->cartItems->count() == 0 && request()->routeIs('checkout')) {
            return redirect()->route('cart');
        }

        $this->subtotal = $this->cartItems->sum(
            fn($item) => $item->price_at_that_time * $item->quantity
        );
        
        $this->shipping = 0;
        $this->discount = $this->subtotal > 500 ? $this->subtotal * 0.10 : 0;
        $this->taxableAmount = $this->subtotal - $this->discount;
        
        $this->calculateTaxes();
        
        $this->totalAmount = $this->taxableAmount + $this->shipping + $this->cgst + $this->sgst + $this->igst;
        $this->grandTotal = $this->totalAmount;
    }

    public function calculateTaxes()
    {
        $this->cgst = 0;
        $this->sgst = 0;
        $this->igst = 0;
        $this->taxAmount = 0;

        if ($this->taxableAmount <= 0 || !$this->selectedAddressId || !$this->adminGstStateId) {
            return;
        }

        $shippingStateId = null;
        
        if ($this->selectedAddressId !== 'temp') {
            $address = $this->addresses->where('id', $this->selectedAddressId)->first();
            if ($address && $address->state_id) {
                $shippingStateId = $address->state_id;
            }
        } else {
            $shippingStateId = $this->state_id;
        }

        if (!$shippingStateId) {
            return;
        }

        $this->taxAmount = ($this->taxableAmount * $this->gstRate) / 100;
        
        if ($shippingStateId == $this->adminGstStateId) {
            $this->cgst = $this->taxAmount / 2;
            $this->sgst = $this->taxAmount / 2;
            $this->igst = 0;
        } else {
            $this->cgst = 0;
            $this->sgst = 0;
            $this->igst = $this->taxAmount;
        }
    }

    public function updatedSelectedAddressId()
    {
        $this->calculateTaxes();
        $this->updateTotalAmount();
    }
    
    public function updatedStateId()
    {
        if ($this->selectedAddressId === 'temp') {
            $this->calculateTaxes();
            $this->updateTotalAmount();
        }
    }

    public function updateTotalAmount()
    {
        $this->totalAmount = $this->taxableAmount + $this->shipping + $this->cgst + $this->sgst + $this->igst;
        $this->grandTotal = $this->totalAmount;
    }

    public function loadAddresses()
    {
        if (auth()->check()) {
            $this->addresses = Address::where('user_id', auth()->id())
                ->with('state')
                ->orderBy('is_default', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $this->addresses = collect();
        }
    }

    public function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('ymd');
        $countToday = Order::whereDate('created_at', now()->toDateString())->count() + 1;
        return $prefix . '-' . $date . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);
    }

    public function loginOrRegister()
    {
        $this->validate([
            'guestPhone' => 'required|digits:10',
            'guestName' => 'required|min:3',
        ]);

        $phone = $this->guestPhone;
        $name = $this->guestName;
        
        $user = User::where('phone', $phone)->first();
        $username = 'THL' . str_pad(User::max('id') + 1, 4, '0', STR_PAD_LEFT);
    
        if (!$user) {
            $user = User::create([
                'name' => $name,
                'phone' => $phone,
                'username' => $username,
                'password' => Hash::make($phone),
            ]);
            
            session()->flash('success', 'Account created successfully!');
        } else {
            if ($user->name !== $name) {
                $user->update(['name' => $name]);
            }
            session()->flash('success', 'Welcome back!');
        }
        
        Auth::login($user);
        
        Cart::where('session_id', session()->getId())->update([
            'user_id' => $user->id,
            'session_id' => null,
        ]);
        
        $this->resetGuestForm();
        $this->isGuest = false;
        $this->showGuestLoginForm = false;
        
        $this->loadAddresses();
        
        if ($this->addresses->count() > 0) {
            $defaultAddress = $this->addresses->where('is_default', true)->first();
            
            if ($defaultAddress) {
                $this->selectedAddressId = $defaultAddress->id;
            } else {
                $this->selectedAddressId = $this->addresses->first()->id;
            }
        }
        
        $this->calculateTaxes();
        $this->updateTotalAmount();
        
        session()->flash('message', 'Successfully logged in!');
    }

    public function saveNewAddress()
    {
        $this->validate([
            'full_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'address_line1' => 'required|min:10',
            'city' => 'required',
            'state_id' => 'required|exists:states,id',
            'pincode' => 'required|digits:6',
            'address_type' => 'required|in:home,office,other',
        ]);

        if (!auth()->check()) {
            $this->selectedAddressId = 'temp';
            $this->showNewAddressForm = false;
            session()->flash('message', 'Address added for this order.');
            
            $this->calculateTaxes();
            $this->updateTotalAmount();
            return;
        }

        $addressData = [
            'user_id' => auth()->id(),
            'type' => $this->address_type,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'pincode' => $this->pincode,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'state_id' => $this->state_id,
            'landmark' => $this->landmark,
        ];

        if ($this->save_address) {
            if ($this->addresses->isEmpty()) {
                $addressData['is_default'] = true;
            }
            
            $address = Address::create($addressData);
            $this->selectedAddressId = $address->id;
            $this->loadAddresses();
            $this->showNewAddressForm = false;
            
            $this->reset(['full_name', 'phone', 'address_line1', 'address_line2', 
                         'city', 'state_id', 'pincode', 'landmark', 'address_type']);
            
            session()->flash('message', 'Address saved successfully!');
        } else {
            $this->selectedAddressId = 'temp';
            $this->showNewAddressForm = false;
            session()->flash('message', 'Address will be used for this order only.');
        }
        
        $this->calculateTaxes();
        $this->updateTotalAmount();
    }

 public function placeOrder()
{
    // Debug log
    \Log::info('placeOrder called', [
        'selectedAddressId' => $this->selectedAddressId,
        'isGuest' => $this->isGuest,
        'user_id' => auth()->id()
    ]);

    if (!auth()->check()) {
        if (!$this->full_name || !$this->phone) {
            session()->flash('error', 'Please add your name and phone number in the address form.');
            $this->showNewAddressForm = true;
            return;
        }
        
        $user = User::where('phone', $this->phone)->first();
        
        if (!$user) {
            $user = User::create([
                'name' => $this->full_name,
                'email' => $this->phone . '@example.com',
                'phone' => $this->phone,
                'password' => Hash::make($this->phone),
            ]);
        }
        
        Auth::login($user);
        
        Cart::where('session_id', session()->getId())->update([
            'user_id' => $user->id,
            'session_id' => null,
        ]);
        
        session()->flash('success', 'Account created automatically with your phone number.');
    }

    if (!$this->selectedAddressId) {
        session()->flash('error', 'Please select or add a delivery address.');
        return;
    }

    $selectedAddress = null;
    
    if ($this->selectedAddressId !== 'temp') {
        // FIX: Add better debugging
        $selectedAddress = Address::where('id', $this->selectedAddressId)
                                  ->where('user_id', auth()->id())
                                  ->first();
        
        if (!$selectedAddress) {
            \Log::error('Address not found or unauthorized', [
                'address_id' => $this->selectedAddressId,
                'user_id' => auth()->id(),
                'available_addresses' => Address::where('user_id', auth()->id())->pluck('id')
            ]);
            
            session()->flash('error', 'Selected address not found. Please add a new address.');
            $this->showNewAddressForm = true;
            return;
        }
    } else {
        // Validate temp address
        $this->validate([
            'full_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'address_line1' => 'required|min:10',
            'city' => 'required',
            'state_id' => 'required|exists:states,id',
            'pincode' => 'required|digits:6',
        ]);

        $addressData = [
            'user_id' => auth()->id(),
            'type' => $this->address_type,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'pincode' => $this->pincode,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'state_id' => $this->state_id,
            'landmark' => $this->landmark,
            'is_default' => true,
        ];
        
        $selectedAddress = Address::create($addressData);
    }

    // Validate payment method
    $this->validate([
        'paymentMethod' => 'required|in:cod,online',
    ]);
    
    // Check product availability
    foreach ($this->cartItems as $item) {
        if (!$item->product) {
            session()->flash('error', 'A product in your cart is no longer available.');
            return;
        }

        if ($item->product->stock_qty < $item->quantity) {
            session()->flash('error', $item->product->name . ' is out of stock or insufficient quantity available.');
            return;
        }
        
        if (!$item->product->is_active) {
            session()->flash('error', $item->product->name . ' is not available for sale.');
            return;
        }
    }

    // Create order
    $orderNumber = $this->generateOrderNumber();
    $order = Order::create([
        'user_id' => auth()->id(),
        'address_id' => $selectedAddress->id,
        'order_number' => $orderNumber,
        'total_amount' => $this->totalAmount,
        'payment_method' => $this->paymentMethod,
        'payment_status' => $this->paymentMethod === 'cod' ? 'pending' : 'unpaid',
        'order_status' => 'processing', // Changed from 'processing' to 'pending'
        'phone' => $selectedAddress->phone,
        'cgst' => $this->cgst,
        'sgst' => $this->sgst,
        'igst' => $this->igst,
    ]);

    // Add order items and update stock
    foreach ($this->cartItems as $item) {
        $product = $item->product;

        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $item->product_id,
            'price'      => $item->price_at_that_time,
            'quantity'   => $item->quantity,
            'total'      => $item->price_at_that_time * $item->quantity,
        ]);

        $product->decrement('stock_qty', $item->quantity);
    }

    // Clear cart
    Cart::where('user_id', auth()->id())->delete();

    return redirect()->route('order.success', $order);
}
   private function getSelectedAddress()
{
    if ($this->selectedAddressId === 'temp') {
        // Validate temp address
        $this->validate([
            'full_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'address_line1' => 'required|min:10',
            'city' => 'required',
            'state_id' => 'required|exists:states,id',
            'pincode' => 'required|digits:6',
        ]);

        $addressData = [
            'user_id' => auth()->id(),
            'type' => $this->address_type,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'pincode' => $this->pincode,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'state_id' => $this->state_id,
            'landmark' => $this->landmark,
            'is_default' => true,
        ];
        
        \Log::info('Creating temp address for online payment', $addressData);
        
        return Address::create($addressData);
    } else {
        // Get address with user check
        $address = Address::where('id', $this->selectedAddressId)
                          ->where('user_id', auth()->id())
                          ->first();
        
        if (!$address) {
            \Log::error('Address not found for online payment', [
                'address_id' => $this->selectedAddressId,
                'user_id' => auth()->id()
            ]);
            
            throw new \Exception('Invalid address selected');
        }
        
        return $address;
    }
}
public function applyCoupon()
{
    $this->couponError = null;
    $this->couponApplied = false;

    if (!$this->couponCode) {
        $this->couponError = "Please enter a coupon code.";
        return;
    }

    $coupon = Coupon::where('code', trim($this->couponCode))
                    ->where('status', 1)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();

    if (!$coupon) {
        $this->couponError = "Invalid or expired coupon.";
        return;
    }

    // Calculate discount
    if ($coupon->discount_type === 'percent') {
        $this->discount = ($this->subtotal * $coupon->discount_value) / 100;
    } else {
        $this->discount = $coupon->discount_value;
    }

    if ($this->discount > $this->subtotal) {
        $this->discount = $this->subtotal;
    }

    $this->couponApplied = true;

    $this->updatedCartSummary();
}

public function updatedCartSummary()
{
    // taxable amount = subtotal - discount
    $this->taxableAmount = max(($this->subtotal - $this->discount), 0);

    // calculate GST again
    $this->calculateTaxes();

    // final amount
    $this->grandTotal = $this->taxableAmount 
                        + $this->cgst 
                        + $this->sgst 
                        + $this->igst 
                        + $this->shipping;
}
public function startOnlinePayment()
{
    $this->validate([
        'selectedAddressId' => 'required',
    ]);
    
    // Debug logs
    \Log::info('startOnlinePayment called');
    \Log::info('Grand Total: ' . $this->grandTotal);
    
    $address = $this->getSelectedAddress();
    if (!$address) {
        session()->flash('error', 'Please select a delivery address');
        return;
    }
    
    // Amount validation
    if ($this->grandTotal < 1) {
        session()->flash('error', 'Invalid amount for payment');
        return;
    }
    
    try {
        $orderData = [
            'receipt'         => 'order_rcpt_' . time(),
            'amount'          => intval(round($this->grandTotal * 100)),
            'currency'        => 'INR',
            'payment_capture' => 1
        ];
        
        \Log::info('Razorpay order data:', $orderData);
        
        $client = new \Razorpay\Api\Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
        
        $razorpayOrder = $client->order->create($orderData);
        
        \Log::info('Razorpay order created:', $razorpayOrder->toArray());
        
        // Debug: Check dispatch
        \Log::info('Dispatching startRazorpayCheckout event');
        
        // Dispatch the event - FIXED SYNTAX
        $this->dispatch('startRazorpayCheckout', 
            order_id: $razorpayOrder['id'],
            amount: $razorpayOrder['amount'],
            name: $address->full_name,
            phone: $address->phone,
            email: auth()->user()->email ?? $address->phone . '@example.com'
        );
        
        \Log::info('✅ Event dispatched successfully');
        
    } catch (\Exception $e) {
        \Log::error('Razorpay error: ' . $e->getMessage());
        session()->flash('error', 'Payment gateway error: ' . $e->getMessage());
    }
}
public function verifyPayment($paymentId, $orderId, $signature)
{
    \Log::info('verifyPayment called', [
        'paymentId' => $paymentId,
        'orderId' => $orderId,
        'signature' => $signature
    ]);
    
    $signature = hash_hmac(
        'sha256',
        $orderId . "|" . $paymentId,
        config('services.razorpay.secret')
    );

    if ($signature !== $signature) {
        session()->flash('error', 'Payment verification failed!');
        return;
    }

    // Call your order creation method
    return $this->createOnlineOrder($paymentId);
}
public function createOnlineOrder(string $paymentId)
{
    \DB::beginTransaction();

    try {
        // Force correct payment method
        $this->paymentMethod = 'online';

        $address = $this->getSelectedAddress();
        if (!$address) {
            throw new \Exception('Address not found or invalid');
        }

        $order = Order::create([
            'user_id'        => auth()->id(),
            'address_id'     => $address->id,
            'order_number'   => $this->generateOrderNumber(),
            'total_amount'   => $this->totalAmount,
            'payment_method' => 'online',
            'payment_status' => 'paid',
            'order_status'   => 'processing',
            'phone'          => $address->phone,
            'cgst'           => $this->cgst,
            'sgst'           => $this->sgst,
            'igst'           => $this->igst,
        ]);

        foreach ($this->cartItems as $item) {
            $product = $item->product;

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'price'      => $item->price_at_that_time,
                'quantity'   => $item->quantity,
                'total'      => $item->price_at_that_time * $item->quantity,
            ]);

            $product->decrement('stock_qty', $item->quantity);
        }

        Cart::where('user_id', auth()->id())->delete();

        \DB::commit();

        return redirect()->route('order.success', $order->id);

    } catch (\Throwable $e) {
        \DB::rollBack();

        \Log::error('❌ Online order create failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        session()->flash('error', 'Order creation failed: ' . $e->getMessage());
        
        // Optional: Redirect back to checkout
        return redirect()->route('checkout');
    }
}


public function handlePaymentFailed($error)
{
    session()->flash('error', 'Payment failed: ' . $error['description']);
}

public function handlePaymentCancelled()
{
    session()->flash('info', 'Payment was cancelled by user.');
}


    public function resetGuestForm()
    {
        $this->guestPhone = '';
        $this->guestName = '';
        $this->guestEmail = '';
    }

    public function render()
    {
        return view('livewire.site.checkout.checkout-page');
    }
}
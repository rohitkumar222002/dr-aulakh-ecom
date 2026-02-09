<div>

   <div x-data="{ show: @entangle('show') }">

    <div 
        x-show="show"
        x-transition.opacity.duration.300ms
        x-cloak
        x-init="
            $wire.on('hide-toast-after-delay', () => {
                setTimeout(() => show = false, 2000);
            })
        "
        class="toast-notification"
    >
        <div class="toast-inner">
            <i class="fas fa-check-circle"></i>
            <span>{{ $message }}</span>
        </div>
    </div>

</div>

    <style>
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            background: #111;
            color: white;
            padding: 12px 18px;
            border-radius: 30px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
        }

        .toast-inner i {
            color: #2ecc71;
            margin-right: 8px;
        }
    </style>

</div>

<button class="icon-btn" title="Cart" wire:click="$dispatch('toggle-mini-cart')">
    <i class="fas fa-shopping-bag"></i>
    <span class="badge">{{ $count }}</span>
</button>

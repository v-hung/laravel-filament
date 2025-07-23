<?php

namespace App\Livewire\Cart;

use Livewire\Component;

class IconWidget extends Component
{
    public $cartItems = [];

    public function mount()
    {
        $this->loadCart();
        $this->cartItems = Session::get('cart', []);
    }

    public function getItemCountProperty()
    {
        return count($this->cartItems);
    }
    public function render()
    {
        return view('livewire.cart.icon-widget');
    }
}

trait InteractsWithCart
{
    public function addToCart($productId) { ... }
    public function removeFromCart($productId) { ... }
}
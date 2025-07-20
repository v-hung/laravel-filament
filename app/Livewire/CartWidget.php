<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CartWidget extends Component
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
        return view('livewire.cart-widget');
    }
}

<div x-data="{ open: false }">
    <button @click="open = true">
        🛒 {{ $cartItemCount }} sản phẩm
    </button>

    <div x-show="open" class="fixed right-0 top-0 w-80 h-full bg-white shadow-lg p-4">
       <div class="fixed top-0 right-0 w-80 h-full bg-white shadow-lg p-4 z-50">
            <h2 class="text-lg font-bold">Giỏ hàng</h2>
            <button wire:click="toggleDrawer">Đóng</button>

            <div class="mt-4 space-y-2">
                @forelse ($cartItems as $item)
                    <div class="border-b pb-2">
                        <strong>{{ $item['name'] }}</strong> x {{ $item['qty'] }}
                    </div>
                @empty
                    <p>Giỏ hàng đang trống</p>
                @endforelse
            </div>
        </div>
        <button @click="open = false">Đóng</button>
    </div>
</div>

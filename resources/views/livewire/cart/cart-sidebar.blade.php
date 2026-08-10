<div>
    <div class="card position-relative">
        <x-utils.card-spinner/>
        <div class="card-body">
            <dl class="d-flex justify-content-between">
                <dt>Subtotal:</dt>
                <dd class="text-right">{{ INR }}{{ Cart::getSubTotal() }}</dd>
            </dl>
            @foreach(Cart::getConditions() as $condition)
                <dl class="d-flex justify-content-between">
                    <dt>{{ $condition->getName() }}</dt>
                    <dd class="text-right {{ $condition->getType() == 'discount' ? 'text-success' : 'text-danger' }}">
                        {{ $condition->getType() == 'discount' ? '-' : '+' }}
                        {{ INR }} {{ $condition->getCalculatedValue(Cart::getSubTotal()) }}
                    </dd>
                </dl>
            @endforeach
            <dl class="d-flex justify-content-between">
                <dt>Total:</dt>
                <dd class="text-right text-dark"><strong>{{ INR }}{{ Cart::getTotal() }}</strong></dd>
            </dl>
            <hr>
            <a href="{{ route('shop.checkout') }}" class="btn btn-warning btn-block mb-4"> Checkout </a>
            <a href="{{ route('shop') }}" class="btn btn-outline-warning btn-block">Continue Shopping</a>
        </div>
    </div>
</div>

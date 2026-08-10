<div class="col-12">
    <article class="card card-body empty-cart">
        <figure class="text-center">
            <figcaption class="pt-4">
                <div class="icon p-4"><i class="fa fa-lg fa-shopping-cart"></i></div>
                <h2 class="card-title font-weight-bold text-responsive">Your cart is empty</h2>
                <p> Before proceed to checkout you must add some products to shopping cart.</p>
                <a href="{{ route('shop') }}" class="btn btn-warning btn-lg">Shop Now</a>
            </figcaption>
        </figure>
    </article>
</div>

@push('css')
    <style>
        .empty-cart .fa-shopping-cart{
            font-size: 50px;
        }
    </style>
@endpush
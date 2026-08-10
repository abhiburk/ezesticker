<div>
    <div class="card position-relative">
        <x-utils.card-spinner/>
        <div class="card-body">
            {{-- if coupon code is empty --}}
            @empty($this->coupon_code)
                <dl class="d-flex justify-content-between">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" wire:click="applyWalletBalance('{{ Helper::encodeId(intval(Cart::getTotal())) }}')" {{ $use_wallet == '1' ? 'checked' : '' }} class="custom-control-input" id="customCheck1" 
                        {{ round(auth()->user()->wallet->balanceFloat) <= 0 ? 'disabled' : ''}} >
                        <label class="custom-control-label" for="customCheck1" 
                            @if (round(auth()->user()->wallet->balanceFloat) <= 0)
                                data-toggle="tooltip"
                                title="Insufficient Wallet Balance"
                            @endif
                        >
                            Use Wallet Balance ({{ INR }}{{$wallet_balance}}) 
                        </label>
                        <small wire:ignore>
                            <i class="bi bi-info-circle-fill" data-trigger="click"  data-toggle="tooltip" title="You can use {{ MAX_WALLET_USAGE }}% of total from your wallet."></i>
                        </small>
                    </div>
                </dl>
            @endempty
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

                        {{-- if coupon --}}
                        @if ($condition->getType() == 'discount' && (isset($condition->getAttributes()['is_coupon']) && $condition->getAttributes()['is_coupon']))
                            <a href="#" class="text-dark" wire:click.prevent="removeCondition('{{ $condition->getName() }}')"> <small><i class="fa fa-trash"></i></small> </a>
                        @endif
                    </dd>
                </dl>
            @endforeach
            <dl class="d-flex justify-content-between">
                <dt>Tax:</dt>
                <small>Inclusive of taxes</small>
            </dl>
            <dl class="d-flex justify-content-between">
                <dt>Total:</dt>
                <dd class="text-right text-dark">{{ INR }}{{ Cart::getTotal() }}</dd>
            </dl>
            <hr>
            @empty($address->pincode)
                <p class="small my-3 text-danger text-center">
                    In order to place this order, please update your billing address.
                </p>
            @else
                <x-utils.button type="button" wire:click.prevent="storeOrder" wireTarget="storeOrder" class="btn btn-warning btn-block">
                    Place Order
                </x-utils.button>
            @endempty
            <p class="small my-3 text-muted text-center">
                <img src="{{ url('frontend/img/Razorpay-Logo.png') }}" alt="Paytm" width="75">
                <span class="d-block m-2">Secured Payment</span>
            </p>
            <a href="{{ route('shop') }}" class="btn btn-outline-warning btn-block">Continue Shopping</a>
        </div>
    </div>
    
    {{-- if wallet is unchecked --}}
    {{-- If it is reseller with 20+ qty hide coupon field or if its Customer/Admin and not reseller show coupon field --}}
    @if ((auth()->user()->hasRole(['Reseller']) && Cart::getTotalQuantity() < MIN_RESELLER_QTY) || (auth()->user()->hasRole(['Customer', 'Admin']) && !auth()->user()->hasRole(['Reseller'])) )
        @if ( !$use_wallet )
            <div class="card mt-3">
                <div class="card-body">
                    <form wire:submit.prevent="applyCoupon">
                        <div class="form-group">
                            <label>Have coupon?</label>
                            <div class="input-group">
                                <input type="text" class="form-control" wire:model.lazy="coupon_code" placeholder="Coupon code">
                                <span class="input-group-append">
                                    <x-utils.button type="submit" wireTarget="applyCoupon" class="btn btn-success rounded">
                                        Apply
                                    </x-utils.button>
                                </span>
                            </div>
                            @error('coupon_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endif
</div>

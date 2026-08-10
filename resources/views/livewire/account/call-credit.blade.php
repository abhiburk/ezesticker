<div class="card shadow-sm position-relative">
    <x-utils.card-spinner/>
    <div class="card-body">
        <div class="card-title">
            <h4 class="pb-2 mb-2 d-flex justify-content-between align-items-center">
                Add credits to your wallet
                @if ($topup_amount != 0)
                    <button type="button" class="btn btn-link text-dark p-0 shadow-none" wire:click="selectedTopup()">
                        <i class="bi bi-x-lg"></i>
                    </button>
                @endif
            </h4>
            @if ($topup_amount == 0)
                <small class="text-muted d-block">Choose from the available topup pack</small>
            @endif
        </div>
        @if (CALL_SERVICE)
            <div class="row">
                <div class="col-lg-12 mt-2">
                    @if ($topup_amount == 0)
                        <div class="form-row">
                            <div class="col-12 my-1">
                                <div class="radio-toolbar row">
                                    @foreach (Helper::getCallTopUps() as $item)
                                        <div class="col-lg-2 col-sm-12">
                                            <input type="radio" id="{{ $loop->index }}" name="radios">
                                            <label for="{{ $loop->index }}" class="rounded border-warning" wire:click="selectedTopup('{{ Helper::encodeId($item) }}')">{{ INR }}{{ $item }} </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else 
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" wire:click="applyWalletBalance('{{ Helper::encodeId(intval(Cart::session(auth()->id())->getTotal())) }}', true)" class="custom-control-input" id="useWalletBalance" 
                                {{ $use_wallet == '1' ? 'checked' : '' }}
                                {{ round(auth()->user()->wallet->balanceFloat) <= 0 ? 'disabled' : ''}}
                                >
                                <label class="custom-control-label" for="useWalletBalance">
                                    Use wallet balance ({{ INR }}{{$this->wallet_balance}}) 
                                    <small wire:ignore><i class="bi bi-info-circle-fill" data-trigger="click" data-toggle="tooltip" title="You can use {{ MAX_WALLET_USAGE }}% of total from your wallet."></i></small>
                                </label> 
                            </div>
                        </div>
                        <dl class="d-flex justify-content-between">
                            <dt>Subtotal:</dt>
                            <dd class="text-right">{{ INR }} {{ Cart::session(auth()->id())->getSubTotal() }}</dd>
                        </dl>
                        @foreach(Cart::getConditions() as $condition)
                            <dl class="d-flex justify-content-between">
                                <dt>{{ $condition->getName() }}</dt>
                                <dd class="text-right {{ $condition->getType() == 'discount' ? 'text-success' : 'text-danger' }}">
                                    {{ $condition->getType() == 'discount' ? '-' : '+' }}
                                    {{ INR }} {{ $condition->getCalculatedValue(Cart::session(auth()->id())->getSubTotal()) }}
                                </dd>
                            </dl>
                        @endforeach
                        <dl class="d-flex justify-content-between">
                            <dt>Total:</dt>
                            <dd class="text-right text-dark"><strong>{{ INR }} {{ Cart::session(auth()->id())->getTotal() }}</strong></dd>
                        </dl>
                        <hr>
                        <x-utils.button type="button" wireTarget="payCallTopup" wire:click="payCallTopup" class="btn btn-warning btn-lg btn-block rounded">
                            Pay
                        </x-utils.button>
                    @endif
                </div>
            </div> 
        @else 
            Unavailable
        @endif
    </div>
</div>

@push('css')
    <style>
        .radio-toolbar input[type="radio"] {
            display: none;
        }
        .radio-toolbar label {
            background-color: #fff;
            padding: 10px 20px;
            cursor: pointer;
            width: 100%;
            text-align: center;
            border-width: 2px;
            border-style: solid;
        }
        .radio-toolbar input[type="radio"]:checked+label {
            background-color: #ffc107;
            color:#000
        }
        .radio-toolbar input[type="radio"]+label:hover {
            transition: transform .2s;
            transform: scale(1.1);
            background-color: #ffc107;
        }
    </style>
@endpush
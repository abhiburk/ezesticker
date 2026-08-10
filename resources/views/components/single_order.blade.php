@props(['order', 'walletUsage'])
<article class="card">
    <header class="card-header bg-white">
        <strong class="d-inline-block mr-3">Order ID: #{{ $order->id }}</strong>
        <span>Order Date: {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y h:i a') }}</span>
        <span class="font-weight-bold badge p-2 float-right {{ $order->status == 'Completed' ? 'badge-success ' : 'badge-dark ' }}">
            {{ $order->status }}
        </span>
    </header>
    @if (!empty($order->address))
        <div class="card-body">
            <div class="row"> 
                <div class="col-md-7">
                    <h6 class="text-muted">Delivery to</h6>
                    <address>
                        <p>{{ $order->address->name }} <br>  

                            {{ $order->address->phone ?? "" }} <br> 
                            {{ $order->address->email ?? "" }} <br> 
                            {{ $order->address->state ?? "" }} <br> 
                            @if (!empty($order->address->city))
                                City: {{ $order->address->city }} <br> 
                            @endif
                            @if (!empty($order->address->address_line_1))
                                Address Line 1: {{ $order->address->address_line_1 }} <br> 
                            @endif
                            @if (!empty($order->address->address_line_2))
                                Address Line 2: {{ $order->address->address_line_2 }} <br> 
                            @endif
                            @if (!empty($order->address->pincode))
                                Pincode: {{ $order->address->pincode }} <br> 
                            @endif
                        </p>
                    </address>
                </div>
            
                <div class="col-md-5">
                    <h6 class="text-muted">Payment</h6>
                    <small class="font-weight-bold badge {{ $order->order_transaction->status == 'Completed' ? 'badge-success ' : 'badge-dark ' }}">
                        {{ $order->order_transaction->status }}
                    </small>
                    <p>
                        <div class="row">
                            <div class="col-12">
                                <span class="d-flex justify-content-between">
                                    Subtotal:
                                    <span>{{ INR }} {{ $order->subtotal }}</span>
                                </span>
                            </div>
                            @if(isset($order->cart_conditions) && !empty($order->cart_conditions))
                                @foreach ($order->cart_conditions as $condition)
                                    <div class="col-12 d-flex justify-content-between">
                                        {{ $condition->getName() }}
                                        <span class="text-right {{ $condition->getType() == 'discount' ? 'text-success' : 'text-danger' }}">
                                            {{ $condition->getType() == 'discount' ? '-' : '+' }}
                                            {{ INR }} {{ $condition->getCalculatedValue($order->subtotal) }}
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                            <div class="col-12 my-2 border-top"></div>
                            <div class="col-12">
                                <b class="d-flex justify-content-between">
                                    Total:
                                    <span>{{ INR }} {{ $order->total }}</span>
                                </b>
                            </div>
                        </div>
                    </p>
                </div>
            </div>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <tbody>
                @foreach ($order->order_items as $item)
                    <tr >
                        <td width="65">
                            <img src="{{ url('storage/'. $item->product->featured_image) }}" class="img-xs " width="80">
                        </td>
                        <td> 
                            <p class="title mb-0">{{ $item->name }}</p>
                            <var class="price text-muted">{{ INR }}{{ $item->price }} x {{ $item->quantity }}</var>
                        </td>
                        @if ($order->type != 'Recharge')
                            <td> 
                                <div class=" float-right">
                                    <a href="{{ route('shop.slug', $item->product->slug) }}" class="btn btn-warning"> Details </a> 
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</article>
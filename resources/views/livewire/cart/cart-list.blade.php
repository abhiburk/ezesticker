<div>
    <article class="card card-body mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <figure class="itemside d-flex mb-0">
                    <div class="aside">
                        <img src="{{ url('storage/'. $item->associatedModel->featured_image) }}"
                            class=" img-sm" width=80>
                    </div>
                    <figcaption class="info px-2">
                        <a href="{{ route('shop.slug', $item->associatedModel->slug) }}">
                            <span class="text-muted font-weight-bold">
                                {{ $item->name }}
                                @if (!empty($item->associatedModel->prices->first()->discount))
                                    <small class="text-success ml-2">
                                        {{ 
                                            $item->associatedModel->prices->first()->discount_type == 'Percentage' ? 
                                            $item->associatedModel->prices->first()->discount.'% Off' : 
                                            INR.''.$item->associatedModel->prices->first()->discount. 'Off' 
                                        }}
                                    </small>
                                @endif
                            </span>
                        </a>
                        <div class="d-flex align-items-center">
                            @forelse ($item->getConditions() as $c)
                                {{ INR }}{{ round(($item->associatedModel->prices->first()->price - $c),2) }} 
                                <del class="price-old text-secondary ml-2"><small>{{ INR }}{{ $item->price }}</small></del>
                            @empty
                                {{ INR }}{{ $item->associatedModel->prices->first()->price }}
                            @endforelse
                        </div>
                        
                    </figcaption>
                </figure>
            </div>
            <div class="col">
                <div class="input-group input-spinner">
                    <div class="input-group-prepend">
                        <button class="btn btn-light" type="button" id="button-plus" wire:click="decrement"> 
                            <i class="fa fa-minus"></i> 
                        </button>
                    </div>
                    <input type="text" class="form-control" wire:model.lazy="quantity">
                    <div class="input-group-append">
                        <button class="btn btn-light" type="button" id="button-minus" wire:click="increment"> 
                            <i class="fa fa-plus"></i> 
                        </button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="price h5 m-0"> 
                    {{ INR }}{{ $item->getPriceSumWithConditions() }} 
                </div>
            </div>
            <div class="col flex-grow-0 text-right">
                <a href="#" wire:click.prevent="removeItemFromCart('{{ $item->id }}')" class="btn btn-light"> <i class="fa fa-times"></i> </a>
            </div>
        </div>
    </article>
</div>

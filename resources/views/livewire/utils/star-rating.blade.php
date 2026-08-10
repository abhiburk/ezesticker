<div class="rating-wrap">
    <ul class="rating-stars">
        <li style="width:{{ $rating*20 }}%" class="stars-active">
            @for ($i = 1; $i <= 5; $i++)
                <a href="#" wire:click.prevent="rating('{{ $i }}')">
                    <i class="fa fa-star"></i> 
                </a>
            @endfor
        </li>
        <li>
            @for ($i = 1; $i <= 5; $i++)
                <a href="#" wire:click.prevent="rating('{{ $i }}')">
                    <i class="fa fa-star"></i> 
                </a>
            @endfor
        </li>
    </ul>
</div>
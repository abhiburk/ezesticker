@props(['rating'])
<ul class="rating-stars">
    <li style="width:{{ $rating*20 }}%" class="stars-active">
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa fa-star"></i> 
        @endfor
    </li>
    <li>
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa fa-star"></i> 
        @endfor
    </li>
</ul> 
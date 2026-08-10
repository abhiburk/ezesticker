<div class="col-sm-12 col-lg-4 mt-4  d-none d-lg-block">
    <div class="list-group">
        @foreach (Helper::getProfileRoute() as $item)
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ Request::is('*/'.$item['route'].'/*') || Request::is('*/'.$item['route']) ? 'active':"" }}" href="{{ route('account.'.$item['route']) }}"> 
                <span>{{ $item['label'] }} </span>
                <i class="fa {{ $item['icon'] }}"></i> 
            </a>
        @endforeach
    </div>
</div>
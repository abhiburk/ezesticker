<div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text bg-white"><i class="fa fa-search"></i></span>
        </div>
        <input type="text" class="form-control shadow-none" placeholder="Search..." wire:model.debounce.500ms="search">
    </div>
    <ul class="list-unstyled chat-list mt-2 mb-0" style="overflow-y: auto;" wire:loading.delay.class="opacity-2" wire:target="search">
        @forelse ($users as $item)
            <li class="clearfix {{ isset($receiver->id) ? ($receiver->id == $item->id ? 'active' : '') : '' }}">
                <a href="#" class="btn shadow-none p-0 d-flex justify-content-start align-items-center text-dark text-left" wire:click.prevent="$emit('fromUserList', '{{ Helper::encodeId($item->id) }}', true)">
                    {{-- <span data-letters="{{ Helper::firstLetter($item->name) }}" style="font-size:1em;"></span> --}}
                    <x-utils.avtar src="{{ $item->getUserImageUrl() }}" name="{{ $item->name }}" width="50" height="50"/>
                    <div class="about">
                        <div class="name">{{ $item->name }}</div>
                        <small class="status"> 
                            @if(Cache::has('is_online' . $item->id))
                                <i class="fa fa-circle online"></i> online
                            @else
                                <i class="fa fa-circle online text-secondary"></i> {{ Carbon::parse($item->last_seen)->diffForHumans() }}
                            @endif
                        </small>
                    </div>
                    <span class="badge badge-danger ml-3 badge-pill read-{{ $item->id }}">{{ $item->unread > 0 ? $item->unread : '' }}</span>
                </a>
            </li>
            <div class="is-flex justify-content-center text-center">
                <span class="m-0"></span>
            </div>
        @empty 
            <p class="p-4 text-center text-secondary">
                No Chat User Found
            </p>
        @endempty
    </ul>
</div>
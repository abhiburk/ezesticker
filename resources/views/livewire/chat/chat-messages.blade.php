<ul class="m-b-0 chat-user-messages js-chatbox-display">
    @if ($perPage <= $totalMessages)
        <div class="col-sm-12 previous text-center"> 
            <x-utils.button type="submit"  wire:click="loadMore({{$perPage+5}})" wireTarget="loadMore" class="btn btn-link shadow-none">
                Show Previous Message!
            </x-utils.button>
        </div>
    @endif
    @php
        $old_date = Carbon::now();
    @endphp
    @foreach ($messages as $item)
        <li class="clearfix">
            @if (Carbon::parse($old_date)->format('d-m-Y') != Carbon::parse($item->created_at)->format('d-m-Y'))
                <p class="text-center text-secondary">
                    <small>
                        @if(Carbon::parse($item->created_at)->format('d-m-Y') == Carbon::now()->format('d-m-Y'))
                            Today
                        @else
                            {{ Carbon::parse($item->created_at)->format('d-m-Y') }}
                        @endif
                    </small>
                </p>
            @endif
            <div class="message-data {{ auth()->user()->id == $item->sender_id ? 'text-right ' : ''}}">
                <small class="text-secondary message-data-time">{{ Carbon::parse($item->created_at)->format('h:i a') }} </small>
            </div>
            <div class=" {{ auth()->user()->id == $item->sender_id ? 'text-right float-right' : ''}}">
                <div class="message {{ auth()->user()->id == $item->sender_id ? 'other-message' : 'my-message'}} "> 
                    {{ $item->message }}
                </div>
                @if (auth()->user()->id == $item->sender_id && $item->read_at != null && $loop->last)
                    <br>
                    <small class="msg-time text-secondary" title="{{ $item->read_at }}">
                        Seen
                    </small>
                @endif
            </div>
        </li>
        @php
            $old_date = $item->created_at;
        @endphp
    @endforeach
</ul>
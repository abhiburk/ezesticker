<a class="nav-link {{ auth()->user()->receive_messages()->where('read_at', null)->count() > 0 ? 'font-weight-bold has-unread' : 'font-weight-normal'}} " href="{{ route('account.message') }}">
    <i class="bi bi-chat-right"></i>
    Messages {!! auth()->user()->receive_messages()->where('read_at', null)->count() > 0 ? '<i class="fa fa-circle ml-2 text-danger" style="font-size: 5px;"></i>' : '' !!}
</a>
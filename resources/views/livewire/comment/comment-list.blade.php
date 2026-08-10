<div class="col-md-9 mt-3">
    <header class="section-heading d-flex justify-content-between align-items-center">
        <h3>Reviews</h3>
        {{ $comments->links() }}
    </header>

    @forelse ($comments as $item)

        {{-- show un approved comments to the comment owner only --}}
        @if ($item->is_approved == 1 || (Auth::check() && auth()->user()->id == $item->user->id))

            <article class="box mb-3">
                <div class="icontext w-100">
                    {{-- <img src="bootstrap-ecommerce-html/images/avatars/avatar1.jpg" class="img-xs icon rounded-circle"> --}}
                    <div class="text">
                        <span class="date text-muted float-md-right">
                            {{ Carbon::parse($item->created_at)->format('d F, Y') }}
                        </span>
                        <h6 class="mb-1">{{ $item->user->name }}
                            <small class="text-danger">{{ $item->is_approved == 0 ? 'Yet to Approve' : '' }}</small>
                        </h6>
                        @if ($item->rating != null)
                            <x-utils.rating :rating='$item->rating' />
                        @endif
                    </div>
                </div>
                <div class="mt-3">
                    <p>
                        {{ $item->body }}
                    </p>
                </div>
            </article>

        @endif

    @empty
        <p>
            No Comments..
        </p>
    @endforelse
</div>

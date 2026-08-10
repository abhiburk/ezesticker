<div>
    @guest
        <p class="text-center">
            You need to be logged in to submit review. 
            <a href="#" data-toggle="modal" data-target="#authModal">Click here to login</a>
        </p>
    @else 
        <form wire:submit.prevent="store">
            <div class="form-group">
                <label for="comment">Your rating</label>
                @livewire('utils.star-rating')
            </div>
            <div class="form-group">
                <label for="comment">Your review</label>
                <textarea wire:model="comment" class="form-control shadow-none rounded-0" id="comment" cols="30" rows="3"></textarea>
                @error('comment')
                    <small id="helpId" class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <x-utils.button class="btn btn-warning float-right" wireTarget="store" type="submit">
                    Comment
                </x-utils.button>
            </div>
        </form>
    @endguest
</div>
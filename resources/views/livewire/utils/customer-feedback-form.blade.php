<div class="card shadow text-center">
    @if (!empty($last) && ($success || $last->user_id == auth()->id()))
        <div class="card-body">
            <i class="bi bi-check2-circle text-success success-icon"></i>
            <div>
                <h1 class="font-weight-bold">Thank You !</h1>
                <h5>Thankyou for your valuable feedback.</h5>
                <small class="text-muted">
                    We have receive your feedback and we'll review it for future customer experience
                </small>
            </div>
        </div>
    @else
        <div class="card-header bg-white d-flex align-items-center justify-content-center">
            <h4 class="font-weight-bold">Rate Your Experience</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">
                How do you feel about our service?
            </h5>
            <form wire:submit.prevent="store"> 
                <div class="my-5">
                    @livewire('utils.star-rating')
                    <div class="mt-3">
                        @error('feedback.rating')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="feedback__textarea">
                    <textarea id="textarea" wire:model.defer="feedback.comment" class="form-control shadow-none" rows="5"></textarea>
                    <label for="textarea">We value your feedback</label>
                </div>
                <input type="hidden" wire.model.defer="feedback.source">
                <input type="hidden" wire.model.defer="feedback.rating">
                <div class="d-flex justify-content-end">
                    <x-utils.button type="submit" class="btn btn-warning" wireTarget="store">Submit</x-utils.button>
                </div>
            </form>
        </div>
        @endif
</div>
@push('css')
    <style>
        .rating-stars i {
            font-size: 50px;
        }

        @media (max-width: 992px) {
            .success-icon{
                font-size: 5em;
            }
            .rating-stars i {
                font-size: 35px;
            }
        }
    </style>
@endpush
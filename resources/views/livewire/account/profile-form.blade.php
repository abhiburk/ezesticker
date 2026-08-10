<div>
    <h4 class="card-title mb-4">Profile</h4>
    <form wire:submit.prevent="profile">
        
        <div class="form-row">
            <div class="col-lg-6 col-sm-12 form-group">
                <label>Name</label>
                <input type="text" wire:model.lazy="user.name" class="form-control">
                @error('user.name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-lg-6 col-sm-12 form-group">
                <label>
                    Email
                    @empty(auth()->user()->email_verified_at)
                        @if (!empty(auth()->user()->email))
                            <a href="#" wire:click.prevent="send_otp_at('{{ $user->email }}', 'email')">Verify</a>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                            wire:loading wire:target="send_otp_at"></span>
                        @endif
                        @else 
                        <i class="fa fa-check-circle text-success"></i>
                    @endempty
                </label>
                <input type="email" wire:model.lazy="user.email" class="form-control">
                @error('user.email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>
                    Phone
                    @empty(auth()->user()->phone_verified_at)
                        <a href="#" wire:click.prevent="send_otp_at('{{ $user->phone }}', 'phone')">Verify</a>
                        {{-- <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                        wire:loading wire:target="send_otp_at"></span> --}}
                    @else 
                        <i class="fa fa-check-circle text-success"></i>
                    @endempty
                </label>
                <input type="text" wire:model.lazy="user.phone" class="form-control">
                @error('user.phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <x-utils.button 
            type="submit"
            wireTarget="profile"
            class="btn btn-warning btn-block rounded">
            Save
        </x-utils.button>
    </form>
</div>

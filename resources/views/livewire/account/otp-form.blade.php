<div>
    <form wire:submit.prevent="verify">
        <p>
            Enter the 6-digit code sent to <br> 
            {{ session('verification_type') == 'phone' ? '+91 '.session('sent_to') : session('sent_to') }}  
        </p>
        <div class="form-group d-flex">
            Didn't receive an SMS?
            <a href="#" wire:click.prevent="send_otp(true)" class="d-flex align-items-center ml-2">
                Resend <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                wire:loading wire:target="send_otp"></span>
            </a>
        </div>
        <div class="form-row">
            
            <div class="col-lg-12 form-group">
                <label>OTP</label>
                <input type="text" wire:model.lazy="otp" class="form-control" placeholder="Enter 6 digit code">
                @error('otp')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <x-utils.button type="submit" wireTarget="verify" class="btn btn-warning btn-lg btn-block rounded">
            Verify
        </x-utils.button>
    </form>
</div>

 <div >
     @if (!$show_otp_field)
         <form wire:submit.prevent="sendOtp" >
             <div class="form-row mx-n2">
                 <div class="col-sm-12 col-12 px-2">
                     <div class="form-group">
                         <div class="d-flex justify-content-between align-items-center">
                             <label for="phone" class="text-heading">Phone Number</label>
                         </div>
                         <div class="input-group mt-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-top-0 border-right-0 border-left-0 rounded-0">+91</span>
                            </div>
                            <input type="phone" wire:model="phone" class="form-control border-right-0 border-top-0 rounded-0 shadow-none" id="phone" placeholder="Enter 10 digit mobile number">
                         </div>
                         @error('phone') <span class="text-danger mt-3">{{ $message }}</span> @enderror
                     </div>
                     <x-utils.button 
                        :disabled="$is_phone_valid ? false : true" 
                        wireTarget="sendOtp"
                        type="submit"
                        class="btn btn-warning btn-lg btn-block rounded">
                        GET OTP
                     </x-utils.button>
                 </div>
             </div>
         </form>
     @else
         <form wire:submit.prevent="login" >
             <div class="form-row mx-n2">
                 <div class="col-sm-12 col-12 px-2"> 
                    <p class="d-flex align-items-center justify-content-start">
                        <small class="mr-2">
                            Enter the 6-digit code sent to +91 {{ $phone }}
                            <span class="d-flex">
                                Didn't receive the SMS?
                                <a href="#" wire:click.prevent="sendOtp(true)" class="d-flex align-items-center ml-2">
                                    Resend <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                    wire:loading wire:target="sendOtp"></span>
                                </a>
                            </span>
                        </small>
                    </p>
                   
                    @if (Auth::check() && auth()->user()->phone != $phone)
                        <p class="text-muted mb-2 alert alert-info">
                            <small>
                                You are logged in with <b>+91 {{ auth()->user()->phone }}</b>
                                and seems that you are trying to link QR sticker with a new mobile no.
                                After verification you'll be logged in with the {{ $phone }} number.
                            </small>
                        </p>
                        <hr class="mb-3">
                    @endif
                    @empty($user->phone_verified_at)
                        <div class="form-group">
                            <label for="name" class="text-heading">Full Name</label>
                            <input type="text" wire:model="name"
                                class="form-control border-bottom-only rounded-0 shadow-none " id="name"
                                placeholder="Enter your name">
                            @error('name') <span class="text-danger mt-3">{{ $message }}</span> @enderror
                        </div>
                    @endempty

                    <div class="form-group">
                        <label for="otp" class="text-heading">OTP</label>
                        <input type="text" wire:model="otp"
                            class="form-control border-bottom-only rounded-0 shadow-none " id="otp"
                            placeholder="6 Digit Otp">
                        @error('otp') <span class="text-danger mt-3">{{ $message }}</span> @enderror
                    </div>
                    
                    @if (!empty($qr_code_id) && $login_source != 'modal')
                        <div class="form-group">
                            <span class="d-flex">
                                Have a referral code?
                                <a href="#" wire:click.prevent="showReferral" class="d-flex align-items-center ml-2">
                                    Click here
                                </a>
                            </span>
                        </div>
                    @endif
                    @if ($show_referral)
                        <div class="form-group">
                            <label for="referral_code" class="text-heading">Referral Code</label>
                            <input type="text" wire:model="referral_code"
                                class="form-control border-bottom-only rounded-0 shadow-none" placeholder="Enter referral code" id="referral_code">
                            @error('referral_code') <span class="text-danger mt-3">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <x-utils.button type="submit" wireTarget="login" class="btn btn-warning btn-lg btn-block rounded">
                        {{ empty($user->phone_verified_at) ? 'Register' : 'Login' }}
                    </x-utils.button>
                    <div class="text-center">
                        <a href="#" class="btn btn-link shadow-none" wire:click.prevent="backToLogin">
                            <small>Try with another number</small>
                        </a>
                    </div>
                 </div>
             </div>
         </form>
     @endif 
 </div>

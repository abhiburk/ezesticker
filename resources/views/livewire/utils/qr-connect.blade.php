<div>
    
    @if ($call_status)

        <div class="row">
            <div class="col-12">
                <div class="alert alert-success border-0">
                    <h4 class="alert-heading">Hold on!</h4>
                    You'll receive a call within 2-3 second from one of our virtual number, 
                    once you pick it you'll be quickly connected to the owner automatically.
                    <a href="#" wire:click.prevent="callAgain(false)">Call Again</a>
                </div>
            </div>
        </div>

    @else

        <div class="row">
            <div class="col mt-2">
                <span title="Send a Message">
                    {{-- if it is self user --}}
                    @if (Auth::check() && $qr_detail->user_id == auth()->user()->id)
                        <button class="btn btn-warning d-block w-100" disabled> <i class="bi bi-chat-right"></i></button>
                    @else
                        <a href="{{ route('account.message', ['user_id' => Helper::encodeId($qr_detail->user_id), 'qr_code_id' => Helper::encodeIdForQr($qr_detail->id)]) }}" class="btn btn-warning d-block w-100">
                            <i class="bi bi-chat-right"></i>
                        </a>
                    @endif
                </span>
            </div>
            <div class="col mt-2">
                <span title="Send SMS to Owner">
                    @auth
                        @if ($qr_detail->user_id == auth()->user()->id) 
                            <button class="btn btn-warning d-block w-100" disabled >SMS</button>
                        @else
                            <button data-toggle="modal" data-target="#openSmsText" class="btn btn-warning d-block w-100">SMS</button>
                        @endif
                    @else 
                        <button class="btn btn-warning d-block w-100" disabled >SMS</button>
                    @endauth
                </span>
            </div>
            {{-- Check call Wallet has minimum Rs 2 --}}
            @if ($qr_detail->user->getWallet('call-wallet')->balanceFloat >= CALL_MIN_BALANCE && $qr_detail->call_status == 'Active')
                <div class="col mt-2">
                    <span  title="{{ CALL_SERVICE ? 'Call Owner' : 'Calling feature coming soon' }}">
                        @auth
                            @if ($qr_detail->user_id == auth()->user()->id  || CALL_SERVICE == false)
                                <button class="btn btn-warning d-block w-100" disabled ><i class="bi bi-telephone"></i></button>
                            @else
                                <x-utils.button type="button" data-type='primary' wireTarget="makeCall('primary')" class="btn btn-warning d-block w-100 make-call">
                                    <i class="bi bi-telephone"></i>
                                </x-utils.button>
                            @endif
                        @else
                            @if (Auth::check() && $qr_detail->user_id == auth()->user()->id)
                                <button class="btn btn-warning d-block w-100" disabled ><i class="bi bi-telephone"></i></button>
                            @else
                                <button class="btn btn-warning d-block w-100" data-toggle="modal" data-target="#openPhoneVerification">
                                    <i class="bi bi-telephone"></i>
                                </button>
                            @endif
                        @endif
                    </span>
                </div>
            @endif
        </div>

        {{-- Check call Wallet has minimum Rs 2 --}}
        @if ($qr_detail->user->getWallet('call-wallet')->balanceFloat >= CALL_MIN_BALANCE && $qr_detail->call_status == 'Active')
            <hr>
            <span  title="{{ CALL_SERVICE ? 'Call Emergency Phone no' : 'Calling feature coming soon' }}">
                {{-- Disabled buttons for qr owner --}}
                @if ((Auth::check() && $qr_detail->user_id == auth()->user()->id) || CALL_SERVICE == false)
                    <button class="btn btn-outline-danger d-block my-4 w-100" disabled >Call Emergency Contact</button>
                @else
                    @auth
                        @if (!empty($qr_detail->emergency_phone) && !empty($qr_detail->emergency_phone_verified_at))
                            @if ($qr_detail->is_emergency_phone_hidden == 1)
                                <x-utils.button type="button" data-type='emergency' wireTarget="makeCall('emergency')" class="btn btn-outline-danger d-block my-4 w-100 make-call">
                                    Call Emergency Contact
                                </x-utils.button>
                            @else 
                                <a href="tel:{{ $qr_detail->emergency_phone }}"  class="btn btn-outline-danger d-block my-4">
                                    Direct Emergency Call
                                </a>
                            @endif
                        @endif
                    @else
                        <a href="#" class="btn btn-outline-danger d-block my-4 w-100" data-toggle="modal" data-target="#openPhoneVerification">
                            Call Emergency Contact
                        </a>
                    @endif
                @endif
            </span>
        @endif

        {{-- SMS Modal --}}
        <div class="modal fade" wire:ignore.self id="openSmsText" data-backdrop="static" data-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content  shadow-lg">
                    <form wire:submit.prevent="sendSms">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="staticBackdropLabel">Send SMS to {{ $qr_detail->user->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <textarea wire:model.defer="message" placeholder="We'll send SMS on users mobile no." id="sms_message" cols="30" rows="3" class="border-bottom-only rounded-0 p-0 form-control shadow-none" style="resize: none;"></textarea>
                                    @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col d-lg-flex justify-content-between align-items-center">
                                    <span title="Quickly send a message" >
                                        <a type="button" data-toggle="collapse" data-target="#collapseOne">
                                            <i class="bi bi-lightning-charge"></i> Quick Message
                                        </a>
                                    </span>
                                    <div class="d-flex align-items-center justify-content-between justify-content-lg-start">
                                        @if (!empty($qr_detail->emergency_phone) && !empty($qr_detail->emergency_phone_verified_at))
                                            <div class="custom-control custom-checkbox  mr-2" title="Sent to emergency contact" >
                                                <input type="checkbox" class="custom-control-input" id="to-emergency-contact" wire:model="sms_to_emergency" value="1">
                                                <label class="custom-control-label" for="to-emergency-contact" >Emergency Phone</label>
                                            </div>
                                        @endif
                                        <x-utils.button class="btn btn-warning btn-sm" type="submit" wireTarget="sendSms">
                                            Send
                                        </x-utils.button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col">
                                    <div class="collapse multi-collapse" id="collapseOne">
                                        <ul class="list-group list-group-flush overflow-auto" style="height:20em;">
                                            @foreach ($sms_options as $item)
                                                <li class="list-group-item">
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="{{ $loop->iteration }}" wire:click="selectedSms('{{ $item->name }}')" name="selected_sms" class="custom-control-input">
                                                        <label class="custom-control-label" for="{{ $loop->iteration }}">{{ $item->name }}</label>
                                                    </div>
                                                </li>
                                            @endforeach 
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>

        {{-- Register Before Call --}}
        @if (!Auth::check())
            <div class="modal fade" wire:ignore.self id="openPhoneVerification" data-backdrop="static" data-keyboard="false" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Verify Your Mobile Number</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="alert alert-warning">
                                <small>
                                    We use advanced data protection to ensure the privacy of both caller & receiver's mobile no.
                                    <span class="d-block">
                                        Please register/login yourself so we could connect you via encrypt call.
                                        It'll take just 10 seconds.
                                    </span>
                                </small>
                            </p>
                            @livewire('auth.login-form', ['qr_code_id' => request()->qr_code_id])
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @endif
</div>

@push('js')
    <script>
        $(document).on('click', ".make-call",  function(){
            var type = $(this).data('type');
            $.confirm({
                title: 'Encryption Call Flow',
                content: "You'll receive a call from our virtual no. once you pick it we will connect your call to the owner without sharing your mobile no.",
                type: 'orange',
                animateFromElement: false,
                theme: "modern",
                buttons: {
                    confirm: {
                        text: 'Confirm Call',
                        btnClass: 'btn-warning',
                        action: function(){
                            @this.call('makeCall', type);
                        }
                    },
                    close: function () {
                    }
                }
            });
        });
    </script>
@endpush
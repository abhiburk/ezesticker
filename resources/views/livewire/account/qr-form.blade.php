<div> 
    <div class="card">
        <div class="card-body">
            <h4 class="card-title border-bottom pb-2 mb-4 d-flex justify-content-between">
                QR Sticker Details
                <small class="text-dark">
                    Verified on {{ Carbon::parse($qr_detail->created_at)->format('Y-F-d') }}
                </small> 
            </h4>
            <form wire:submit.prevent="store">
                <div class="row mt-4">
                    <div class="col-lg-5 d-flex align-items-center">
                        <small class="text-muted">
                            What is this QR sticker for ?
                        </small>
                    </div>
                    <div class="col-lg-7 ">
                        <div class="form-group">
                            <label for="qr_usage">Qr Sticker is for?</label>
                            <input type="text" wire:model.defer="qr_detail.qr_usage" id="qr_usage" class="form-control w-100" placeholder="Car, Pet or any other"/>
                            @error('qr_detail.qr_usage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-5 d-flex align-items-center">
                        <small class="text-muted">
                            Will be visible when someone scan your QR Code. Contact will be visible only when you verify the emergency contact.
                        </small>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-group">
                            <label for="emergency_phone">
                                Emergency Phone
                                {{-- @empty($qr_detail->emergency_phone_verified_at)
                                    @if (!empty($qr_detail->emergency_phone))
                                        <a href="#" wire:click.prevent="send_otp_at('{{ $qr_detail->emergency_phone }}', 'emergency_phone')">Verify</a>
                                    @endif
                                @else 
                                    <i class="fa fa-check-circle text-success"></i>
                                @endempty --}}
                            </label>
                            <input type="text" id="emergency_phone" wire:model.defer="qr_detail.emergency_phone" class="form-control">
                            @error('qr_detail.emergency_phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div> 
                <div class="row mt-4">
                    <div class="col-lg-5 d-flex align-items-center">
                        <small class="text-muted">
                            Write a message to the user who will see this message when QR Sticker is scan.
                        </small>
                    </div>
                    <div class="col-lg-7 ">
                        <div class="form-group">
                            <label for="message"> Your Message ({{ strlen($qr_detail->message) }}/255)</label>
                            <textarea wire:model="qr_detail.message" id="message" rows="3" class="form-control w-100" placeholder="Message to show when someone scan your sticker"></textarea>
                            @error('qr_detail.message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-5 d-flex align-items-center">
                        <small class="text-muted">
                            Blood group is essentials in accedental situations. It would be helpful to save this detail.
                        </small>
                    </div>
                    <div class="col-lg-7 ">
                        <div class="form-group">
                            <label for="blood_group"> Blood Group</label>
                            <select wire:model="qr_detail.blood_group" class="custom-select" id="blood_group">
                                <option value="">Select an option</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                            @error('qr_detail.message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-5 d-flex align-items-center">
                        <small class="text-muted">
                            Deactivate the QR code if you do not want anyone to contact you through this QR Code.
                        </small>
                    </div>
                    <div class="col-lg-7 ">
                        <div class="form-group">
                            <label for="status" class="d-block">QR Sticker Status</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" wire:model="qr_detail.status" value="Active" id="customRadioInline1" name="customRadioInline" class="custom-control-input">
                                <label class="custom-control-label" for="customRadioInline1">Active</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" wire:model="qr_detail.status" value="InActive" id="customRadioInline2" name="customRadioInline" class="custom-control-input">
                                <label class="custom-control-label" for="customRadioInline2">InActive</label>
                            </div>
                            @error('qr_detail.status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-5 d-flex align-items-center">
                        <small class="text-muted">
                            Deactivate calls if you no longer wants to receive on this ezesticker.
                        </small>
                    </div>
                    <div class="col-lg-7 ">
                        <div class="form-group">
                            <label for="call_status" class="d-block">Call Status</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" wire:model="qr_detail.call_status" value="Active" id="call_status_active" name="call_status_active" class="custom-control-input">
                                <label class="custom-control-label" for="call_status_active">Active</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" wire:model="qr_detail.call_status" value="InActive" id="call_status_inactive" name="call_status_inactive" class="custom-control-input">
                                <label class="custom-control-label" for="call_status_inactive">InActive</label>
                            </div>
                            @error('qr_detail.call_status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-5 d-flex align-items-center">
                        <small class="text-muted">
                            Unchecking this option allows users to make a direct call to your emergency number. 
                            Default to Disabed.
                        </small>
                    </div>
                    <div class="col-lg-7 ">
                        <div class="form-group">
                            <label for="is_phone_hidden" class="d-block">Emergency Phone Number Privacy</label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" wire:model="qr_detail.is_emergency_phone_hidden" class="custom-control-input" id="is_phone_hidden">
                                <label class="custom-control-label" for="is_phone_hidden">Disable direct call</label>
                            </div>
                            @error('qr_detail.is_phone_hidden')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>
                </div>  
                <div class="form-group mt-3">
                    <x-utils.button 
                        type="submit"
                        wireTarget="store"
                        class="btn btn-warning btn-block rounded">
                        Save
                    </x-utils.button>
                </div>
            </form>
        </div>
    </div>
</div>

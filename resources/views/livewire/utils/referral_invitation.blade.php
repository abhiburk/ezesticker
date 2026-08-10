<div class="row mt-5 mb-3">
    <div class="col-12 mb-2">
        <label for="on_whatsapp">Refer through Whatsapp</label>
        <div class="input-group">
            <div class="input-group-prepend ">
                <span class="input-group-text bg-transparent"><i class="fab fa-whatsapp"></i></span>
            </div>
            <input type="number" maxlength="10" id="on_whatsapp" wire:model.defer="whatsapp_no" class="form-control" />
            <div class="input-group-append">
                <x-utils.button wireTarget="onReferralShare('whatsapp')" class="btn btn-warning" wire:click="onReferralShare('whatsapp')" type="button">
                    <i class="fab fa fa-paper-plane"></i>
                </x-utils.button>
            </div>
        </div>
        @error('whatsapp_no')
            <small class="text-danger">{{ $message }}</small>    
        @enderror
    </div>
    <div class="col-12 mb-2">
        <label for="on_email">Refer through Email</label>
        <div class="input-group">
            <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent"><i class="bi bi-envelope"></i></span>
            </div>
            <input type="email" id="on_email" wire:model.defer="email_id" class="form-control" />
            <div class="input-group-append">
                <x-utils.button wireTarget="onReferralShare('email')" class="btn btn-warning" wire:click="onReferralShare('email')" type="button">
                    <i class="fab fa fa-paper-plane"></i>
                </x-utils.button>
            </div>
        </div>
        @error('email_id')
            <small class="text-danger">{{ $message }}</small>    
        @enderror
        
    </div>
    <div class="col-12 mb-2">
        <label for="on_sms">Refer through SMS</label>
        <div class="input-group">
            <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent"><i class="bi bi-chat-square-dots"></i></span>
            </div>
            <input type="number" maxlength="10" id="on_sms" wire:model.defer="sms_no" class="form-control" />
            <div class="input-group-append">
                <x-utils.button wireTarget="onReferralShare('sms')" class="btn btn-warning" wire:click="onReferralShare('sms')" type="button">
                    <i class="fab fa fa-paper-plane"></i>
                </x-utils.button>
            </div>
        </div>
        @error('sms_no')
            <small class="text-danger">{{ $message }}</small>    
        @enderror
        
    </div>
</div>

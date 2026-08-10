<div>
    
    <div class="mt-4">
        <h4 class="card-title">Billing Address</h4>
        @if($address_type != 'billing')
            <a href="#" wire:click.prevent="toggleAddress('billing')">Edit</a>
        @endif
    </div>

    @if($address_type == 'billing')
        <div class="custom-control custom-checkbox my-4">
            <input type="checkbox" wire:model="address.is_default"
            wire:click="setDefaultAddress" class="custom-control-input" id="different-address" value="1" {{ empty($address->created_at)? 'disabled' : '' }}>
            <label class="custom-control-label" for="different-address"> Use this as default for placing order</label>
        </div>
        <form wire:submit.prevent="storeAddress">
            
            <div class="form-row">
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>Name</label>
                    <input type="text" wire:model.lazy="address.name" class="form-control" value="{{ $address->name }}" disabled readonly>
                    @error('address.name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>Phone</label>
                    <input type="address.phone" wire:model.lazy="address.phone" class="form-control" value="{{ $address->phone }}" disabled readonly>
                    @error('address.phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>Country</label>
                    <input type="text" wire:model.lazy="country" class="form-control" value="{{ $country }}" disabled readonly>
                    @error('address.country')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>State</label>
                    <select class="custom-select" wire:model.lazy="address.state">
                        <option value="">Select an option</option>
                        @foreach ($states as $item)
                            <option {{ $address->state == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                    @error('address.state')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12">
                    <label>Address Line 1</label>
                    <input type="text" wire:model.lazy="address.address_line_1" class="form-control" value="{{ $address->phone }}">
                    @error('address.address_line_1')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> 
            </div>
            <div class="form-row">
                <div class="form-group col-lg-6 col-12">
                    <label>Address Line 2</label>
                    <input type="text" wire:model.lazy="address.address_line_2" class="form-control" value="{{ $address->address_line_2 }}">
                    @error('address.address_line_2')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col">
                    <label>City</label>
                    <input type="text" wire:model.lazy="address.city" class="form-control" value="{{ $address->city }}">
                    @error('address.city')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>Pincode</label>
                    <input type="text" wire:model.lazy="address.pincode" class="form-control" value="{{ $address->pincode }}">
                    @error('address.pincode')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>Email</label>
                    <input type="email" wire:model.lazy="address.email" class="form-control" value="{{ $address->email }}">
                    @error('address.email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <x-utils.button 
                type="submit"
                wireTarget="storeAddress"
                class="btn btn-warning btn-block rounded">
                Save
            </x-utils.button>
        </form>
    @endif

    <hr>
    <div class="mt-4">
        <h4 class="card-title d-flex align-items-center"> 
            Other Address
        </h4>
        @if($address_type != 'other')
            <a href="#" wire:click.prevent="toggleAddress('other')">Edit</a>
        @endif
    </div>
    
    @if($address_type == 'other')
        <div class="custom-control custom-checkbox my-4">
            <input type="checkbox" wire:model="address.is_default"
            wire:click="setDefaultAddress" class="custom-control-input" id="different-address" value="1"
            {{ empty($address->created_at)? 'disabled' : '' }}>
            <label class="custom-control-label" for="different-address"> Use this as default for placing order</label>
        </div>
        <form wire:submit.prevent="storeAddress">
                
            <div class="form-row">
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>Name</label>
                    <input type="text" wire:model.lazy="address.name" class="form-control" value="{{ $address->name }}">
                    @error('address.name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>Pincode</label>
                    <input type="text" wire:model.lazy="address.pincode" class="form-control" value="{{ $address->pincode }}">
                    @error('address.pincode')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>Phone</label>
                    <input type="phone" wire:model.lazy="address.phone" class="form-control" value="{{ $address->phone }}">
                    @error('address.phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>Email</label>
                    <input type="email" wire:model.lazy="address.email" class="form-control" value="{{ $address->email }}">
                    @error('address.email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>Country</label>
                    <input type="text" wire:model.lazy="country" class="form-control" value="{{ $country }}" disabled readonly>
                    @error('address.country')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6 col-sm-12 form-group">
                    <label>State</label>
                    <select class="custom-select" wire:model.lazy="address.state">
                        <option value="">Select an option</option>
                        @foreach ($states as $item)
                            <option {{ $address->state == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                    @error('address.state')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12">
                    <label>Address Line 1</label>
                    <input type="text" wire:model.lazy="address.address_line_1" class="form-control" value="{{ $address->phone }}">
                    @error('address.address_line_1')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> 
            </div>
            <div class="form-row">
                <div class="form-group col-lg-6 col-12">
                    <label>Address Line 2</label>
                    <input type="text" wire:model.lazy="address.address_line_2" class="form-control" value="{{ $address->address_line_2 }}">
                    @error('address.address_line_2')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col">
                    <label>City</label>
                    <input type="text" wire:model.lazy="address.city" class="form-control" value="{{ $address->city }}">
                    @error('address.city')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <x-utils.button 
                type="submit"
                wireTarget="storeAddress"
                class="btn btn-warning btn-block rounded">
                Save
            </x-utils.button>
        </form>
    @endif
    
</div>

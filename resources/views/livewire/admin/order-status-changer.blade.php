<div>
    <div class="form-group">
        <label for="status">Order Status</label>
        <select wire:model="order_status" id="status" class="custom-select">
            <option value="">Select an option</option>
            @foreach (Helper::orderStatus() as $item)
                <option>{{ $item['name'] }}</option>
            @endforeach
        </select>
    </div>
    
    @if ($order_status != 'Completed')
        <div class="form-group">
            <label for="content">Email Content</label>
            <textarea wire:model="content" class="form-control" id="content" cols="30" rows="3"></textarea>
        </div>
    @endif
    
    <div class="form-group">
        <x-utils.button class="btn btn-primary btn-sm float-right" wireTarget="updateStatus" wire:click.prevent=updateStatus>
            Update
        </x-utils.button>
    </div>
</div>

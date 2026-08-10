<div class="form-group text-center d-flex justify-content-center">
    @role('Reseller')
        <h3 class="w-100">You are a Reseller now.</h3>
    @else
        <x-utils.button onclick="confirm('Please confirm to become a reseller?') || event.stopImmediatePropagation()" type="button" wire:click.prevent="becomeSeller" wireTarget="becomeSeller" class="btn btn-warning btn-lg">
            Become a Seller
        </x-utils.button>
    @endrole
</div>
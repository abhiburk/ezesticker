<button wire:click="retryPayment('{{ Helper::encodeId($order->id) }}')" class="alert-link btn btn-link">
    Retry Payment
</button>

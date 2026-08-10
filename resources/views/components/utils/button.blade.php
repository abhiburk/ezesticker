@props(['icon','wireTarget' => null, 'spinnerId' => 'btn-spinner', 'disabled' => false])   

<button {{ $attributes->merge(['type' => 'button', 'disabled' => $disabled]) }}>
    <span class="d-flex align-items-center justify-content-center">
        {{ $slot }} 
        <span class="spinner-border spinner-border-sm ml-2" role="status" aria-hidden="true" wire:loading wire:target="{{ $wireTarget }}"></span>
    </span>
</button>
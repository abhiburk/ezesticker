@props([
    'message' => "Loading...",
    'wire' => 'wire:loading',
    'wireTarget' => '',
    'spinnerClass' => ''
])

<div {{ $wire }} @if (!empty($wireTarget)) wire:target="{{ $wireTarget }}" @endif >
    <div class="card-spinner">
        <div class="d-flex justify-content-center m-3">
            <div class="spinner-border text-white {{ $spinnerClass }}" role="status">
              {{-- <span class="visually-hidden">{{ $message }}</span> --}}
            </div>
        </div>
    </div>
</div>
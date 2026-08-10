@props([
    'message' => "Loading...",
    'wire' => 'wire:loading',
    'wireTarget' => '',
    'spinnerClass' => ''
])
<div {{ $wire }}  wire:target="{{ $wireTarget }}">
    <div class="d-flex justify-content-center m-3">
        <div class="spinner-border {{ $spinnerClass }}" role="status">
          {{-- <span class="visually-hidden">{{ $message }}</span> --}}
        </div>
    </div>
</div>
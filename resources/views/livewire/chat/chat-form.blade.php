<form wire:submit.prevent="sendMessage" class="row js-chatbox-form chatbox__form">
    <div class="col-11 reply-main">
        <textarea onkeypress="chatKeypress('{{ $receiver->id }}')" wire:model.defer="message" class="js-chatbox-input chatbox__form-input" placeholder="Type your message..." required rows="1"></textarea>
        {{-- <input type="text" onkeypress="isTyping('{{ $receiver->id }}')" wire:model.defer="message" class="js-chatbox-input chatbox__form-input" placeholder="Type your message..." required> --}}
    </div>
    <input wire:model="temp_msg_id" id="temp-msg-id" type="hidden">
    <div class="col-1 reply-send p-1 d-flex align-items-center"> <button class="chatbox__form-submit u-btn p-0"><i class="fas fa-paper-plane"></i></button></div>
</form>


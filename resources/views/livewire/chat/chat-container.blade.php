<div class="card chat-app shadow">
    <div id="plist" class="people-list" style="{{ !empty($receiver) ? '' : 'left:0px;' }}">
        @livewire('chat.chat-user-list', ['user_id' => request()->user_id])
    </div>
    <div class="chat {{ empty($receiver) ? 'd-none d-lg-block' : '' }} ">
        @if (!empty($receiver))
            <div class="chat-header clearfix">
                <div class="row d-flex justify-content-start align-items-center ">
                    <div class="col-lg-10 col-9 text-truncate d-flex justify-content-start align-items-center text-dark">
                        <button class="btn btn-link shadow-none d-lg-none back-to-chat-list" wire:click="resetChat">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </button>
                        <img src="{{ $receiver->getUserImageUrl() }}" class="rounded-circle" alt="{{ $receiver->name }}">
                        {{-- <span class="header-user" data-letters="{{ Helper::firstLetter($receiver->name) }}" style="font-size:18px;" class="mr-3"></span> --}}
                        <div class="chat-about">
                            <h6 class="mb-0 ">{{ $receiver->name }}</h6>
                            <small class="d-none is-typing"><i>Typing...</i></small>
                            <small class="text-secondary online-status">
                                @if(Cache::has('is_online' . $receiver->id))
                                    <i class="fa fa-circle online"></i> online
                                @elseif(!empty($receiver->last_seen))
                                    <i class="" style="width: 50px">Last seen: {{ Carbon::parse($receiver->last_seen)->diffForHumans() }}</i>
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="col-lg-2 col-3 hidden-sm text-right">
                        @if ($isDelete)
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example"> 
                                <x-utils.button type="button" class="btn btn-danger btn-sm shadow-none" wireTarget="deleteChat('{{ Helper::encodeId($receiver->id) }}')" wire:click="deleteChat('{{ Helper::encodeId($receiver->id) }}')"><i class="bi bi-check2"></i></x-utils.button>
                                <x-utils.button type="button" class="btn btn-light btn-sm shadow-none" wire:loading.attr="disabled" wire:click="$set('isDelete', false)"><i class="bi bi-x"></i></x-utils.button>
                            </div>
                        @else 
                            <x-utils.button class="btn btn-link shadow-none text-danger" wire:loading.attr="disabled" wire:click="$set('isDelete', true)"><i class="fa fa-trash" aria-hidden="true"></i></x-utils.button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="chat-history chat-scrollable" wire:loading.delay.class="opacity-2" style="overflow-y: auto;">
                {{-- <div class="d-flex justify-content-center">
                    <div wire:loading>
                        <div class="spinner-border" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div> --}}
                @livewire('chat.chat-messages', ['user_id' => $receiver->id])
            </div>
            <div class="chat-message clearfix bg-light">
                @livewire('chat.chat-form', ['user_id' => $receiver->id])
            </div>
        @else 
            <div class="chat-history js-chatbox-display" >
                <div class="row" style="height: 67vh;">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <i class="fa fa-envelope fa-2x mb-3"></i>
                            <h2 class="font-weight-bold">Select a Conversation</h2>
                            <p class="text-secondary">Try selecting a conversation or <br>
                            scan through QR sticker.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif 
    </div>
</div>
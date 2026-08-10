var receiver_id = $('meta[name=request-user-id]').attr('content'); // in app.blade.php
var auth_id = $('meta[name=auth-user-id]').attr('content'); // in app.blade.php
var app_env = $('meta[name=app-env]').attr('content'); // in app.blade.php
var old_receiver_id = null;
var typing_now = 0;
var typing_timeout;
var sender_id = auth_id;

$(function () {
    echoPrivateChat(); // function define in chat-user-list.blade.php
    listenMsgSeen();
    listenTyping();

    if (receiver_id) {
        makeBodyAbsolute();
        isSeen(true);
        toBottom();
    }

    // message input on keyup [Enter to send, Enter+Shift for new line]
    $(document).on('keyup', '.js-chatbox-form', (e) => {
        // if enter key pressed.
        if (e.which == 13 || e.keyCode == 13) {
            // if shift + enter key pressed, do nothing (new line).
            // if only enter key pressed, send message.
            if (!e.shiftKey) {
                triggered = isTyping(false);
                $(".chatbox__form-submit").trigger('click');
            }
        }
    });

    $(document).on('click', '.chatbox__form-submit', (e) => {
        createChatBubble('sender');
    });
});


// whenever user is change
window.livewire.on('room-change', (to) => {

    makeBodyAbsolute(to); // for mobile full chat box
    
    $('.js-chatbox-display').html('<p cass="text-center">Loading messages...</p>');
    receiver_id = to; // @override receiver_id
    if (old_receiver_id != receiver_id) { //if user is change unsubscribe the old channel
        Echo.leave('chat.' + sender_id);
    }
    isSeen(true);

    $('.chatbox__form-input').val('');
    $('.read-' + receiver_id).html('');
    old_receiver_id = receiver_id;

    echoPrivateChat();
    listenMsgSeen();
    listenTyping();

    // only trigger when their is unread notification
    if ($('.message-listing').find('a').hasClass('has-unread'))
        window.livewire.emit('refreshChatHeaderNotification');
});

// for livewire
window.livewire.on('scroll-to-bottom', () => {
    toBottom();
});

// success callback for msg send from ChatForm.php
window.livewire.on('message-sent', (temp_id) => {
    $('#temp-' + temp_id).find('.fa-clock').before('<span class="fas fa-check"></span>');
    $('#temp-' + temp_id).find('.fa-clock').remove();
});

// make user online whenever a user is active on the page
Echo.join('chat')
    .joining((user) => {
        window.livewire.emit('onlineStatus', user); // in ChatHeaderNotification
    }).leaving((user) => {
        window.livewire.emit('offlineStatus', user); // in ChatHeaderNotification
    })

function echoPrivateChat() {
    Echo.private('chat.' + sender_id)
        .listen('.message-sent', (e) => {
            let msg = e.message;
            let sender = e.sender.name;
            let link = e.url;
            // only receive msgs on open chat user
            if (receiver_id == msg.sender_id) {
                isSeen(true);
                createChatBubble('receiver', msg.message); // in chat.js
                toBottom();
            } else {
                window.livewire.emit('refreshChatHeaderNotification');
                window.livewire.emit('refreshChatList');
            }
            Push.create(sender, {
                body: msg.message,
                icon: 'http://127.0.0.1:8000/frontend/img/ezesticker-logo.png',
                link: link,
                timeout: 4000,
                onClick: function () {
                    window.focus();
                    this.close();
                }
            });
        });
}

// trigger when msg seen
function isSeen(status) {
    let channel = Echo.private('chat.' + receiver_id);
    return channel.whisper('msg-seen', {
        from: auth_id,
        to: receiver_id,
        seen: status
    });
}

// when user is typing msg, trigger this function
function chatKeypress(receiver_id) {
    if (typing_now < 1) {
        // Trigger typing
        let triggered = isTyping(true);
        triggered ? console.info('[+] Triggered')
            : console.error('[+] Not triggered');
        // Typing now
        typing_now = 1;
    }
    // Clear typing timeout
    clearTimeout(typing_timeout);
    // Typing timeout
    typing_timeout = setTimeout(function () {
        triggered = isTyping(false);
        triggered ? console.info('[-] Triggered')
            : console.error('[-] Not triggered');
        // Clear typing now
        typing_now = 0;
    }, 1000);
}

//Trigger typing event
function isTyping(status) {
    let channel = Echo.private('chat.' + receiver_id);
    return channel.whisper('typing', {
        from: auth_id,
        to: receiver_id,
        typing: status
    });
}

// Use to create chat bubble when user submits text
function createChatBubble(src = 'sender', msg = null) {
    let chat_input = $(".js-chatbox-input");
    let message = src == 'sender' ? chat_input.val() : msg;
    let temp_msg_id = $('.chatbox__form').find('#temp-msg-id').val();
    if (message.trim() == '') return false;
    let chatSection;
    const chatboxMsgDisplay = $(".js-chatbox-display");
    chatSection = `
        <li class="clearfix">
            <div class="message-data ${src == 'sender' ? 'text-right' : ''}">
                <small class="text-secondary message-data-time">${moment(moment.now()).fromNow()}</small>
            </div>
            <div class="${src == 'sender' ? 'text-right float-right' : ''}">
                <div class="message ${src == 'sender' ? 'other-message' : 'my-message'}"> 
                    ${message}
                </div> 
                ${src == 'sender'
            ? `</br> <small class="msg-time text-secondary" id="temp-${temp_msg_id}"><i class="fa fa-clock"></i></small>`
            : ''
        }
            </div>
        </li>
    `;

    chatboxMsgDisplay.append(chatSection);

    if (src == 'sender') {
        setTimeout(() => {
            chat_input.val('');
        }, 75);
    }

    toBottom();
};

// scroll to bottom
function toBottom() {
    $(".chat-scrollable").scrollTop($(".chat-scrollable")[0].scrollHeight);
}

// listen when msg is seen
function listenMsgSeen() {
    Echo.private('chat.' + auth_id)
        .listenForWhisper('msg-seen', (e) => {
            if (e.from == receiver_id && e.to == auth_id) {
                if (e.seen == true) {
                    $('.msg-time').find('.fa-check').before('Seen');
                    $('.msg-time').find('.fa-check').remove();
                } else {
                    console.error('seen failed');
                }
            }
        });
}

// listen when user is typing...
function listenTyping() {
    Echo.private('chat.' + auth_id)
        .listenForWhisper('typing', (e) => {
            if (e.from == receiver_id && e.to == auth_id) {
                if (e.typing == true) {
                    $('.online-status').addClass('d-none');
                    $('.is-typing').removeClass('d-none')
                } else {
                    $('.online-status').removeClass('d-none');
                    $('.is-typing').addClass('d-none');
                }
            }
        });
}

function makeBodyAbsolute(to){
    if( /Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && to != null) {
        $('body').addClass('position-fixed');
    }else{
        $('body').removeClass('position-fixed');
    }
}
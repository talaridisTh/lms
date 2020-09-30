let users = document.querySelectorAll(".js-message-chat")
let authUserId = document.querySelectorAll("#js-chat")[0].dataset.authId
let receiverUserId = null

users.forEach((user, idx) => {
    user.addEventListener("click", function () {

        // if ( this.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[1]  {
        //     this.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[1].remove()
        // }

        // let test = document.querySelector(".unread-container");
        //
        // console.log(this.contains(test))

        receiverUserId = user.dataset.userId
        axiosGetReceiver(user.dataset.userId)
        axiosGetInfo(user.dataset.userId)
        onKeyUpInput(user.dataset.userId)

    })
})

const axiosGetReceiver = async (receiver) => {

    try {
        const {data, status} = await axios.get(`/message/${receiver}`)

        if (status == 200) {

            $(".message-custom").html(data)


            onChangePage();
            onInitEmoji();
        }


    } catch (e) {
        console.log(e)
    }


}
const axiosGetInfo = async (receiver) => {

    try {
        const {data, status} = await axios.get(`/message/info/${receiver}`)

        if (status == 200) {

            $(".chat-info").html(data)

        }


    } catch (e) {
        console.log(e)
    }


}

const onButtonSubmitForm = (receiver, message) => {
    $(document).off('click', '.chat-send');
    $(document).on('click', '.chat-send', function (e) {
        axiosSentMessage(receiver, message)
    })


}
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('13fa229029719c121ea4', {
    cluster: 'mt1'
});

var channel = pusher.subscribe('my-channel');

channel.bind('my-event', function (data) {

    if (authUserId == data.from) {
        onPreviewButton("from", data)
        $('#user-' + data.to)[0].click();
    } else if (authUserId == data.to) {
        onPreviewButton("to", data)

        if (receiverUserId == data.from) {
            $('#user-' + data.from)[0].click();

        } else {
            let pending = parseInt($('#user-' + data.from).find('.unread-message').html());

            $('#user-' + data.from).find('.unread-message').html(pending + 1);


            if (pending) {
                $('#user-' + data.from).find('.unread-message').html(pending + 1);
            } else {

                $(`#user-${data.from} .unread-container`).append('<span class="unread-message badge badge-danger-lighten">1</span>');
            }
        }
    }

});

const onPreviewButton = (receiver, {to, from, message, updated_at}) => {
    if (receiver == "from") {
        $('#user-' + to).find('.preview-message').html(message);
        $('#user-' + to).find('.preview-hour').html(updated_at);
    } else if (receiver == "to") {
        $('#user-' + from).find('.preview-message').html(message);
        $('#user-' + from).find('.preview-hour').html(updated_at);
    }
}

const onKeyUpInput = async (receiver) => {
    $(document).off('keyup', '.js-message');
    $(document).on('keyup', '.js-message', function (e) {

        onButtonSubmitForm(receiver, this.value);

        if (e.keyCode == 13 && this.value != '' && receiver != '') {

            axiosSentMessage(receiver, this.value)
        }
    });
}

const axiosSentMessage = async (receiver, message) => {
    try {

        const {data, status} = await axios.post(`/message/sent`, {
            receiver, message
        })

    } catch (e) {
        console.log(e)
    }

}

const onChangePage = () => {
    $(".js-message").focus()

    setTimeout(function () {
        var element = $('.simplebar-content-wrapper')[1];
        element.scrollTop = element.scrollHeight - element.clientHeight;
        $('html').scrollTop($('html')[0].scrollHeight + 230);

    }, 10);
}

const onInitEmoji = () => {
    var input = document.querySelector('.emoji-button');
    var input1 = document.querySelector('.js-message');


    var picker = new EmojiButton({
        position: 'right-start',
        recentsCount: 5
    })

    picker.on('emoji', function (emoji) {
        input1.value += emoji;
    })

    input.addEventListener('click', function () {
        picker.pickerVisible ? picker.hidePicker() : picker.showPicker(input);
    })
}





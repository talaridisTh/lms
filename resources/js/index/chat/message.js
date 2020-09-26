let users = document.querySelectorAll(".js-message-chat")
let authUserId = document.querySelectorAll("#js-chat")[0].dataset.authId
let receiverUserId = null


users.forEach(user => {
    user.addEventListener("click", function () {

        if (this.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[1]) {
            this.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[1].remove()
        }

        receiverUserId = user.dataset.userId
        axiosGetReceiver(user.dataset.userId)
        onKeyUpInput(user.dataset.userId)


    })
})

const axiosGetReceiver = async (receiver) => {

    try {
        const {data, status} = await axios.get(`/message/${receiver}`)

        if (status == 200) {

            $(".message-custom").html(data)

            onChangePage();

        }


    } catch (e) {
        console.log(e)
    }


}

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('13fa229029719c121ea4', {
    cluster: 'mt1'
});
var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function (data) {

    $('#' + data.to).find('.preview-message').html(data.message);


    if (authUserId == data.from) {
        $('#' + data.to)[0].click();
    } else if (authUserId == data.to) {
        if (receiverUserId == data.from) {
            $('#' + data.from)[0].click();

        } else {
            var pending = parseInt($('#' + data.from).find('.unread-message').html());

            $('#' + data.from).find('.unread-message').html(pending + 1);

            if (pending) {
                $('#' + data.from).find('.unread-message').html(pending + 1);
            } else {
                $('#' + data.from + ".unread-container").append('<span class="unread-message badge badge-danger-lighten">1</span>');
            }
        }
    }

});


const onKeyUpInput = async (receiver) => {
    $(document).off('keyup', '.js-message');
    $(document).on('keyup', '.js-message', function (e) {

        var message = this.value;
        if (e.keyCode == 13 && message != '' && receiver != '') {
            axiosSentMessage(receiver, message)
        }
    });
}

const axiosSentMessage = async (receiver, message) => {
    try {
        const {data, status} = await axios.post(`/message/sent`, {
            receiver, message
        })

        if (status == 200) {
            onChangePage();
        }

    } catch (e) {
        console.log(e)
    }

}

const onChangePage = () => {

    setTimeout(function () {
        var element = $('.simplebar-content-wrapper')[1];
        element.scrollTop = element.scrollHeight - element.clientHeight;
        $('html').scrollTop($('html')[0].scrollHeight+230);

    }, 1);
}

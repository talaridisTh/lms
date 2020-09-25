let users = document.querySelectorAll(".js-message-chat")



users.forEach(user => {
    user.addEventListener("click", () => {

        axiosGetReceiver(user.dataset.userId)
        onKeyUpInput(user.dataset.userId)

    })
})

const axiosGetReceiver = async (receiver) => {

    try {
        const {data, status} = await axios.get(`/message/${receiver}`)

        if (status == 200) {

            $(".message-custom").html(data)

        }


    } catch (e) {
        console.log(e)
    }


}

const onKeyUpInput = async (receiver) => {
    $(document).on('keyup', '.js-message', function (e) {
        var message = this.value;
        if (e.keyCode == 13 && message != '' && receiver != '') {
            this.value = " "
            let dataMessage = `receiver=${receiver}&message=${message}`

            axiosSentMessage(receiver,message)
        }
    });
}

const axiosSentMessage = async (receiver,message) => {

    try {
        const {data, status} = await axios.post(`/message/sent`,{
            receiver,message
        })

        if(status==200){
            $(".message-custom").innerHTML(data)
        }




    } catch (e) {
        console.log(e)
    }

}




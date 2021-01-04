$(".js-strong-password").on("input", function (e) {
    console.log(this.parentElement.parentElement.children[1].children)
    const validateChild = this.parentElement.parentElement.children[1].children;

    const iChars = "~`!#$%^&*+=-[]\\\';,/{}|\":<>?";
    const number = "123456789"
    let hasSpecialChar = false
    let hasNumber = false

    for (let i = 0; i < validateChild.length; i++) {
        e.target.value.length >= 3 ? validateChild[0].classList.remove("hidden") : validateChild[0].classList.add("hidden")
        e.target.value.length >= 6 ? validateChild[1].classList.remove("hidden") : validateChild[1].classList.add("hidden");
        e.target.value.length >= 6 && hasSpecialChar ? validateChild[2].classList.remove("hidden") : validateChild[2].classList.add("hidden")
        e.target.value.length >= 7 && hasSpecialChar && hasNumber ? validateChild[3].classList.remove("hidden") : validateChild[3].classList.add("hidden")
        e.target.value.length >= 7 && hasSpecialChar && hasNumber ? $(".js-message-strong-password")[0].innerHTML = "Strong password" : $(".js-message-strong-password")[0].innerHTML = ""

        for (let i = 0; i < e.target.value.length; i++) {
            if (iChars.indexOf(e.target.value.charAt(i)) !== -1) {
                hasSpecialChar = true;
            }
            if (number.indexOf(e.target.value.charAt(i)) !== -1) {
                hasNumber = true;
            }
        }

    }


})

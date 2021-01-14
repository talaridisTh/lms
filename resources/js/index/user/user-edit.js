import utilities from "../../dashboard/main";
import feather from 'feather-icons';

const initRedactor = () => {
    $R("#user-update-profile", {
        buttons: [
            'html', 'undo', 'redo', 'format',
            'bold', 'underline', 'italic', 'deleted',
            'sup', 'sub', 'lists', 'file', 'link', 'image'
        ],
        style: false,
        plugins: ['alignment'],
        minHeight: '150px',
    });
}
initRedactor()

const onChangeAvatar = () => {
    let userSlug = $("#user-slug").data("user-slug");
    $(".cnt-update-user").on("change", "#file-pond", async function (e) {
        var formData = new FormData();
        var imagefile = document.querySelector('#file-pond');
        formData.append("file", imagefile.files[0]);

        const {data, status} = await axios.post(`/home/account/${userSlug}/upload-avatar`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })

        if (status == 200) {

            $(".cnt-user-avatar").html($(data));
            feather.replace()
            utilities.toastAlert("success", "Το Cover άλλαξε")

        }
    })
}
onChangeAvatar();


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


$(".col-span-12").on("click", ".js-update-submit", async function () {
    let userSlug = $("#user-slug").data("user-slug");
    let name = $("#user-update-name").val()
    let last = $("#user-update-last").val()
    let email = $("#user-update-email").val()
    let phone = $("#user-update-phone").val()
    let password = $("#user-update-password").val()
    let password_confirmation = $("#user-update-repassword").val()
    let profil = $("#user-update-profile").val()
    let facebook = $("#user-update-facebook").val()
    let instagram = $("#user-update-instagram").val()
    let linkedin = $("#user-update-linkedin").val()
    let youtube = $("#user-update-youtube").val()


    const {data, status} = await axios.post(`/home/account/${userSlug}/update`, {
        name,
        last,
        email,
        phone,
        password,
        password_confirmation,
        profil,
        facebook,
        instagram,
        linkedin,
        youtube
    })


    if (status == 200) {
        $(".left-sidebar").html($(data).find(".left-sidebar > *"))
        $(".col-span-12").html($(data).find(".col-span-12 > *"))

        initRedactor()
        onChangeAvatar()
        feather.replace()

        if ($(".has-error").length) {
            await utilities.toastAlert("warning", `υπάρχουν ${$(".has-error").length} σφάλματα`)
            return;
        }
        await utilities.toastAlert("success", `${name} ${last} ενημερώθηκε!`)


    }
})

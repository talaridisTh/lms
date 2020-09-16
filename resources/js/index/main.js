import utilities from "../dashboard/main";

Element.prototype.findParent = function (loops) {
    let parent = this;

    for (let i = 0; i < loops; i++) {
        parent = parent.parentElement;
    }

    return parent;
}, false;


function toastAlert(icon, message) {
    Swal.fire({
        toast: 'true',
        position: 'top-end',
        icon: icon,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

const addWhatchlist = () => {
    $(".add-watchlist").click(function () {

        addWhatchlistAxios(
            this.dataset.courseId,
            this.dataset.userId,
            this.dataset.model,
        );



    })
}


const addWhatchlistAxios = async (modelId, userId,model) => {

    try {
        const res = await axios.patch(`/add-watchlist/${model}`, {
            modelId,
            userId
        })

        if (res.data) {
            utilities.toastAlert("info", `Υπάρχει ήδη στα Αγαπημένα`)

        } else if (res.status == 200) {
            utilities.toastAlert("success", `Προστέθηκε στα αγαπήμενα`)
        }
    } catch (e) {
        console.log(e)
    }

}


export default {
    addWhatchlist
}


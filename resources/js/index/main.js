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
            this.dataset.modelId,
            this.dataset.userId,
            this.dataset.model,
        );





    })
}


const addWhatchlistAxios = async (modelId, userId,model) => {
    const heart = $(".add-watchlist")[0].children[0];
    const button = $(".add-watchlist > span")[0];

    try {
        const res = await axios.patch(`/add-watchlist/${model}`, {
            modelId,
            userId
        })


        if (res.data=="remove") {
            utilities.toastAlert("info", `Αφαιρέθηκε ήδη στα Αγαπημένα`)
            heart.className="mdi mdi-heart-outline font-16 mr-2"
            button.textContent = "Προσθήκη στα αγαπημένα"




        } else if (res.data=="add") {
            utilities.toastAlert("success", `Προστέθηκε στα αγαπήμενα`)
            heart.className="mdi mdi-cards-heart font-16 mr-2"
            button.textContent = "Αφαίρεση απο τα αγαπημένα"



        }
    } catch (e) {
        console.log(e)
    }

}


export default {
    addWhatchlist
}


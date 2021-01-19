// try {
//     window.Popper = require('popper.js').default;
//     window.$ = window.jQuery = require('jquery');
//
//     require('bootstrap');
// } catch (e) {}


// 3rd Parties
// window.$ = window.jQuery = require('jquery');
// require('bootstrap');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Swal = require('sweetalert2');
window.$R = require('../../plugins/redactor/redactor');
require('../../plugins/redactor/plugins/alignment/alignment');

import anime from "animejs";
// Components
import iziToast from "izitoast";
import './theme/bootstrap'

import './theme/mobile-menu'
import './theme/feather'
import './theme/tab'
import './theme/tippy'
import './theme/dropdown'
import './theme/modal'
import './theme/show-modal'
import './theme/dropzone'

import './theme/accordion'

window.anime = anime

window.iziToast = iziToast;


//jQuery
$.fn.extend({
    toggleText: function (a, b) {
        const that = this;
        if (that.text() != a && that.text() != b) {
            that.text(a);
        } else if (that.text() == a) {
            that.text(b);
        } else if (that.text() == b) {
            that.text(a);
        }
        return this;
    }
});

$(".js-message-seen").on("click", async function () {
    try {
        const {
            status
        } = await axios.patch("home/message/update");

        if (status == 200) {
            $(".js-message-badge").remove();
        }
    } catch (e) {
        console.log(e)
    }
})

$(document).on("click", ".js-task-seen", async function (e) {
    e.preventDefault()

    window.location.href = "/discussion?task";


    console.log($("#filter-my-task"))
    try {

        const {
            status
        } = await axios.patch("home/task/update");
        if (status == 200) {
            $("#filter-my-task").trigger("click");
            // $(".js-message-badge").remove();
        }
    } catch (e) {
        console.log(e)
    }
})
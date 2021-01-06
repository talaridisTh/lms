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
// require('../../theme/js/app');



import './theme/bootstrap'
import './theme/mobile-menu'

// Components
import './theme/feather'
import './theme/tab'
import './theme/tippy'
// import './theme/modal'

//jQuery
$.fn.extend({
    toggleText: function (a, b){
        const that = this;
        if (that.text() != a && that.text() != b){
            that.text(a);
        }
        else
        if (that.text() == a){
            that.text(b);
        }
        else
        if (that.text() == b){
            that.text(a);
        }
        return this;
    }
});

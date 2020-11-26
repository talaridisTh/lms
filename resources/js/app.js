window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


window.Swal = require('sweetalert2');

window.$R = require('../plugins/redactor/redactor');
require('../plugins/redactor/plugins/alignment/alignment');


require('../theme/js/app');
// require('../theme/js/vendor');



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

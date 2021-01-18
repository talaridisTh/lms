window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Swal = require('sweetalert2');

window.$R = require('../plugins/redactor/redactor');
require('../plugins/redactor/plugins/alignment/alignment');

//
require('../theme/js/app');


// require('../theme/js/vendor');





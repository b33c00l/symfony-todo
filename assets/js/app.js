const $ = require('jquery');
global.$ = global.jQuery = $;
import "bootstrap";
import "bootstrap-datepicker/dist/js/bootstrap-datepicker";
$(document).ready(function() {
    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
});

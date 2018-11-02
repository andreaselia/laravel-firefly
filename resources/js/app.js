window._ = require('lodash');
window.Popper = require('popper.js').default;

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

$(function () {
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    })
});

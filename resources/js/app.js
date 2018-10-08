window.$ = window.jQuery = require('jquery');

window.Vue = require('vue');

Vue.component('new-discussion', {});

const app = new Vue({
    el: '#app',

    methods: {
        toggleModal: function (toggleModal) {
            alert(toggleModal);
            try {
                $(`#${toggleModal}`).toggle();
            } catch (e) {}
        }
    }
});

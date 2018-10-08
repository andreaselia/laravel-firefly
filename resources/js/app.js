window.$ = window.jQuery = require('jquery');

window.Vue = require('vue');

Vue.component('new-group', {
    data() {
        return {
            name: '',
            color: ''
        }
    },

    methods: {
        toggleModal: function (toggleModal) {
            this.$parent.$options.methods.toggleModal(toggleModal);
        },

        submit: function (e) {
            axios.post('/groups', {
                name: this.name,
                color: this.color
            });
        }
    }
});

Vue.component('new-discussion', {
    data() {
        return {
            title: '',
            content: ''
        }
    },

    methods: {
        toggleModal: function (toggleModal) {
            this.$parent.$options.methods.toggleModal(toggleModal);
        },

        submit: function (e) {
            axios.post('/discussions', {
                title: this.title,
                content: this.content
            });
        }
    }
});

const app = new Vue({
    el: '#app',

    methods: {
        toggleModal: function (toggleModal) {
            try {
                $('#' + toggleModal + 'Modal').toggle();
            } catch (e) {}
        },

        toggleModal: function (toggleModal) {
            try {
                $('#' + toggleModal + 'Modal').toggle();
            } catch (e) {}
        }
    }
});

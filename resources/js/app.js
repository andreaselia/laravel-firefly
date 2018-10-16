window.$ = window.jQuery = require('jquery');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

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
            var self = this;

            axios.post('/forum/groups', {
                name: this.name,
                color: this.color
            }).then(res => {
                this.name = '';
                this.color = '';

                self.toggleModal('newGroup');
            });
        }
    }
});

Vue.component('new-discussion', {
    props: ['group'],

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
            var self = this;

            axios.post('/forum/' + this.group.slug + '/discussion', {
                group_id: this.group.id,
                title: this.title,
                content: this.content
            }).then(res => {
                this.title = '';
                this.content = '';

                self.toggleModal('newDiscussion');
            });
        }
    }
});

Vue.component('new-post', {
    props: ['discussion'],

    data() {
        return {
            content: ''
        }
    },

    methods: {
        submit: function (e) {
            axios.post('/forum/' + this.discussion.id + '-' + this.discussion.slug, {
                content: this.content
            }).then(res => {
                this.content = '';
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


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
var intlTelInput = require('intl-tel-input');

window.$ = window.jQuery = require('jquery');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

//const app = new Vue({
//    el: '#app'
//});

var input = document.querySelector('#phone');

intlTelInput(input, {
    utilsScript: "intlTelInput/js/utils.js",
    initialCountry: "auto",
    separateDialCode: true,
    geoIpLookup: function(callback) {
        axios.get('https://ipinfo.io')
        .then((response) => {
            var countryCode = (response.data && response.data.country) ? response.data.country : "";
            
            callback(countryCode);
        });
    },
    hiddenInput: "telephone"
});


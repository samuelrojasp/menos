
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
    utilsScript: "/intlTelInput/js/utils.js",
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

input.addEventListener('blur', function(){
    if(this.classList.contains('referer')){
        var phonenumber = this.value;
        var code = document.querySelector('.iti__selected-dial-code').innerText;
        var telephone = code + phonenumber;
        var refererName = document.querySelector('#refererName');

        const url = '/api/byPhone/'+telephone;

        fetch(url)
            .then(response => response.json())
            .then(function(data){
                refererName.innerText = data.name;
            });
    }
});



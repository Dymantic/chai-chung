import { SuperHero }  from "./components/SuperHero";
import throttle from "lodash.throttle";

require('./bootstrap');

window.Vue = require('vue');


import ContactForm from "./components/ContactForm";
import Usher from "./components/Usher";

Vue.component('contact-form', ContactForm);

const app = new Vue({
    el: '#app'
});

if(document.querySelector('.home-banner')) {
    new SuperHero();
}

function checkNavBar() {
    if(window.scrollY > 80) {
        console.log()
    }
}

window.addEventListener('scroll', throttle(() => {
    if(window.scrollY > 80) {
        document.querySelector('.main-nav').classList.add("scrolled");
        return;
    }
    document.querySelector('.main-nav').classList.remove("scrolled");
}, 150));


const usher = new Usher();

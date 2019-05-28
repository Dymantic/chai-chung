import { SuperHero }  from "./components/SuperHero";
import throttle from "lodash.throttle";

require('./bootstrap');

window.Vue = require('vue');

import jump from "jump.js"

import ContactForm from "./components/ContactForm";
import Usher from "./components/Usher";
import NightLights from "./components/NightLights";

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

window.addEventListener('load', () => {
   // if(document.querySelector('svg.skyline')) {
   //     const nightLights = new NightLights();
   //     nightLights.twinkle();
   // }

    document.querySelector('.nav-trigger').addEventListener('click', () => {
        const nav = document.querySelector('.main-nav');
        if(nav.classList.contains('show-subnav')) {
            return nav.classList.remove('show-subnav');
        }
        return nav.classList.add('show-subnav');
    });

    document.querySelectorAll('[data-jump]').forEach(link => {
        link.addEventListener('click', () => {
            const target = link.getAttribute('data-jump-target') || 'body';
            const offset = link.getAttribute('data-jump-offset') || 0;

            jump(target, {offset});
        });
    })
});





import { SuperHero }  from "./components/SuperHero";
import throttle from "lodash.throttle";

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
        document.querySelector('.main-nav').classList.add("bg-navy");
        document.querySelector('.main-nav').classList.remove("bg-navy-opq");
        return;
    }
    document.querySelector('.main-nav').classList.remove("bg-navy");
    document.querySelector('.main-nav').classList.add("bg-navy-opq");
}, 150));
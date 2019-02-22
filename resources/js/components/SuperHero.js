export class SuperHero {

    constructor() {
        this.day = document.querySelector('.white-lights');
        this.night = document.querySelector('.orange-lights');
        this.is_day = true;

        this.day.style.opacity = 1;
        this.day.style.transition = "opacity 5s linear";

        this.night.style.opacity = 0;
        this.night.style.transition = "opacity 5s linear";

        this.fly();
    }

    async loadNight() {
        return new Promise((resolve, reject) => {
            this.night.addEventListener('load', resolve);
            this.night.addEventListener('error', reject);
            this.night.src = this.night.getAttribute('data-src');
        })
    }

    async fly() {
        await this.loadNight();
        this.toggle();
        window.setInterval(() => this.toggle(), 10000);
    }

    toggle() {
        if(this.is_day) {
            this.day.style.opacity = "0";
            this.night.style.opacity = "1";
        } else {
            this.day.style.opacity = "1";
            this.night.style.opacity = "0";
        }
        this.is_day = !this.is_day;
    }
}
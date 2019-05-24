function getRandomIndexesFrom(count, length) {
    const indexes = [...new Array(count)];
    return indexes.map(() => Math.floor(Math.random() * length))
}

function getRandomElementsFrom(count, ar) {
    const randoms = [];

    while (randoms.length < count) {
        let r = Math.floor(Math.random() * ar.length);
        if(!randoms.includes(r)) {
            randoms.push(ar[r])
        }
    }

    return randoms;
}


export default class Nightlights {

    constructor() {
        this.windows = [...document.querySelectorAll('#Windows rect')];
        this.window_count = this.windows.length;
        this.on_count = Math.floor(this.window_count / 10);

        this.on = getRandomIndexesFrom(this.on_count, this.window_count);
        this.off = this.windows
                       .map((_, i) => !this.on.includes(i) ? i : false)
                       .filter(x => x !== false);

        this.setStart();
    }

    setStart() {
        this.on.forEach(i => this.windows[i].classList.add('on'));
    }

    switch() {
        const turn_off = getRandomElementsFrom(5, this.on);
        const turn_on = getRandomElementsFrom(5, this.off);

        turn_off.forEach(x => {
            this.windows[x].classList.remove('on');
            this.on.splice(this.on.indexOf(x), 1);
            this.off.push(x);
        });

        turn_on.forEach(x => {
            this.windows[x].classList.add('on');
            this.off.splice(this.off.indexOf(x), 1);
            this.on.push(x);
        });
    }

    twinkle() {
        window.setInterval(() => this.switch(), 1500);
    }
}
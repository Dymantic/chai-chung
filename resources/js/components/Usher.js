export default class Usher {
    constructor() {
        if(! ('IntersectionObserver' in window)) {
            return;
        }

        const toObseve = this.prepareEntries();
        if(toObseve.length === 0) {
            return;
        }
        this.observer = new IntersectionObserver(this.handleIntersects, {
            root: null,
            rootMargin: '0px',
            threshold: 0.5
        });

        toObseve.forEach(el => this.observer.observe(el));
    }

    prepareEntries() {
        const fold = window.innerHeight;
        return [...document.querySelectorAll('[data-usher]')]
            .filter(el => el.getBoundingClientRect().top > fold)
            .map(el => {
                el.classList.add('usher-out');
                return el;
            });
    }

    handleIntersects(entries, observer) {
        entries.filter(entry => entry.isIntersecting)
               .forEach(({target}) => {
                   const delay = target.getAttribute("data-usher-delay") || 0;
                   const name = target.getAttribute("data-usher-name") || 'fadeUp';
                   target.style.animationDelay = `${delay}s`;
                   target.classList.remove('usher-out');
                   target.classList.remove('usher-in');
                   target.style.animationName = name;
                   observer.unobserve(target);
               });
    }
}
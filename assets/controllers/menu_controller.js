import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['drawer', 'backdrop', 'iconOpen', 'iconClose']

    // Switch open/close du drawer
    toggle() {
        if (this.drawerTarget.classList.contains('hidden')) {
            this.open()
        } else {
            this.close()
        }
    }

    open() {
        // Display drawer + backdrop, switch burger -> croix
        this.drawerTarget.classList.remove('hidden')
        this.backdropTarget.classList.remove('hidden')
        this.iconOpenTarget.classList.add('hidden')
        this.iconCloseTarget.classList.remove('hidden')

        // Force le navigateur à prendre en compte l'état caché avant de lancer la transition
        this.drawerTarget.offsetHeight

        this.drawerTarget.classList.remove('-translate-y-4', 'opacity-0')
    }

    close() {
        // Lance la transition de fermeture, switch croix -> burger
        this.drawerTarget.classList.add('-translate-y-4', 'opacity-0')
        this.backdropTarget.classList.add('hidden')
        this.iconOpenTarget.classList.remove('hidden')
        this.iconCloseTarget.classList.add('hidden')

        // Attend la fin réelle de la transition avant de cacher le drawer
        this.drawerTarget.addEventListener('transitionend', () => {
            this.drawerTarget.classList.add('hidden')
        }, { once: true })
    }
}
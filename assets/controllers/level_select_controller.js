import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['modal', 'backdrop', 'title', 'facileBtn', 'moyenBtn', 'difficileBtn']

    // Redirect to Activity route with selected level 
    currentRoute = null

    open(event) {
        this.currentRoute = event.params.route
        this.titleTarget.textContent = event.params.label

        this.updateButtonState(this.facileBtnTarget, event.params.available.includes('facile'))
        this.updateButtonState(this.moyenBtnTarget, event.params.available.includes('moyen'))
        this.updateButtonState(this.difficileBtnTarget, event.params.available.includes('difficile'))

        this.modalTarget.classList.remove('hidden')
        this.backdropTarget.classList.remove('hidden')

        this.modalTarget.offsetHeight

        this.modalTarget.classList.remove('opacity-0', 'scale-95')
    }

    close() {
        this.modalTarget.classList.add('opacity-0', 'scale-95')
        this.backdropTarget.classList.add('hidden')

        this.modalTarget.addEventListener('transitionend', () => {
            this.modalTarget.classList.add('hidden')
        }, { once: true })
    }

    selectLevel(event) {
        const level = event.params.level
        window.location.href = `${this.currentRoute}?level=${level}`
    }

    updateButtonState(button, isAvailable) {
        if (isAvailable) {
            button.disabled = false
            button.classList.remove('opacity-40', 'cursor-not-allowed')
        } else {
            button.disabled = true
            button.classList.add('opacity-40', 'cursor-not-allowed')
        }
    }
}
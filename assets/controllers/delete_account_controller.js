import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['modal', 'backdrop', 'step1', 'step2', 'checkbox', 'submitBtn']

    open() {
        this.step1Target.classList.remove('hidden')
        this.step2Target.classList.add('hidden')

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

    goToStep2() {
        this.step1Target.classList.add('hidden')
        this.step2Target.classList.remove('hidden')
    }

    toggleSubmit() {
        this.submitBtnTarget.disabled = !this.checkboxTarget.checked
    }
}
import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['blank', 'choice', 'answerInput', 'form']

    // La séquence d'ids d'hiragana déjà placés dans les cases
    placedIds = []

    select(event) {
        const button = event.currentTarget
        const hiraganaId = event.params.hiraganaId

        // Si déjà toutes les cases sont remplies, on ignore le clic
        if (this.placedIds.length >= this.blankTargets.length) return

        const nextBlank = this.blankTargets[this.placedIds.length]
        nextBlank.textContent = button.textContent.trim()
        nextBlank.dataset.filledBy = hiraganaId

        this.placedIds.push(hiraganaId)
        button.disabled = true
        button.classList.add('opacity-30')

        this.updateAnswerInput()
    }

    reset() {
        this.placedIds = []

        this.blankTargets.forEach(blank => {
            blank.textContent = ''
            delete blank.dataset.filledBy
        })

        this.choiceTargets.forEach(button => {
            button.disabled = false
            button.classList.remove('opacity-30')
        })

        this.updateAnswerInput()
    }

    updateAnswerInput() {
        this.answerInputTarget.value = this.placedIds.join(',')
    }

    validate() {
        if (this.placedIds.length === this.blankTargets.length) {
            this.formTarget.requestSubmit()
        }
    }
}
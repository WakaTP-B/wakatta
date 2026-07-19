import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['choice', 'submitBtn']

    selectedValue = null

    select(event) {
        const clickedButton = event.currentTarget
        const clickedValue = event.params.value

        if (this.selectedValue === clickedValue) {
            this.deselectAll()
            this.selectedValue = null
        } else {
            this.deselectAll()
            this.markAsSelected(clickedButton)
            this.selectedValue = clickedValue
        }

        this.updateSubmitButtonState()
    }

    deselectAll() {
        this.choiceTargets.forEach((button) => this.markAsUnselected(button))
    }

    markAsSelected(button) {
        button.classList.add('border-4', 'font-bold')
        button.classList.remove('border-2', 'font-normal')
    }

    markAsUnselected(button) {
        button.classList.add('border-2', 'font-normal')
        button.classList.remove('border-4', 'font-bold')
    }

    updateSubmitButtonState() {
        this.submitBtnTarget.disabled = this.selectedValue === null
    }
}
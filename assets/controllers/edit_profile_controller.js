import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [
        'usernameForm', 'usernameInput',
        'editForm', 'currentPasswordInput',
        'modal', 'backdrop', 'confirmPasswordInput',
        'editIcon', 'checkIcon', 'modalError'
    ]

    connect() {
        this.resizeUsernameInput()
    }

    toggleUsernameEdit() {
        if (this.usernameInputTarget.readOnly) {
            this.usernameInputTarget.readOnly = false
            this.usernameInputTarget.focus()
            this.usernameInputTarget.select()
            this.editIconTarget.classList.add('hidden')
            this.checkIconTarget.classList.remove('hidden')
        } else {
            this.submitUsername({ type: 'click' })
        }
    }

    resizeUsernameInput() {
        this.usernameInputTarget.style.width = '0px'
        this.usernameInputTarget.style.width = `${this.usernameInputTarget.scrollWidth}px`
    }

    submitUsername(event) {
        if (event.type === 'keydown') {
            event.preventDefault()
        }
        this.usernameInputTarget.readOnly = true
        this.checkIconTarget.classList.add('hidden')
        this.editIconTarget.classList.remove('hidden')
        this.usernameFormTarget.requestSubmit()
    }

    submitEditForm(event) {
        event.preventDefault()

        const hasEmail = this.editFormTarget.querySelector('[name$="[email][first]"]').value !== ''
        const hasPassword = this.editFormTarget.querySelector('[name$="[plainPassword][first]"]').value !== ''

        if (!hasEmail && !hasPassword) {
            this.sendEditForm()
            return
        }

        this.openModal()
    }

    async sendEditForm() {
        const formData = new FormData(this.editFormTarget)

        const response = await fetch(this.editFormTarget.action, {
            method: 'POST',
            body: formData,
        })

        const data = await response.json()

        if (data.success) {
            window.location.reload()
        } else {
            this.modalErrorTarget.textContent = data.message
            this.modalErrorTarget.classList.remove('hidden')

            console.log('nouveau token recu:', data.csrfToken)
            const tokenField = this.editFormTarget.querySelector('[name$="[_token]"]')
            console.log('champ token trouve:', tokenField)

            if (data.csrfToken && tokenField) {
                tokenField.value = data.csrfToken
                console.log('token injecte, nouvelle valeur:', tokenField.value)
            }
        }
    }

    openModal() {
        this.modalTarget.classList.remove('hidden')
        this.backdropTarget.classList.remove('hidden')
        this.modalTarget.offsetHeight
        this.modalTarget.classList.remove('opacity-0', 'scale-95')
    }

    closeModal() {
        this.modalTarget.classList.add('opacity-0', 'scale-95')
        this.backdropTarget.classList.add('hidden')
        this.modalTarget.addEventListener('transitionend', () => {
            this.modalTarget.classList.add('hidden')
        }, { once: true })
    }

    async confirmPassword(event) {
        event.target.disabled = true

        this.currentPasswordInputTarget.value = this.confirmPasswordInputTarget.value
        this.modalErrorTarget.classList.add('hidden')
        await this.sendEditForm()

        event.target.disabled = false
    }
}
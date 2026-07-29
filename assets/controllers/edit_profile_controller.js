import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [
        'usernameForm', 'usernameInput',
        'editForm', 'currentPasswordInput',
        'modal', 'backdrop', 'confirmPasswordInput',
        'editIcon', 'checkIcon', 'modalError', 'formError', 'flashSuccess',
    ]

    connect() {
        this.resizeUsernameInput()

        // Ouverture modal si erreur renvoyé
        if (this.modalErrorTarget.textContent.trim() !== '') {
            this.openModal()
        }
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
        if (this.confirmed) {
            this.confirmed = false
            return
        }

        event.preventDefault()

        const emailFirst = this.editFormTarget.querySelector('[name$="[email][first]"]')
        const emailSecond = this.editFormTarget.querySelector('[name$="[email][second]"]')
        const passwordFirst = this.editFormTarget.querySelector('[name$="[plainPassword][first]"]')
        const passwordSecond = this.editFormTarget.querySelector('[name$="[plainPassword][second]"]')

        const hasEmail = emailFirst.value !== ''
        const hasPassword = passwordFirst.value !== ''

        if (!hasEmail && !hasPassword) {
            this.showFormError('Aucune modification à appliquer.')
            return
        }

        const error = this.validateFields(emailFirst, emailSecond, passwordFirst, passwordSecond)

        if (error) {
            this.showFormError(error)
            return
        }

        this.hideFormError()
        this.openModal()
    }

    validateFields(emailFirst, emailSecond, passwordFirst, passwordSecond) {
        if (emailFirst.value !== '' && emailFirst.value !== emailSecond.value) {
            return 'Les emails ne correspondent pas'
        }

        if (passwordFirst.value !== '') {
            if (passwordFirst.value.length < 6) {
                return 'Le mot de passe doit comporter au moins 6 caractères'
            }
            if (passwordFirst.value !== passwordSecond.value) {
                return 'Les mots de passe ne correspondent pas'
            }
        }

        return null
    }

    showFormError(message) {
        this.formErrorTarget.textContent = message
        this.formErrorTarget.classList.remove('hidden')

        if (this.hasFlashSuccessTarget) {
            this.flashSuccessTarget.classList.add('hidden')
        }
    }

    hideFormError() {
        this.formErrorTarget.classList.add('hidden')
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
        this.modalErrorTarget.textContent = ''
        this.modalTarget.addEventListener('transitionend', () => {
            this.modalTarget.classList.add('hidden')
        }, { once: true })
    }

    confirmPassword() {
        this.currentPasswordInputTarget.value = this.confirmPasswordInputTarget.value
        this.confirmed = true
        this.editFormTarget.requestSubmit()
    }
}
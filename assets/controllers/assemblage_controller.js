import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['tile', 'selection', 'romaji', 'translation', 'timer', 'score', 'finishForm']
    static values = { sessionId: Number, difficulty: String, remainingSeconds: Number }

    selectedIds = []
    foundWords = []
    score = 0
    timeLeft = 30

    connect() {
        this.timeLeft = this.remainingSecondsValue
        this.timerTarget.textContent = this.formatTime(this.timeLeft)
        this.start()
    }

    start() {
        this.timerInterval = setInterval(() => this.tick(), 1000)
    }

    tick() {
        this.timeLeft--
        this.timerTarget.textContent = this.formatTime(this.timeLeft)

        if (this.timeLeft <= 0) {
            clearInterval(this.timerInterval)
            this.finish()
        }
    }

    formatTime(seconds) {
        const m = Math.floor(seconds / 60)
        const s = seconds % 60
        return `${m}:${s.toString().padStart(2, '0')}`
    }

    select(event) {
        const hiraganaId = event.params.hiraganaId
        const character = event.params.character
        const romaji = event.params.romaji

        this.selectedIds.push({ id: hiraganaId, character, romaji })
        this.updateSelection()
    }

    undo() {
        if (this.selectedIds.length === 0) return
        this.selectedIds.pop()
        this.updateSelection()
    }

    reset() {
        this.selectedIds = []
        this.updateSelection()
    }

    updateSelection() {
        this.selectionTarget.textContent = this.selectedIds.map(h => h.character).join('')
        if (this.hasRomajiTarget) {
            this.romajiTarget.textContent = this.selectedIds.map(h => h.romaji).join('')
        }

        this.updateSubmitButtonState()
    }

    updateSubmitButtonState() {
        const currentWord = this.selectedIds.map(h => h.character).join('')
        const isEmpty = this.selectedIds.length === 0
        const alreadyFound = this.foundWords.includes(currentWord)

        this.submitButton.disabled = isEmpty || alreadyFound
    }

    get submitButton() {
        return this.element.querySelector('[data-toolbar-validate]')
    }

    async validate() {
        const selected = this.selectedIds.map(h => h.id).join(',')

        const response = await fetch('/hiragana/assemblage/valider', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                selected,
                difficulty: this.difficultyValue,
                sessionId: this.sessionIdValue,
            }),
        })

        const data = await response.json()

        if (data.result === 'success') {
            this.foundWords.push(data.hiragana)
            this.score += data.xpAmount
            this.scoreTarget.textContent = `${this.score} pts`
            this.showTranslation(data.translation)
        }

        this.submitButton.disabled = true
    }

    showTranslation(translation) {
        this.translationTarget.textContent = translation
        this.reset()

        setTimeout(() => {
            this.translationTarget.textContent = ''
        }, 3000)
    }

    finish() {
        this.finishFormTarget.requestSubmit()
    }
}
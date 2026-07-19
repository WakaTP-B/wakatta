import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['animationContainer', 'drawing', 'modal', 'modalMessage', 'modalXp']
    static values = { svgUrl: String, romaji: String }

    connect() {
    if (this.hasAnimationContainerTarget) {
        this.loadAnimation()
    }
    if (this.hasDrawingTarget) {
        this.loadDrawing()
    }
}

    loadAnimation() {
        fetch(this.svgUrlValue)
            .then(response => response.text())
            .then(svg => {
                this.animationContainerTarget.innerHTML = svg
            })
    }

    // On récupère le dessin stocké temporairement par la page practice
    loadDrawing() {
        const drawingImage = sessionStorage.getItem('calligraphie_drawing')

        if (drawingImage) {
            this.drawingTarget.src = drawingImage
        }
    }

    evaluate(event) {
        const result = event.currentTarget.dataset.result

        fetch('/hiragana/calligraphie/evaluation/reponse', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `result=${result}`,
        })
            .then(response => response.json())
            .then(data => {
                const messages = {
                    reussi: 'Bien joué !',
                    moyen: "Pas mal, continue à t'entraîner !",
                    rate: "Il faut encore s'entraîner !",
                }
                this.modalMessageTarget.textContent = messages[result]
                this.modalXpTarget.textContent = `+${data.xpAmount} XP`
                this.modalTarget.classList.remove('hidden')
            })
    }
}
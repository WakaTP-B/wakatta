import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['animationContainer', 'canvas']
    static values = { romaji: String, svgUrl: String, evaluationUrl: String }

    // Historique des traits dessinés, pour Annuler/Rétablir
    strokes = []
    redoStack = []
    isDrawing = false
    currentStroke = []

    connect() {
        this.loadAnimation()
        this.setupCanvas()
    }

    // Charge et injecte le SVG animé du hiragana en cours
    loadAnimation() {
        fetch(this.svgUrlValue)
            .then(response => response.text())
            .then(svg => {
                this.animationContainerTarget.innerHTML = svg
            })
    }

    // Relance l'animation sans toucher au dessin de l'utilisateur
    replay() {
        this.loadAnimation()
    }

    setupCanvas() {
        this.ctx = this.canvasTarget.getContext('2d')
        this.ctx.strokeStyle = '#C8463C'
        this.ctx.lineWidth = 8
        this.ctx.lineCap = 'round'
        this.ctx.lineJoin = 'round'

        this.canvasTarget.addEventListener('pointerdown', this.startStroke.bind(this))
        this.canvasTarget.addEventListener('pointermove', this.drawStroke.bind(this))
        this.canvasTarget.addEventListener('pointerup', this.endStroke.bind(this))
    }

    startStroke(event) {
        this.isDrawing = true
        const pos = this.getPosition(event)
        this.currentStroke = [pos]

        this.ctx.beginPath()
        this.ctx.moveTo(pos.x, pos.y)
        this.ctx.lineTo(pos.x, pos.y)
        this.ctx.stroke()
    }

    drawStroke(event) {
        if (!this.isDrawing) return

        const pos = this.getPosition(event)
        this.currentStroke.push(pos)

        const previous = this.currentStroke[this.currentStroke.length - 2]
        this.ctx.beginPath()
        this.ctx.moveTo(previous.x, previous.y)
        this.ctx.lineTo(pos.x, pos.y)
        this.ctx.stroke()
    }

    endStroke() {
        if (!this.isDrawing) return

        this.isDrawing = false
        this.strokes.push(this.currentStroke)
        // Un nouveau trait dessiné invalide la pile de "rétablir"
        this.redoStack = []
    }

    undo() {
        if (this.strokes.length === 0) return

        const lastStroke = this.strokes.pop()
        this.redoStack.push(lastStroke)
        this.redrawAll()
    }

    redo() {
        if (this.redoStack.length === 0) return

        const stroke = this.redoStack.pop()
        this.strokes.push(stroke)
        this.redrawAll()
    }

    // Efface tout le canvas et redessine chaque trait encore actif
    redrawAll() {
        this.ctx.clearRect(0, 0, this.canvasTarget.width, this.canvasTarget.height)

        this.strokes.forEach(stroke => {
            this.ctx.beginPath()
            this.ctx.moveTo(stroke[0].x, stroke[0].y)
            stroke.forEach(point => this.ctx.lineTo(point.x, point.y))
            this.ctx.stroke()
        })
    }

    getPosition(event) {
        const rect = this.canvasTarget.getBoundingClientRect()
        return {
            x: event.clientX - rect.left,
            y: event.clientY - rect.top,
        }
    }

    validate() {
    // Save le dessin dans SessionStorage pour l'auto-éval
    const drawingImage = this.canvasTarget.toDataURL('image/png')
    sessionStorage.setItem('calligraphie_drawing', drawingImage)
    window.location.href = this.evaluationUrlValue
}
}
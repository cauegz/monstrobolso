export class Background {
    constructor(game) {
        this.game = game;
        this.images = [
            "../images/background/mercado/mercado-publico-entrada.jpeg",
            "../images/background/mercado/dentro-mercado-publico.png",
        ];
        this.current = 0;
        this.image = new Image();
        this.image.src = this.images[this.current];
    }
    draw(context) {
        context.drawImage(this.image, 0, 0, this.game.width, this.game.height);
    }
    changeBackground(direction) {
        this.current += direction;
        if (this.current < 0) {
            this.current = this.images.length - 1;
        } else if (this.current >= this.images.length) {
            this.current = 0;
        }
        this.image.src = this.images[this.current];
    }
}
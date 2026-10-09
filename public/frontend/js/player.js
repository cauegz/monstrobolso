export class Player {
    constructor(game){
        this.game = game;
        // tamanho do recorte no Spritesheet
        this.spriteWidth = 256;
        this.spriteHeight = 320;

        // tamanho do jogador no jogo
        this.width = 60;
        this.height = 75;

        this.x = 0;
        this.y = this.game.height - this.height;
        this.image = document.getElementById('player');
        this.speedX = 0;
        this.speedY = 0;
        this.maxSpeed = 5;
    }

    //metodo pra mover com base no que o jogar clicar e para percorrer o quadrado com as sprites
    update(input){
        // detecta qual tecla foi pressionada no array input
        //horinzontal
        if(input.includes('ArrowRight')) this.speedX = this.maxSpeed;
        else if(input.includes('ArrowLeft')) this.speedX = -this.maxSpeed;
        else this.speedX = 0;
        this.x += this.speedX;
        //vertical
        if(input.includes('ArrowDown')) this.speedY = this.maxSpeed;
        else if(input.includes('ArrowUp')) this.speedY = -this.maxSpeed;
        else this.speedY = 0;
        this.y += this.speedY;
        //impede que o jogador passe da tela do canvas
        if(this.x<=0){
            this.game.background.changeBackground(-1);
            this.x = this.game.width - this.width;
        }
        if(this.x >= this.game.width - this.width) {
            this.x = this.game.width - this.width;
            this.game.background.changeBackground(1);
            this.x = 0;
        }
        if(this.y<0) this.y=0;
        if(this.y > this.game.height - this.height) this.y = this.game.height - this.height;
    }

    //pega os valores e desenha o quadrado atualmente ativo e as coordenadas
    draw(context){
        context.drawImage(this.image, 0, 0, this.spriteWidth, this.spriteHeight, this.x, this.y, 60, 75) 
    }   
}
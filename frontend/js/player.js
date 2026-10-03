export class Player {
    constructor(game){
        this.game = game;
        this.width = 256;
        this.height = 320;
        //usar 60 e 75 quando colocar no draw, os tamanho acima são o tamanho da divisão de cada frame desse spritesheet especifico e não o tamanho a ser aplicado no jogo
        this.x = 0;
        this.y = this.game.height - this.height;
        this.image = document.getElementById('player');
    }

    //metodo pra mover com base no que o jogar clicar e para percorrer o quadrado com as sprites
    update(){
        this.x++;
    }

    //pega os valores e desenha o quadrado atualmente ativo e as coordenadas
    draw(context){
        context.drawImage(this.image, 0, 0, this.width, this.height, this.x, this.y, 60, 75) 
    }   
}
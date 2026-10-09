import { Player } from "./player.js";
import { InputHandler } from "./input.js";
import { Background } from "./background.js";
window.addEventListener('load', function(){
    const canvas = document.getElementById('gameCanvas');
    const context = canvas.getContext('2d');
    canvas.width = 1020;
    canvas.height = 586;

    class Game{
        constructor(width, height){
            this.width = width;
            this.height = height;
            this.player = new Player(this);
            this.input = new InputHandler();
            this.background = new Background(this);
        }
        update(){
            this.player.update(this.input.keys);
        }
        draw(context){
            this.background.draw(context);
            this.player.draw(context);
        }
    }

    const game = new Game(canvas.width, canvas.height); 
    console.log(game);

    function animate(){
        context.clearRect(0, 0, canvas.width, canvas.height); // limpa o canvas para que ao mudar objetos de posição não deixar rastro
        game.update();
        game.draw(context);
        requestAnimationFrame(animate);
    }
    animate();
})
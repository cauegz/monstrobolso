import { Player } from "./player.js";
window.addEventListener('load', function(){
    const canvas = document.getElementById('gameCanvas');
    const context = canvas.getContext('2d');
    canvas.width = 500;
    canvas.height = 500;

    class Game{
        constructor(width, height){
            this.width = width;
            this.height = height;
            this.player = new Player(this);
        }
        update(){
            this.player.update();
        }
        draw(context){
            this.player.draw(context);
        }
    }

    window.game = new Game(canvas.width, canvas.height); 
    // deixa com wndow pq descobri que modulos js tem o proprio escopo
    console.log(window.game);

    function animate(){
        context.clearRect(0, 0, canvas.width, canvas.height); // limpa o canvas para que ao mudar objetos de posição não deixar rastro
        game.update();
        game.draw(context);
        requestAnimationFrame(animate);
    }
    animate();
})
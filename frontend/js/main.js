window.addEventListener('load', function(){
    const canvas = document.getElementById('gameCanvas');
    const context = canvas.getContext('2d');
    canvas.width = 500;
    canvas.height = 500;

    class Game{
        constructor(width, height){
            this.width = width;
            this.height = height;
        }
        update(){

        }
        draw(){
            
        }
    }
})
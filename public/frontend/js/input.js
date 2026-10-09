export class InputHandler{
    constructor(){
        this.keys = [];
        // adiciona a tecla pressionada no array
        window.addEventListener('keydown', e =>{
            if(
                (e.key === 'ArrowDown' ||
                e.key === 'ArrowUp' ||
                e.key === 'ArrowLeft' ||
                e.key === 'ArrowRight' ||
                e.key === 'Enter' )
                && this.keys.indexOf(e.key) === -1
            ){
                this.keys.push(e.key);
            }
            console.log(e.key,this.keys);
        });
        //remove a tecla do array
        window.addEventListener('keyup', e =>{
             if(e.key === 'ArrowDown' ||
                e.key === 'ArrowUp' ||
                e.key === 'ArrowLeft' ||
                e.key === 'ArrowRight'||
                e.key === 'Enter'){
                this.keys.splice(this.keys.indexOf(e.key),1);     
            }
            console.log(e.key,this.keys);     
        });
    }
}
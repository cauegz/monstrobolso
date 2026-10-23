import Api from "./Api.js";
export default class batalhaView{
    #time
    construct(time){
        this.#time = time;
        this.configurarEventos();
    }

    configurarEventos(){
        const opcoes = document.querySelectorAll('.btn-opc');
        console.log(opcoes);
        opcoes.forEach(opcao => 
            opcao.addEventListener('click', ()=>{
            console.log(opcao);
        }));
    }
}
async function carregaTime(){
    try{
        const promisePoke = fetch(`http://localhost:8080/api/time`);
    }catch(error){
        console.log("erro ao carregar poke primario: " + error);
    }
}
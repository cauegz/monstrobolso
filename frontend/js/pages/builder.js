
import verificarSessao from "../services/verificarSessao.js";
import Time from "../entities/Time.js";
import Api from "../APIs/Api.js";
import BuilderView from "../entities/view/BuilderView.js";

async function iniciarBuilder() {
    try {
        //sessao
        const usuario = await verificarSessao();
        if (!usuario) return;

        // Carrega o time 
        const objTime = await Time.carregarTime(usuario.treinador);
        new BuilderView(objTime);

        document.getElementById("enviar")
            .addEventListener("click", async () => {
                try {
                    console.log(objTime)
                    await Api.enviarTime(objTime);

                    console.log("time enviado ");
                } catch (erro) {
                    console.error("erro ao enviar o time:", erro);
                }
            });

    } catch (erro) {
        console.error("erro ao iniciar o builder:", erro);
    }
}

iniciarBuilder();

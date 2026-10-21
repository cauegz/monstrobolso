
import verificarSessao from "./verificarSessao.js";
import Time from "./Time.js";
import Api from "./Api.js";
import builderView from "./builderView.js";

async function iniciarBuilder() {
    try {
        //sessao
        const usuario = await verificarSessao();
        if (!usuario) return;

        // Carrega o time 
        const objTime = await Time.carregarTime(usuario.treinador);
        new builderView(objTime);

        document.getElementById("enviar")
            .addEventListener("click", async () => {
                try {
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


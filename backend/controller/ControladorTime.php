<?php
class ControladorTime extends ControladorGeral{
    /**
     * Cria um time recebendo um json com os ids dos pokemon que o usuário escolheu
     * Espera o seguinte POST
     * {
     *     "pokemon": [
     *          -- id1,
     *          -- id2, etc...
     *      ]
     * }
     */
    public function criarTime(){
        session_start();
        if(!isset($_SESSION['usuario_id'])){
            $this->responseError("rota nao encontrada", 404); //certo seria 401, mas para não expor a rota dei 404
        }
        $idTreinador = $_SESSION['treinador'];

        $ids = $this->receiveJSON()['pokemon'];
        
        $indice = 0;
        try{
            foreach ($ids as $id) {
                $posicao = $indice + 1;
                if($id == null || !$id){
                    $time = Time::findByTreinadorAndPosicao($idTreinador, $posicao);
                    if($time)
                        Time::delete($time->id);
                    $indice++;
                    continue;
                }
            
                //puxa os dados da api para salvar os status base no banco
                $pokeApi = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/$id"));
                
                $pokemon = new Pokemon();

                $pokemon->treinador = $idTreinador;
                $pokemon->pokeApi = $id;

                foreach ($pokeApi->stats as $stat) {
                    $nomeStatApi = $stat->stat->name;

                    //os nomes vem em inglês, por isso precisa "traduzir" para o nosso objeto
                    switch ($nomeStatApi) {
                        case 'attack':
                            $pokemon->ataque = $stat->base_stat;
                            break;
                        
                        case 'defense':
                            $pokemon->defesa = $stat->base_stat;
                            break;

                        case 'special-attack':
                            $pokemon->ataqueEspecial = $stat->base_stat;
                            break;
                        
                        case 'special-defense':
                            $pokemon->defesaEspecial = $stat->base_stat;
                            break;

                        case 'hp':
                            $pokemon->hp = $stat->base_stat;
                            break;

                        case 'speed':
                            $pokemon->velocidade = $stat->base_stat;
                            break;
                    }
                }
                $pokemon->save();

                $time = Time::findByTreinadorAndPosicao($pokemon->treinador, $indice+1);
                
                if ($time) {
                    $time->pokemon = $pokemon->id;
                } else {
                    $time = new Time();
                    $time->treinador = $idTreinador;
                    $time->pokemon = $pokemon->id;
                    $time->posicao = $indice + 1;
                }

                $time->save();

                $indice++;
            }
        }catch(Exception $e){
            $this->responseError($e->getMessage(), 500);
        }

        $this->responseJSON(["ok" => true]);
    }

    /**
     * retorna o time atual do usuário no parametro get id
     */
    public function time(){
        session_start();
        $treinador = $_GET['id'];
        $posicao = 1;
        $time = [];
        while($posicao <= 6){
            $time[] = Time::findByTreinadorAndPosicao($treinador, $posicao);
            $posicao++;
        }
        $this->responseJSON($time);
    }
}
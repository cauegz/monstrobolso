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
        $idUsuario = $_SESSION['usuario_id'];

        $ids = $this->receiveJSON()['pokemon'];
        
        $indice = 0;
        try{
            foreach ($ids as $id) {
                $posicao = $indice + 1;
                if($id == null || !$id){
                    $time = Time::findByTreinadorAndPosicao($idUsuario, $posicao);
                    if($time)
                        Time::delete($time->id);
                    $indice++;
                    continue;
                }
                $pokemonExistente = Pokemon::findByPokeApiAndTreinador($id, $idUsuario);
                if($pokemonExistente){
                    $pokemon = $pokemonExistente;
                } else {
                    //puxa os dados da api para salvar os status base no banco
                    $pokeApi = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/$id"));
                    
                    $pokemon = new Pokemon();

                    $pokemon->treinador = $idUsuario;
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
                }

                $time = Time::findByTreinadorAndPosicao($pokemon->treinador, $indice+1);
                
                if ($time) {
                    $time->pokemon = $pokemon->id;
                } else {
                    $time = new Time();
                    $time->treinador = $idUsuario;
                    $time->pokemon = $pokemon->id;
                    $time->posicao = $indice + 1;
                }

                $time->save();

                $indice++;
            }
        }catch(Exception $e){
            $this->responseError($e->getMessage(), 500);
        }

        //ver oq retornar aqui depois, ta vulneravel a sql injection
        $this->responseJSON(["ok" => true]);
    }

    /**
     * retorna o time atual do treinador logado
     */
    public function time(){
        session_start();
        $idUsuario = $_SESSION['usuario_id'];
        $posicao = 1;
        $time = [];
        while($posicao <= 6){
            $time[] = Time::findByTreinadorAndPosicao($idUsuario, $posicao);
            $posicao++;
        }
        $this->responseJSON($time);
    }
}
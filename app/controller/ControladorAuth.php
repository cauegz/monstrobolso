<?php
class ControladorAuth extends ControladorGeral{
    public function teste(){
        $this->responseJSON(["funcionando" => "sim"]);
    }
}
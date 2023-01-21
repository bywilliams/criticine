<?php
# classe responsável pelo controle das mensagens do sistema

class Message {
    private $url;

    public function __construct($ur){
        $this->url = $ur;
    }

    // pega uma mensagem do sistema
    public function getMessage() {

    }

    // insere uma mensagem no sistema
    // parametros: seta msg, tipo da msg e se redireciona ou não
    public function setMessage($msg, $type, $redirect = "index.php"){

    }

    // limpa a mensagem do sistema
    public function clearMessage(){

    }
}

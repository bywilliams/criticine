<?php
# classe responsável pelo controle das mensagens do sistema

class Message {

    private $url;

    public function __construct($ur){
        $this->url = $ur;
    }

    // pega uma mensagem do sistema
    public function getMessage() {
        if (!empty($_SESSION["msg"])) {
            return [
                "msg" => $_SESSION["msg"],
                "type" => $_SESSION["type"],
            ];
        }else {
            return false;
        }
    }

    // insere uma mensagem no sistema
    // parametros: seta msg, tipo da msg e se redireciona ou não
    public function setMessage($msg, $type, $redirect = "index.php"){
        $_SESSION["msg"] = $msg;
        $_SESSION["type"] = $type;

        if($redirect != "back") {
            // volta pra index
            header("Location: $this->url" . $redirect);
        }else {
            // volta para a última página referencia que ele acessou
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

    // limpa a mensagem do sistema
    public function clearMessage(){

    }
}

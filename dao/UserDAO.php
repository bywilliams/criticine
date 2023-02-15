<?php  
require_once("globals.php");
require_once("models/User.php");
require_once("models/Message.php");

    class UserDAO implements UserDAOInterface {


        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url){
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        // Constrói o objeto usuário
        public function buildUser($data)  {

            $user = new User();

            $user->id = $data['id'];
            $user->name = $data['name'];
            $user->lastname = $data['lastname'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->image = $data['image'];
            $user->token = $data['token'];
            $user->bio = $data['bio'];

            return $user;

        }

        public function create(User $user, $authUser = false) {

            $stmt = $this->conn->prepare("INSERT INTO users (
                name, lastname, email, password, token
            ) VALUES (
                :name, :lastname, :email, :password, :token
            )");

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);

            $stmt->execute();

            // Autenticar usuário, caso auth seja true
            if ($authUser) {
                $this->setTokenSession($user->token);
            }
        }

        public function update(User $user, $redirect = true) {

            $stmt = $this->conn->prepare("UPDATE users SET
                name = :name,
                lastname = :lastname,
                email = :email,
                image = :image,
                bio = :bio,
                token = :token
                WHERE id = :id
            ");

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":image", $user->image);
            $stmt->bindParam(":bio", $user->bio);
            $stmt->bindParam(":token", $user->token);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            if ($redirect) {
                
                // Redireciona para o perfeil do usuário
                $this->message->setMessage("Dados atualizados com sucesso!", "success", "editProfile.php");
            }

        }

        public function verifyToken($protected = false) {

            if (!empty($_SESSION["token"])) {
                
                // Pega o token da Session
                $token = $_SESSION["token"];

                // verifica se o token existe
                $user = $this->findByToken($token);

                if ($user) {
                    
                    // retorna o user para o front
                    return $user;
                }else if ($protected){

                     // Redireciona usuário não autenticado
                    $this->message->setMessage("É necessário estar atenticado para acessar esta página!", "error", "index.php");
                }

            }else if ($protected){

                // Redireciona usuário não autenticado
               $this->message->setMessage("É necessário estar atenticado para acessar esta página!", "error", "index.php");
           }

        }

        public function setTokenSession($token, $redirect = true) {
            
            // Salvar token na Sessão
            $_SESSION["token"] = $token;

            if ($redirect) {
                
                // Redireciona para o perfeil do usuário
                $this->message->setMessage("Seja bem-vindo!", "success", "editProfile.php");
            }

        }

        public function authenticateUser($email, $password) {

            $user = $this->findByEmail($email);

            // se encontrou o e-mail no BD
            if ($user) {
                
                // Checar se as senhas batem através da função password_verify()
                if (password_verify($password, $user->password)) {
                    
                    // Gera um token e inseri na session
                    $token = $user->generateToken();

                    $this->setTokenSession($token, false); // 

                    // Atualizar token no usuário
                    $user->token = $token; // primeiro no objeto

                    $this->update($user, false); // faz o Update pq foi gerado um novo token

                    return true;
                    
                } else {
                    return false;
                }

            } else {
                return false;
            }

        }
        
        public function findByEmail($email) {
            
            // checa se existe valor na variável por segurança
            if ($email != "") {
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(":email", $email);
                $stmt->execute();

                // verifica se a query retornou algo
                if ($stmt->rowCount() > 0) {
                    
                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                }else {
                    return false;
                }

            }else {
                return false;
            }

        }

        public function findById($id) {

        }

        public function findByToken($token) {

             // checa se existe valor na variável por segurança
             if ($token != "") {
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");
                $stmt->bindParam(":token", $token);
                $stmt->execute();

                // verifica se a query retornou algo, se encontrar retorna o usuário
                if ($stmt->rowCount() > 0) {
                    
                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                }else {
                    return false;
                }

            }else {
                return false;
            }

        }


        public function destroyToken(){

            // Remove o token da sessão
            $_SESSION["token"] = "";

            // redireciona e apresenta a mesnagem de sucesso
            $this->message->setMessage("Logout efetuado com sucesso.","success", "index.php");

        }

        public function changePassword(User $user) {

            $stmt = $this->conn->prepare("UPDATE users SET
                password = :password
                WHERE id = :id
            ");

            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":id", $user->id);
           
            $stmt->execute();

            // Redireciona e apresenta a mensagem de sucesso
            $this->message->setMessage("Senha alterada com sucesso!", "success", "editProfile.php");

        }
    }
<?php

Class User {
    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $image;
    public $token;
    public $bio;

    public function generateToken(){
        return bin2hex(random_bytes(50)); // random cria a string, bin2hex modifica a String deixando mais complexa
    }

    public function generatePassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

}

interface UserDAOInterface {
    public function buildUser($data); #irá construir o objeto
    public function create(User $user, $authUser = false); #irá criar o usuario e já fazer login
    public function update(User $user); #irá atualizar usuário no sistema
    public function verifyToken($protected = false); # irá verificar usuário
    public function setTokenSession($token, $redirect = true); # irá fazer o login
    public function authenticatorUser($email, $password); #junto com setTokenSession irá efetuar autenticação
    public function findByEmail($email); #irá encontrar usuário por email
    public function findById($id); #irá encontrar usuário pelo ID
    public function findByToken($token); #irá encontrar usuário no sistema pelo token
    public function changePassword(User $user); #irá mudar o password
}





<?php

class UserModel
{
    function get(int $id) :array
    {
        $database = new Database();
        $sql = 'SELECT id, firstname, lastname, email, password
                FROM user WHERE id = ? ';

        return $user = $database->queryOne($sql, [$id]);
    }

    function get_all() :array
    {
        $database = new Database();
        $sql = 'SELECT id, firstname, lastname, email
                FROM user';

        return $database->query($sql);
    }

    function email_exists(string $email) :bool
    {
        $database = new Database();
        $sql = 'SELECT id FROM user WHERE email = ?';

        $user = $database->queryOne($sql, [$email]);

        return $user !== false;
    }

    function login(string $email, string $password) :int
    {
        $database = new Database();
        $sql = 'SELECT id, password FROM user WHERE email = ?';

        $user = $database->queryOne($sql, [$email]);

        if($user == false or !$this->verify_password($password, $user['password'])){

            throw new DomainException('email or password doesn\'t match');
        }

        //If user's identification match

        return $user['id'];
    }

    function hash_password(string $password) :string
    {
        $salt = '$2y$11$'.substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);

        return crypt($password, $salt);
    }

    function verify_password($password, $hashed_password) :bool
    {
        return crypt($password, $hashed_password) == $hashed_password;
    }

    function create($firstname, $lastname, $email, $password)
    {
        if($this->email_exists($email))
        {
            throw new DomainException('Email already exists');
        }

        $password = $this->hash_password($password);

        $database = new Database();

        $sql = 'INSERT INTO user
                (firstname, lastname, email, password)
                VALUES (?,?,?,?)';

        return $database->executeSql($sql, [$firstname,$lastname,$email, $password]);
    }

    public function remove(int $user_id) :void
    {
        $database = new Database();
        $sql = 'DELETE FROM user
                WHERE id = ?';

        $database->executeSql($sql, [$user_id]);
    }

    public function update(string $firstname, string $lastname, int $id) :void
    {

        $database = new Database();

        $sql = 'UPDATE  user SET firstname = ?, lastname = ?
                WHERE id = ?';

        $database->executeSql($sql, [$firstname, $lastname, $id]);

    }
    
}
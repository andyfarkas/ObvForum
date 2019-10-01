<?php

namespace ObvForum\Users;

class User
{
    private $nickname;
    private $login;
    private $password;
    
    public function __construct(string $nickname, string $login, string $password)
    {
        $this->nickname = $nickname;
        $this->login = $login;
        $this->password = $password;
    }

    public function getNickname() : string
    {
        return $this->nickname;
    }

    public function getLogin() : string
    {
        return $this->login;
    }

    public function getPassword() : string
    {
        return $this->password;
    }
}

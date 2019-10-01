<?php

namespace ObvForum\Users;

class UsersStorage
{
    private $data = [];
    
    public function store(User $user)
    {
        $result = array_filter($this->data, function(User $storedUser) use($user) {
            return strcasecmp($user->getLogin(), $storedUser->getLogin()) == 0;
        });
        
        if (!empty($result))
        {
            throw new UserLoginAlreadyExistsException('Login '.$user->getLogin().' is already taken.');
        }
        
        $this->data[] = $user;
    }       
    
    public function loadByLogin(string $login)
    {
        $result = array_filter($this->data, function(User $user) use($login) {
            return strcasecmp($login, $user->getLogin()) == 0;
        });
        
        if (empty($result))
        {
            throw new UserNotFoundException("Could not find user with login '$login'");
        }
        
        return array_pop($result);
    }
}
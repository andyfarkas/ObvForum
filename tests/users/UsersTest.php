<?php

class UsersTest extends \PHPUnit\Framework\TestCase
{
    public function testItIsPossibleToStoreAndRetrieveAUserByLogin()
    {
        $storage = new ObvForum\Users\UsersStorage();
        
        $john = new ObvForum\Users\User(
                "john",
                "john@gmail.com",
                "somehash"
        );
        
        $alice = new ObvForum\Users\User(
                "alice",
                "alice@gmail.com",
                "somehash"
        );
        
        $storage->store($alice);
        $storage->store($john);        
        $storedUser = $storage->loadByLogin("john@gmail.com");
        
        $this->assertEquals($john, $storedUser);
    }
    
    public function testSearchForAUserThatDoesNotExists_throwsException()
    {       
        $emptyStorage = new ObvForum\Users\UsersStorage();   
        $this->expectException('ObvForum\Users\UserNotFoundException');
        $emptyStorage->loadByLogin("somelogin");
    }
    
    public function testStoreUserWithAlreadyTakenLogin_throwsException()
    {
        $storage = new ObvForum\Users\UsersStorage();        
        $john = new ObvForum\Users\User(
                "john",
                "john@gmail.com",
                "somehash"
        );
        
        $storage->store($john);
        
        $this->expectException('ObvForum\Users\UserLoginAlreadyExistsException');
        $storage->store($john);    
    }
}

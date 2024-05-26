<?php

class User extends Db
{

    protected function all()
    {
        $sql = "Select * from users";
        return $this->fetchAll($sql);
    }

    protected function fetchUser($id)
    {
        $sql = "Select * from users where id=$id";
        return $this->fetchOne($sql);
    }

    protected function createUser(){

    }

    protected function updateUser(){

    }

    protected function destroyUser(){
        
    }
}

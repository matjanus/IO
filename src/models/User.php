<?php

class User {
    private int $id_user;
    private string $username;
    private string $role;
    private string $password;
    private string $email;

    
    

    public function __construct(int $id, string $username, string $role, string $password, string $email) {
        $this->id_user = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;

    }

    public function getPassword(): string {
        return $this->password;
    }


    public function getId() {
        return $this->id_user;
    }

    public function getRole() {
        return $this->username;
    }



}
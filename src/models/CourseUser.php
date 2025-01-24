<?php

class CourseUser {
    private int $id_user;
    private string $username;
    private string $role;


    public function __construct(int $id, string $username, string $role) {
        $this->id_user = $id;
        $this->username = $username;
        $this->role = $role;

    }

    public function getId() {
        return $this->id_user;
    }

    public function getRole() {
        return $this->role;
    }

    public function getUsername() {
        return $this->username;
    }


}
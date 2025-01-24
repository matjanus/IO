<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $username): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.vusers_with_roles WHERE username = :username
        ');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user == false) {
            return null;
        }
        return new User(
            $user['id_user'],
            $user['username'],
            $user['role_name'],
            $user['password'],
            $user['email'],
        );
    }

    public function isEmailOccupied(string $email): bool{
        $stmt = $this->database->connect()->prepare('
            SELECT email FROM public.users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function isUsernameOccupied(string $username): bool{
        $stmt = $this->database->connect()->prepare('
            SELECT email FROM public.users WHERE username = :username
        ');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser(string $email, string $username, string $password): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.users (email, username, password)
            VALUES (?, ?, ?)
        ');
        
        $stmt->execute([
            $email,
            $username,
            $password,
        ]);
    }

    public function putNewSession($id_session, $id_user){
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public."sessions"(
	            id_session, id_user, last_activity)
	            VALUES (?, ?, NOW());
        ');
        
        $stmt->execute([
            $id_session,
            $id_user,
        ]);
    }

    public function  getUserFromCookies(string $cookie): ?User{
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.sessions WHERE id_session = :cookie
        ');
        $stmt->bindParam(':cookie', $cookie, PDO::PARAM_STR);
        $stmt->execute();

        $session = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($session == false) {
            return null;
        }

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.vusers_with_roles WHERE id_user = :id_user
        ');
        $stmt->bindParam(':id_user', $session["id_user"], PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user == null) {
            return null;
        }
        return new User(
            $user['id_user'],
            $user['username'],
            $user['role_name'],
            $user['password'],
            $user['email']
        );
    }

    public function setPassword(int $id_user, string $password): void{
        $stmt = $this->database->connect()->prepare('
            UPDATE public.users
                SET password= ?
                WHERE id_user = ?;
        ');
        
        $stmt->execute([
            $password,
            $id_user,
        ]);
    }



}
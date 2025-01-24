<?php
require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
class SecurityController extends AppController {

    public function login()
    {
        $userRepository = new UserRepository();
        if (!$this->isPost()) {
            $this->render('main');
            return;
        }

        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = $userRepository->getUser($username);
        if (!$user) {

            $this->render('main', ['message' => 'User with this email not exist!']);
            return;
        }

        if (password_verify($password, $user->getPassword())) {
            
            $id_session = bin2hex(random_bytes(32));
            $userRepository->putNewSession($id_session, $user->getId());
            setcookie("id_session", $id_session, time() + 86400, '/', "localhost", false, false);  //todo jak sie ustawi serwer to trzeba to zmienić!!!!!
            header("Location: /");
            exit();
            
        } else {
            $this->render('main', ['message' => 'Wrong password!']);
            return;
        }
        
    }

    private function getHashFromPassword(string $password): string{
        return password_hash($password, PASSWORD_BCRYPT);
    }

    
    private function checkPasswordConstraints(string $password): string{
        $hasUppercase = preg_match('/[A-Z]/', $password); 
        $hasLowercase = preg_match('/[a-z]/', $password);
        $hasDigit = preg_match('/[0-9]/', $password);
        $hasSpecialChar = preg_match('/[\W_]/', $password);

        $message = '';


        if (strlen($password) < 8) {
            return "The password is too short. The minimum length is 8 characters.";
        }

        if (!$hasUppercase) {
            return "The password must contain at least one uppercase letter.";
        }
        if (!$hasLowercase) {
            return "The password must contain at least one lowercase letter.";
        }
        if (!$hasDigit) {
            return "The password must contain at least one digit.";
        }
        if (!$hasSpecialChar) {
            return "The password must contain at least one special character (e.g., !@#$%^&*).";
        }

        return "";
    }

    public function register()
    {   
        if (!$this->isPost()) {
            $this->render('main');
            return;
        }
        $email = $_POST['email'];
        $email = trim(strtolower($email));
        $password = $_POST['password'];
        $repeatedPassword = $_POST['repeatedPassword'];
        $username = $_POST['username'];
        $usernameNoSpecialCharAndLen = preg_match('/^[a-zA-Z0-9]{4,20}$/', $username);


        $message = $this->checkPasswordConstraints($password);
       
        if($password !== $repeatedPassword){
            $message = "Passwords are not the same!";
        }

        if(!$usernameNoSpecialCharAndLen){
            $message = "Username musnt contain special character and length must be between 4 and 20 characters";
        }
        
        if(!empty($message)){
            $this->render('signUp', ['message' => $message]);
            return;
        }

        $userRepository = new UserRepository();
        if($userRepository->isEmailOccupied($email)){
            $this->render('signUp', ['message' => 'Email is occupated']);
            return;
        }
        if($userRepository->isUsernameOccupied($username)){
            $this->render('signUp', ['message' => 'Username is occupated']);
            return;
        }


        $hash = $this->getHashFromPassword($password);
        $userRepository->addUser($email, $username, $hash);
        $this->render('main', ['message' => 'You have been successfully registered!']);

    }

    public function logOut()
    {
        setcookie("id_session", "", time() - 1, '/', "localhost", false, false);  //todo jak sie ustawi serwer to trzeba to zmienić!!!!!
        header("Location: /");
        exit();
    }

    public function changePassword() {
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }

        $oldPass = $_POST['oldPassword'];
        $newPass = $_POST['newPassword'];
        $repeatedPassword = $_POST['repeatedPassword'];

        $message = $this->checkPasswordConstraints($newPass);

        if($newPass !== $repeatedPassword){
            $message = "Passwords are not the same!";
        }

        if($message != ""){
            $this->render('accountSettings', ["message" => $message]);
            return;
        }

        if(password_verify($oldPass, $user->getPassword())){
            $userRepository = new UserRepository();

            $userRepository->setPassword($user->getId(), $this->getHashFromPassword($newPass));
        }else{
            $message = "Wrong password";
        }
    
        $this->render('accountSettings', ["message" => $message]);
    }
}
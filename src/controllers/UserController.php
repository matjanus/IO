<?php

require_once 'AppController.php';


class UserController extends AppController {

    public function accountSettings()
    {
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }
        $this->render('accountSettings');
    }


}
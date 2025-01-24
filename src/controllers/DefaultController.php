<?php

require_once 'AppController.php';


class DefaultController extends AppController {

    public function index()
    {
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }
        $this->mainview($user);
    }


    public function signUp() {
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('signUp');                                                
            return;
        }
        $this->mainview($user);
    }

    private function mainview(User $user){
        $courseRepository = new CourseRepository();
        $courses = $courseRepository->getUsersCourses($user);

        $this->render('mainview', ["courses" => $courses]);
    } 

}
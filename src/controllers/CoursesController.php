<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/CourseRepository.php';
require_once __DIR__.'/../repository/PackageRepository.php';



class CoursesController extends AppController {


    public function course(array $exploaded_url): void
    {
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }
        $courseRepository = new CourseRepository();
        $id_course = (int)$exploaded_url[1];
        $role = $courseRepository->getUsersRoleInCourse($user, $id_course);
        //courese/id_courese
        if(!isset($exploaded_url[2])){
            if($role !== null){
                $packages = $courseRepository->getCoursePackages($id_course);
                $this->render('courseview', ["packages" => $packages, "role" => $role, "id_course" => $id_course]);
                return;
            }else{
                $this->redirect("/");
            }
            
        }
        //course/invite
        if($exploaded_url[2] === "invite"){
            $this->render('courseinvite', ["id_course" => $id_course, "role" => $role]);
            return;
        }elseif($exploaded_url[2] === "users"){
            if($role === "owner"){
                $participants = $courseRepository->getCourseParticipants($id_course);
                $this->render('courseusers', ["id_course" => $id_course, "participants" => $participants]);
                return;
            }
        }
        $this->render('errorpage');

        
        
    }

    public function newCourse() : void {
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }
        $this->render('newCourse');
    }


    public function joinCourse() : void {
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }
        $code = $_POST['code'];
        $courseRepository = new CourseRepository();
        $id_course = $courseRepository->getCourseByInviteCode($code);
        if($id_course === 0){
            $this->render('newCourse', ["message" => "Wrong code!"]);
            return;
        }
        if($courseRepository->ifUserHasAccessToCourse($user, $id_course)){
            $this->render('newCourse', ["message" => "You already have acces to this course!"]);
            return;
        }
        $courseRepository->deleteCode($code);
        $courseRepository->addUserToCourse($user, $id_course);

        $this->redirect("/course/".$id_course);
    }


    public function createNewCourse() : void {
        $user = $this->getUserFromCookies();
        if ($user === null) {
            $this->render('main');
            return;
        }
        $course_name = $_POST['courseName'];
        $courseRepository = new CourseRepository();

        $id_course = $courseRepository->createNewCourse($user->getId(),$course_name );
        $this->redirect("/");
    }


    public function generateCodes() {
        $user = $this->getUserFromCookies();

        if ($user === null) {
            $this->render('main');
            return;
        }

        if (!isset($_GET['count']) || !is_numeric($_GET['count'])) {
            echo json_encode([
                'codes' => ['Nie podano poprawnej liczby kodów.']
            ]);
            exit;
        }
        
        $count = (int)$_GET['count'];
        $id_course = $_GET['id_course'];

        if ($count <= 0 || $count > 100) {
            echo json_encode([
                'codes' => ['Liczba kodów musi być między 1 a 100.']
            ]);
            exit;
        }
        
        $courseRepository = new CourseRepository();
        $role = $courseRepository->getUsersRoleInCourse($user, $id_course);
        
        if($role !== "owner"){
            exit;
        }
        
        $codes = $courseRepository->generateCodes($count, $id_course);
        
        echo json_encode([
            'codes' => $codes
        ]);
    }

    public function deleteCouresCodes(){
        $user = $this->getUserFromCookies();
        if ($user === null) {
            return;
        }

        if(!isset($_GET['id_course'])){
            exit;
        }
        $id_course = $_GET['id_course'];

        $courseRepository = new CourseRepository();
        $role = $courseRepository->getUsersRoleInCourse($user, $id_course);

        if($role !== "owner"){
            exit;
        }

        $courseRepository->deleteCouresCodes($id_course);

        echo json_encode([
            'ans' => "Kody zostały usunięte"
        ]);
    }

    public function movePackage()
{
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }

        $id_package = (int) htmlspecialchars($_POST['id_package']);
        $id_course = (int) htmlspecialchars($_POST['id_course']);
        $direction = $_POST['direction'];

        $courseRepository = new CourseRepository();
        $role = $courseRepository->getUsersRoleInCourse($user, $id_course);

        if($role !== "owner" && $role !== "teacher"){
            exit;
        }



        $packageRepository = new PackageRepository();
        $packageRepository->movePackage($id_package, $id_course, $direction);
        $this->redirect("/course/".$id_course);
}
public function addPackage()
{
    $user = $this->getUserFromCookies();
    if ($user == null) {
        $this->render('main');
        return;
    }

    $id_course = (int) htmlspecialchars($_POST['id_course']);
    $package_name = htmlspecialchars($_POST['package_name']);

    $courseRepository = new CourseRepository();
    $role = $courseRepository->getUsersRoleInCourse($user, $id_course);

    if($role !== "owner" && $role !== "teacher"){
        exit;
    }

    if (empty($package_name)) {
        $this->render("courseview", ["message" => "Nazwa pakietu nie może być pusta."]);
        return;
    }

    $packageRepository = new PackageRepository();
    $packageRepository->addNewPackage($id_course, $package_name);

    $this->redirect("/course/".$id_course);
}

public function leaveCourse(){
    $user = $this->getUserFromCookies();
    if ($user == null) {
        $this->render('main');
        return;
    }

    $id_course = (int) htmlspecialchars($_POST['id_course']);
    $courseRepository = new CourseRepository();
    $role = $courseRepository->getUsersRoleInCourse($user, $id_course);

    if($role !== "owner"){
        $courseRepository->leaveCourse($user, $id_course);
    }else{
        $courseRepository->destroyCourse($id_course);
    }
    $this->redirect("/");
    

}


public function removeUserFromCourse(){
    $user = $this->getUserFromCookies();
    if ($user == null){
        $this->render('main');
        return;
    }
    $id_course = (int)htmlspecialchars($_POST['id_course']);
    $id_user_to_remove = (int)htmlspecialchars($_POST['id_user']);
    $courseRepository = new CourseRepository();
    $role = $courseRepository->getUsersRoleInCourse($user, $id_course);

    if( $role !== "owner" || $id_user_to_remove === $user->getId()){
        exit;
    }
    
    $courseRepository->removeUserFromCourse($id_course, $id_user_to_remove);
    $this->redirect("/course/$id_course/users");

}

public function toggleUserRole(){
    $user = $this->getUserFromCookies();
    if ($user == null){
        $this->render('main');
        return;
    }
    $id_course = (int)htmlspecialchars($_POST['id_course']);
    $id_user = (int)htmlspecialchars($_POST['id_user']);
    $courseRepository = new CourseRepository();
    $role = $courseRepository->getUsersRoleInCourse($user, $id_course);

    if( $role !== "owner" || $id_user === $user->getId()){
        exit;
    }
    $courseRepository->toggleUserRole($id_course, $id_user);
    $this->redirect("/course/$id_course/users");
}










}
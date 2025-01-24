<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/ExerciseRepository.php';


class PackagesController extends AppController {
    public function toggleVisibility()
{
    $user = $this->getUserFromCookies();
    if ($user == null) {
        $this->render('main');
        return;
    }

    $id_package = htmlspecialchars($_POST['id_package']);
    $id_course = htmlspecialchars($_POST['id_course']);
    $packageRepository = new PackageRepository();
    $role = $packageRepository->getUsersRoleForPackage($user, $id_package);
    if($role !== "owner" && $role !== "teacher"){
        exit;
    }

    $packageRepository->toggleVisibility($id_package);
    
    $this->redirect("/course/".$id_course);

}


    public function package(array $exploaded_url)
    {

        $id_package = (int)$exploaded_url[1];
        $user = $this->getUserFromCookies();
        if (!$user) {
            $this->render('login');
            return;
        }

        $packageRepository = new PackageRepository();
        $courseRepository = new CourseRepository();
        $exerciseRepository = new ExerciseRepository();

        $package = $packageRepository->getPackageById($id_package);
        $id_course = $package->getCourseId();
        $role = $courseRepository->getUsersRoleInCourse($user, $id_course);
        if (!$package) {
            $this->render('errorpage');
            return;
        }

        if(isset($exploaded_url[2])){
            $id_exercise = (int)$exploaded_url[2];
            $this->renderPackagesExercise($id_exercise, $role, $id_package, $user);
            return;
        }

        $exercises = $packageRepository->getPackageExercises($id_package);

        $userExercises = [];
        if ($role === 'owner' || $role === 'teacher') {
            $userExercises = $exerciseRepository->getUsersExercises($user);
        }

        $this->render('packageview', [
            'id_course' => $id_course,
            'id_package' => $id_package,
            'packageName' => $package->getName(),
            'exercises' => $exercises,
            'role' => $role,
            'userExercises' => $userExercises
        ]);
    }

    private function renderPackagesExercise(int $id_exercise, string $role, int $id_package, User $user) {
        $exerciseRepository = new ExerciseRepository();
        if (!$exerciseRepository->ifUserHasAccessToExercise($user, $id_exercise)) {
            $this->render('errorpage');
            exit();
        }
        $exercise = $exerciseRepository->getExerciseById($id_exercise);
        $submittedAnswers = $exerciseRepository->getSubmittedSolutions($id_package, $id_exercise);
        if (!$exercise) {
            $this->render('errorpage');
            exit();
        }

        $this->render("exercise", [
                "exercise" => $exercise,
                "role" => $role,
                "id_package" => $id_package,
                 "submittedAnswers" => $submittedAnswers
                ]);
    }

    public function deletePackage() {

        $user = $this->getUserFromCookies();
        if (!$user) {
            $this->render('login');
            return;
        }

        $id_package = htmlspecialchars($_POST['id_package']);
        $id_course = htmlspecialchars($_POST['id_course']);
        $packageRepository = new PackageRepository();
        $role = $packageRepository->getUsersRoleForPackage($user, $id_package);
        if($role !== "owner" && $role !== "teacher"){
            exit;
        }
        $packageRepository->deletePackage($id_package);
        $this->redirect("/course/".$id_course);
    }

    public function addExerciseToPackage() {
        $user = $this->getUserFromCookies();
        if (!$user) {
            $this->render('main');
            return;
        }
    
        $id_package = $_POST['id_package'];
        $id_exercise = $_POST['id_exercise'];
    
        $packageRepository = new PackageRepository();
        $packageRepository->addExerciseToPackage($id_package, $id_exercise);
    
        header("Location: /package/$id_package");
        exit();
    }

    public function deleteExerciseFromPackage(){
        $user = $this->getUserFromCookies();
        if (!$user) {
            $this->render('login');
            return;
        }

        $id_package = htmlspecialchars($_POST['id_package']);
        $id_exercise = htmlspecialchars($_POST['id_exercise']);
        $packageRepository = new PackageRepository();
        $role = $packageRepository->getUsersRoleForPackage($user, $id_package);
        if($role !== "owner" && $role !== "teacher"){
            $this->redirect("/package/".$id_package);
            exit;
        }
        $packageRepository->deleteExerciseFromPackage($id_package, $id_exercise);
        $this->redirect("/package/".$id_package);
    }

    public function submitSolution() {

        $user = $this->getUserFromCookies();
        if (!$user) {
            $this->render('login');
            return;
        }

        $id_exercise = htmlspecialchars($_POST['id_exercise']);
        $id_package = htmlspecialchars($_POST['id_package']);
        $answer = htmlspecialchars($_POST['solution']);

        $exerciseRepository = new ExerciseRepository();
        $exerciseRepository->saveExerciseAnswer($id_exercise, $id_package, $user, $answer);


        $this->redirect("/package/".$id_package);
        
    }



    


   
}
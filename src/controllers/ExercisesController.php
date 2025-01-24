<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/ExerciseRepository.php';


class ExercisesController extends AppController {

    public function exercises()
    {
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }

        $exerciseRepository = new ExerciseRepository();
        $exercises = $exerciseRepository->getUsersExercises($user);
        $this->render('exercisesview', ["exercises" => $exercises]);
    }

    public function newExercise()
    {
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }

        $this->render('newexercise');
    }

    public function makeNewExercise(){
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }

        $name = htmlspecialchars($_POST['name']);
        $instruction = htmlspecialchars($_POST['instruction']);
        $hint = htmlspecialchars($_POST['hint']);
        $result = htmlspecialchars($_POST['result']);
        $solution = htmlspecialchars($_POST['solution']);
        

        $exerciseRepository = new ExerciseRepository();
        $exerciseRepository->makeNewExercise($user, $name, $instruction, $hint, $result, $solution);

        $this->exercises();
    }

    public function deleteExercise(){
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }
        $id_exercise = htmlspecialchars($_POST['id']);
        $exerciseRepository = new ExerciseRepository();
        $exerciseRepository->deleteExercise($user, $id_exercise);
        $this->exercises();
    }

    public function editExercise()
    {
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }

        if (!isset($_GET['id_exercise'])) {
            $this->render('exercisesview', ['message' => 'Brak ID zadania']);
            return;
        }

        $id_exercise = htmlspecialchars($_GET['id_exercise']);
        $exerciseRepository = new ExerciseRepository();
        $exercise = $exerciseRepository->getUsersExerciseById($user, $id_exercise);

        if (!$exercise) {
            $this->render('exercisesview', ['message' => 'Nie znaleziono zadania']);
            return;
        }

        $this->render('editexercise', ['exercise' => $exercise]);
    }

    public function updateExercise()
    {
        $user = $this->getUserFromCookies();
        if ($user == null) {
            $this->render('main');
            return;
        }

        $id_exercise = htmlspecialchars($_POST['id']);
        $name = htmlspecialchars($_POST['name']);
        $instruction = htmlspecialchars($_POST['instruction']);
        $hint = htmlspecialchars($_POST['hint']);
        $result = htmlspecialchars($_POST['result']);
        $solution = htmlspecialchars($_POST['solution']);

        $exerciseRepository = new ExerciseRepository();
        $exerciseRepository->updateExercise($user, $id_exercise, $name, $instruction, $hint, $result, $solution);

        $this->exercises();
    }


}
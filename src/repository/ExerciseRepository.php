<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Exercise.php';

class ExerciseRepository extends Repository
{

    public function getUsersExercises(User $user): ?Array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.exercises WHERE id_author = ? ORDER BY id_exercise DESC
        ');

        $stmt->execute([$user->getId()]);

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($res === false){
            return [];
        }
        $exercises = [];
        foreach ($res as $exercisesData) {
            $exercise =  new Exercise(
                $exercisesData['id_exercise'],
                $exercisesData['name'],
                $exercisesData['id_author']
            );
            $exercises[] = $exercise;
            
        }
        return $exercises;
    }

    public function makeNewExercise(User $user, string $name, string $instruction, string $hint, string $result, string $solution){
        $stmt = $this->database->connect()->prepare('
            INSERT INTO exercises (name, id_author, instruction, hint, result, solution) 
            VALUES ( ?, ?, ?, ?, ?, ?)
        ');

        $stmt->execute([$name, $user->getId(), $instruction, $hint, $result, $solution]);
    }

    public function deleteExercise(User $user, int $id_exercise){
        $stmt = $this->database->connect()->prepare('
            DELETE FROM exercises WHERE id_author = ? and id_exercise = ?
        ');

        $stmt->execute([$user->getId(),$id_exercise]);
    }

    public function getUsersExerciseById(User $user, int $id_exercise): ?Exercise
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.exercises WHERE id_author = ? AND id_exercise = ?
        ');

        $stmt->execute([$user->getId(), $id_exercise]);
        $exerciseData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$exerciseData) {
            return null;
        }

        $exercise = new Exercise(
            $exerciseData['id_exercise'],
            $exerciseData['name'],
            $exerciseData['id_author']
        );

        $exercise->addField('instruction', $exerciseData['instruction']);
        $exercise->addField('hint', $exerciseData['hint']);
        $exercise->addField('result', $exerciseData['result']);
        $exercise->addField('solution', $exerciseData['solution']);

        return $exercise;
}

    public function getExerciseById(int $id_exercise): ?Exercise
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.exercises WHERE id_exercise = ?
        ');

        $stmt->execute([$id_exercise]);
        $exerciseData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$exerciseData) {
            return null;
        }

        $exercise = new Exercise(
            $exerciseData['id_exercise'],
            $exerciseData['name'],
            $exerciseData['id_author']
        );

        $exercise->addField('instruction', $exerciseData['instruction']);
        $exercise->addField('hint', $exerciseData['hint']);
        $exercise->addField('result', $exerciseData['result']);
        $exercise->addField('solution', $exerciseData['solution']);

        return $exercise;
    }

    public function updateExercise(User $user, int $id_exercise, string $name, string $instruction, string $hint, string $result, string $solution)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE exercises 
            SET name = ?, instruction = ?, hint = ?, result = ?, solution = ?
            WHERE id_author = ? AND id_exercise = ?
        ');

        $stmt->execute([$name, $instruction, $hint, $result, $solution, $user->getId(), $id_exercise]);
    }

    public function ifUserHasAccessToExercise(User $user, int $id_exercise): bool
    {
        $stmt = $this->database->connect()->prepare("
            SELECT COUNT(*) 
                FROM exercises_in_packages eip
                JOIN packages p ON eip.id_package = p.id_package
                JOIN courses c ON p.id_course = c.id_course
                JOIN users_in_courses uic ON c.id_course = uic.id_course
                JOIN roles_in_courses ric ON ric.id_role_in_course = uic.id_role_in_course
                WHERE uic.id_user = ? AND eip.id_exercise = ? AND 
                (is_hidden = false OR ( role_name = 'owner' OR role_name = 'teacher'))
        ");

        $stmt->execute([
            $user->getId(),
            $id_exercise,
        ]);

        return (bool)$stmt->fetchColumn();
    }

    public function saveExerciseAnswer(int $id_exercise, int $id_package, User $user, string $answer) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO answers_for_exercises (id_exercise, id_package, id_user, answer)
            VALUES ( ?, ?, ?, ?)
            ON CONFLICT (id_exercise, id_package, id_user) 
            DO UPDATE SET answer = EXCLUDED.answer
        ');

        $stmt->execute([
            $id_exercise,
            $id_package,
            $user->getId(),
            $answer
        ]);
    }

    public function getSubmittedSolutions(int $id_package, int $id_exercise): array {
        $stmt = $this->database->connect()->prepare('
            SELECT answer 
            FROM answers_for_exercises
            WHERE id_package = ? AND id_exercise = ?
        ');

        $stmt->execute([
            $id_package,
            $id_exercise
        ]);

        $solutions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $ans = [];
        foreach($solutions as $solution){
            $ans[] = $solution["answer"];
        }
        return $ans;
    }

}
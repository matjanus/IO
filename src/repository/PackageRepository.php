<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Package.php';

class PackageRepository extends Repository
{
    public function movePackage(int $id_package, int $id_course, string $direction)
    {
        $db = $this->database->connect();

        try {
            $db->beginTransaction();
            $stmt = $db->prepare('
                SELECT position FROM packages WHERE id_package = ? AND id_course = ?
                ');
            $stmt->execute([$id_package, $id_course]);
            $currentPosition = $stmt->fetchColumn();
    
            if (!$currentPosition) {
                throw new Exception('Nie znaleziono pakietu.');
            }
    
            $newPosition = ($direction === 'up') ? $currentPosition - 1 : $currentPosition + 1;
    
            if ($newPosition < 1) {
                throw new Exception('Nie można przesunąć pakietu wyżej.');
            }
    
            $stmt = $db->prepare('
                UPDATE packages 
                SET position = ? 
                WHERE position = ? AND id_course = ?
            ');
            $stmt->execute([
                $currentPosition,
                $newPosition,
                $id_course
            ]);
    
            $stmt = $db->prepare('
                UPDATE packages 
                SET position = ? 
                WHERE id_package = ? AND id_course = ?
            ');
            $stmt->execute([
                $newPosition,
                $id_package,
                $id_course
            ]);
    
            // Zatwierdzenie transakcji
            $db->commit();
        } catch (Exception $e) {
            // Cofnięcie transakcji w przypadku błędu
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw $e;
        }
    }

    public function addNewPackage(int $id_course, string $package_name)
{
        $stmt = $this->database->connect()->prepare('
            SELECT MAX(position) as max_position FROM packages WHERE id_course = ?
        ');
        $stmt->execute([$id_course]);
        $maxPosition = $stmt->fetch(PDO::FETCH_ASSOC)['max_position'] ?? 0;

        $stmt = $this->database->connect()->prepare('
            INSERT INTO packages (name, id_course, position) 
            VALUES (?, ?, ?)
        ');
        $stmt->execute([$package_name, $id_course, $maxPosition + 1]);
}

    public function getUsersRoleForPackage(User $user, int $id_package): string
    {
        $stmt = $this->database->connect()->prepare('
            SELECT role_name FROM users_roles_in_packages WHERE id_user = ? AND id_package = ?
        ');
        $stmt->execute([$user->getId(),$id_package]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC)['role_name'] ?? "";
        return $role;
    }
    
    public function toggleVisibility(int $id_package)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE packages 
            SET is_hidden = NOT is_hidden
            WHERE id_package = ?
        ');
        $stmt->execute([$id_package]);
    }

    public function getPackageById(int $id_package): ?Package
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id_package, name, id_course, is_hidden
            FROM packages
            WHERE id_package = ?
        ');

        $stmt->execute([$id_package]);
        $package = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$package) {
            return null;
        }

        return new Package(
            $package['id_package'],
            $package['name'],
            (bool)$package['is_hidden'],
            $package['id_course']
        );
    }

    public function getPackageExercises(int $id_package): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT e.id_exercise, e.name, e.instruction, e.hint, e.result, e.solution, e.id_author
            FROM exercises_in_packages ep
            JOIN exercises e ON ep.id_exercise = e.id_exercise
            WHERE ep.id_package = ?
            ORDER BY e.id_exercise ASC
        ');

        $stmt->execute([$id_package]);
        $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($exercises as $exercise) {
            $exer = new Exercise(
                $exercise['id_exercise'],
                $exercise['name'],
                $exercise['id_author']
            );
            $exer->addField('instruction',$exercise['instruction']);
            $exer->addField('hint',$exercise['hint']);
            $exer->addField('result',$exercise['result']);
            $exer->addField('solution',$exercise['solution']);
            $result[] = $exer;
        }

        return $result;
    }

    public function deletePackage(int $id_package){

        $db = $stmt = $this->database->connect();
        try {
            $db->beginTransaction();

            $stmt = $db->prepare('
                SELECT position FROM packages WHERE id_package = :id_package;
            ');
            $stmt->execute([
                'id_package' => $id_package,
            ]);
            $package = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$package) {
                throw new Exception("Pakiet nie istnieje.");
            }

            $position = $package['position'];

            // Usuń pakiet z kursu
            $stmt = $db->prepare('
                DELETE FROM packages WHERE id_package = :id_package
            ');
            $stmt->execute([
                'id_package' => $id_package,
            ]);

            // Przesuń pozycje pozostałych pakietów
            $stmt = $db->prepare('
                UPDATE packages 
                SET position = position - 1 
                WHERE position > :position
            ');
            $stmt->execute([
                'position' => $position
            ]);

            $db->commit();
        } catch (Exception $e) {
            error_log("Błąd usuwania pakietu: " . $e->getMessage());
            $db->rollBack();
            
        }
    }
    public function addExerciseToPackage(int $id_package, int $id_exercise) {

        $conn = $this->database->connect();

        $stmt = $conn->prepare('
        SELECT COUNT(*) FROM exercises_in_packages WHERE id_package = ? and id_exercise = ?
        ');
        $stmt->execute([$id_package, $id_exercise]);
        $count = $stmt->fetchColumn();

        if ($count === 0) {
            $stmt = $this->database->connect()->prepare('
            INSERT INTO exercises_in_packages (id_package, id_exercise) VALUES (?, ?)
            ');
            $stmt->execute([$id_package, $id_exercise]);
        }
    }

    public function deleteExerciseFromPackage(int $id_package, int $id_exercise ){
        $stmt = $this->database->connect()->prepare('
        DELETE FROM public.exercises_in_packages
	        WHERE id_exercise = ? and id_package = ?;
        ');
        $stmt->execute([$id_exercise, $id_package]);
    }




}
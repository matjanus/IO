<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Course.php';
require_once __DIR__.'/../models/CourseUser.php';

class CourseRepository extends Repository {
    public function getUsersCourses(user $user): array{

        $stmt = $this->database->connect()->prepare('
            SELECT *
                FROM public.users_in_courses
                natural join roles_in_courses
                natural join courses
                where id_user = ? ;
        ');

        $stmt->execute([$user->getId()]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $courses = [];
        foreach ($res as $courseData) {
            $course =  new Course(
                $courseData['id_course'],
                $courseData['course_name']
            );
            $course->setAccess(
                $courseData['role_name']
            );
            $courses[] = $course;
            
        }
        return $courses;
    }

    public function getUsersRoleInCourse(User $user, int $id_course){
        $stmt = $this->database->connect()->prepare('
            SELECT role_name
	            FROM public.users_in_courses
                natural join roles_in_courses 
                where id_user = ? and id_course = ? ;
        ');

        $stmt->execute([$user->getId(), $id_course]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(isset($res[0])){
            return $res[0]["role_name"];
        }else{
            return null;
        }
        
    }


    public function getCourseByInviteCode(string $code) : int {
        $stmt = $this->database->connect()->prepare('
            SELECT id_course
                FROM public.codes
                where code = ? ;
        ');

        $stmt->execute([$code]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if(isset($res["id_course"])){
            return $res["id_course"];
        }else{
            return 0;
        }
    }

    public function ifUserHasAccessToCourse(User $user, int $id_course) : bool{
        $stmt = $this->database->connect()->prepare('
            SELECT * 
                FROM users_in_courses
                where id_course = ? and id_user = ?;
        ');
        $stmt->execute([$id_course, $user->getId()]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return (bool)$res;
    }
    
    public function addUserToCourse(User $user, int $id_course) : void {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.users_in_courses(
                id_user, id_course)
                VALUES (?, ?);
        ');

        $stmt->execute([$user->getId(), $id_course]);
    }


    public function createNewCourse(int $id_user, string $course_name) : int {
        
        $stmt = $this->database->connect()->prepare('
            INSERT INTO courses (course_name)
                VALUES ( ? )
                RETURNING id_course
        ');

        $stmt->execute([$course_name]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_course = $res["id_course"];

        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.users_in_courses(
                id_user, id_course, id_role_in_course)
                VALUES (?, ?, 3);
        ');

        $stmt->execute([$id_user, $id_course]);
        return $id_course;
    }

    public function getCoursePackages(int $id_course): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM packages WHERE id_course = ? ORDER BY position ASC
        ');
        $stmt->execute([$id_course]);
    
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res === false) {
            return [];
        }
    
        $packages = [];
        foreach ($res as $packageData) {
            $package = new Package(
                $packageData['id_package'],
                $packageData['name'],
                $packageData['is_hidden'],
                $id_course
            );
            $packages[] = $package;
        }
        return $packages;
    }

    public function generateCodes(int $no_codes, int $id_course) : array {
        $stmt = $this->database->connect()->prepare('
            select * from generate_codes( ? , ? )
        ');

        $stmt->execute([$no_codes, $id_course]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $codes = [];

        foreach ($res as $line) {
            $codes[] =  $line["generated_code"];
        }
        return $codes;
    }

    public function deleteCouresCodes(int $id_course) : void {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM codes WHERE id_course = ? ;
        ');
        $stmt->execute([$id_course]);
    }

    public function deleteCode(string $code) {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM codes WHERE code = ? ;
        ');
        $stmt->execute([$code]);

    }

    public function leaveCourse(User $user, int $id_course) {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM users_in_courses WHERE id_course = ?  AND id_user = ? ;
        ');
        $stmt->execute([$id_course, $user->getId()]);
    }

    public function destroyCourse(int $id_course){
        $stmt = $this->database->connect()->prepare('
            DELETE FROM courses WHERE id_course = ?
        ');
        $stmt->execute([$id_course]);
    }

    public function getCourseParticipants($id_course) : array {
        $stmt = $this->database->connect()->prepare('
            SELECT username, role_name, id_user
                FROM public.users_in_courses
                JOIN users USING (id_user)
                JOIN roles_in_courses USING (id_role_in_course)
                WHERE id_course = ?
        ');
        $stmt->execute([$id_course]);
    
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res === false) {
            return [];
        }
    
        $users = [];
        foreach ($res as $user) {
            $user = new CourseUser(
                $user['id_user'],
                $user['username'],
                $user['role_name'],
            );
            $users[] = $user;
        }
        return $users;
    }

    public function removeUserFromCourse(int $id_course, int $id_user){
        $stmt = $this->database->connect()->prepare('
        DELETE FROM users_in_courses WHERE id_course = ?  AND id_user = ? ;
        ');
        $stmt->execute([$id_course, $id_user]);
    }

    public function toggleUserRole(int $id_course, int $id_user){
        $stmt = $this->database->connect()->prepare('
        UPDATE users_in_courses SET id_role_in_course = 3 - id_role_in_course WHERE id_course = ?  AND id_user = ? ;
        ');
        $stmt->execute([$id_course, $id_user]);
    }

}
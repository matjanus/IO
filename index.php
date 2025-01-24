<?php

require 'Routing.php';


$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::post('login', 'SecurityController');
Router::post('register', 'SecurityController');
Router::post('logOut', 'SecurityController');
Router::post('changePassword', 'SecurityController');
Router::get('signUp', 'DefaultController');
Router::get('accountSettings', 'UserController');
Router::get('course', 'CoursesController');
Router::get('newCourse', 'CoursesController');
Router::post('joinCourse', 'CoursesController');
Router::post('createNewCourse', 'CoursesController');
Router::post('deleteCouresCodes', 'CoursesController');
Router::get('generateCodes', 'CoursesController');
Router::get('exercises', 'ExercisesController');
Router::get('newExercise', 'ExercisesController');
Router::post('makeNewExercise', 'ExercisesController');
Router::post('deleteExercise', 'ExercisesController');
Router::get('editExercise', 'ExercisesController');
Router::post('updateExercise', 'ExercisesController');
Router::post('addPackage', 'CoursesController');
Router::post('toggleVisibility', 'PackagesController');
Router::post('movePackage', 'CoursesController');
Router::get('package', 'PackagesController');
Router::post('deletePackage', 'PackagesController');
Router::post('addExerciseToPackage', 'PackagesController');
Router::post('deleteExerciseFromPackage', 'PackagesController');
Router::post('submitSolution', 'PackagesController');
Router::post('leaveCourse', 'CoursesController');
Router::get('menageUsers', 'CoursesController');
Router::post('removeUserFromCourse', 'CoursesController');
Router::post('toggleUserRole', 'CoursesController');

Router::run($path);


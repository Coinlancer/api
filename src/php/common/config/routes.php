<?php

//$router->addGet('/get-categories-projects-number', [
//    "controller" => "index",
//    "action"     => "getCategoriesProjectsNumber"
//]);

// login
$router->addPost('/login', [
    'controller' => 'Auth',
    'action'     => 'login',
]);
$router->addPost('/register', [
    'controller' => 'Auth',
    'action'     => 'register',
]);
$router->addPost('/verify', [
    'controller' => 'Auth',
    'action'     => 'verify',
]);

// account
//$router->addPost('/account/{id}', [
//    'controller' => 'Account',
//    'action'     => 'get_account',
//]);
//$router->addPost('/account/update', [
//    'controller' => 'Account',
//    'action'     => 'update',
//]);


// project
$router->addGet('/projects', [
    'controller' => 'projects',
    'action'     => 'index',
]);
$router->addGet('/projects/{id}', [
    'controller' => 'projects',
    'action'     => 'show',
]);
$router->addGet('/projects/account/{id}', [
    'controller' => 'projects',
    'action'     => 'getByAccount',
]);
$router->addPost('/projects/create', [
    'controller' => 'projects',
    'action'     => 'create',
]);

// test file upload
$router->addPost('/projects/test', [
    'controller' => 'projects',
    'action'     => 'test',
]);


// common
$router->addGet('/skills', [
    'controller' => 'Common',
    'action'     => 'getSkills',
]);
$router->addGet('/categories', [
    'controller' => 'Common',
    'action'     => 'getCategories',
]);
$router->addGet('/subcategories', [
    'controller' => 'Common',
    'action'     => 'getChildCategories',
]);
//404 not found
$router->notFound([
    "controller" => "index",
    "action"     => "notFound"
]);
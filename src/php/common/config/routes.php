<?php

// authentication
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
$router->addPost('/account/role/activate', [
    'controller' => 'Accounts',
    'action'     => 'activateRole',
]);
$router->addGet('/account', [
    'controller' => 'Accounts',
    'action'     => 'show',
]);
$router->addGet('/account/{id}', [
    'controller' => 'Accounts',
    'action'     => 'show',
]);
//$router->addGet('/reviews/account/{id}', [
//    'controller' => 'Accounts',
//    'action'     => 'showReviews',
//]);
//$router->addPost('/reviews/account/{id}', [
//    'controller' => 'Accounts',
//    'action'     => 'saveReview',
//]);

// common functions
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
    'action'     => 'getSubCategories',
]);
$router->addGet('/freelancers', [
    'controller' => 'Common',
    'action'     => 'getFreelancers',
]);
//404 not found
$router->notFound([
    "controller" => "index",
    "action"     => "notFound"
]);

// projects
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
$router->addPost('/projects', [
    'controller' => 'projects',
    'action'     => 'create',
]);
$router->addPost('/projects/{id}', [ // check
    'controller' => 'projects',
    'action'     => 'update',
]);
// skills
$router->addPost('/projects/{project_id}/skills', [
    'controller' => 'projects',
    'action'     => 'addSkill',
]);
$router->addPost('/projects/{project_id}/skills/delete', [
    'controller' => 'projects',
    'action'     => 'deleteSkill',
]);
// steps
$router->addGet('/projects/{project_id}/steps', [
    'controller' => 'steps',
    'action'     => 'index',
]);
$router->addPost('/projects/{project_id}/steps', [
    'controller' => 'steps',
    'action'     => 'create',
]);
$router->addPost('/projects/steps/{id}', [
    'controller' => 'steps',
    'action'     => 'update',
]);
$router->addPost('/projects/steps/{id}/delete', [
    'controller' => 'steps',
    'action'     => 'delete',
]);
// attachments
$router->addPost('/projects/{id}/attachments', [
    'controller' => 'attachments',
    'action'     => 'save',
]);
$router->addPost('/projects/attachments/{id}/delete', [
    'controller' => 'attachments',
    'action'     => 'delete',
]);
// test file upload
$router->addPost('/projects/test', [
    'controller' => 'projects',
    'action'     => 'test',
]);
// suggestions
$router->addGet('/projects/{id}/suggestions', [
    'controller' => 'suggestions',
    'action'     => 'index',
]);
$router->addPost('/projects/{id}/suggestions', [
    'controller' => 'suggestions',
    'action'     => 'create',
]);
$router->addPost('/projects/suggestions/{id}/delete', [
    'controller' => 'suggestions',
    'action'     => 'delete',
]);
$router->addPost('/projects/suggestions/{id}/confirm', [
    'controller' => 'suggestions',
    'action'     => 'confirm',
]);
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
$router->addPost('/account/update', [
    'controller' => 'Accounts',
    'action'     => 'update',
]);
$router->addPost('/account/password/update', [
    'controller' => 'Accounts',
    'action'     => 'updatePassword',
]);
$router->addPost('/account/send-emails', [
    'controller' => 'Accounts',
    'action'     => 'sendEmails',
]);
$router->addPost('/account/avatar', [
    'controller' => 'Accounts',
    'action'     => 'saveAvatar',
]);
$router->addPost('/account/avatar/delete', [
    'controller' => 'Accounts',
    'action'     => 'deleteAvatar',
]);
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
$router->addPost('/projects/{project_id}/steps/{id}', [
    'controller' => 'steps',
    'action'     => 'update',
]);
$router->addPost('/projects/{project_id}/steps/{id}/delete', [
    'controller' => 'steps',
    'action'     => 'delete',
]);

//steps finances
$router->addPost('/projects/steps/{id}/deposit', [
    'controller' => 'steps',
    'action'     => 'deposit',
]);

$router->addPost('/projects/steps/{id}/done', [
    'controller' => 'steps',
    'action'     => 'markAsDone',
]);

$router->addPost('/projects/steps/{id}/complete', [
    'controller' => 'steps',
    'action'     => 'markAsCompleted',
]);

$router->addPost('/projects/steps/{id}/refund', [
    'controller' => 'steps',
    'action'     => 'refund',
]);

// attachments
$router->addPost('/projects/{id}/attachments', [
    'controller' => 'attachments',
    'action'     => 'save',
]);
$router->addGet('/projects/{project_id}/attachments/{id}', [
    'controller' => 'attachments',
    'action'     => 'get',
]);
$router->addPost('/projects/{project_id}/attachments/{id}/delete', [
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
$router->addPost('/projects/{project_id}/suggestions/delete', [
    'controller' => 'suggestions',
    'action'     => 'delete',
]);
$router->addPost('/projects/suggestions/confirm', [
    'controller' => 'suggestions',
    'action'     => 'confirm',
]);
// clients
$router->addGet('/clients/{id}', [
    'controller' => 'clients',
    'action'     => 'show',
]);
// freelancers
$router->addGet('/freelancers/{id}', [
    'controller' => 'freelancers',
    'action'     => 'show',
]);
$router->addGet('/freelancers/suggestions', [
    'controller' => 'freelancers',
    'action'     => 'suggestions',
]);
$router->addGet('/freelancers/suggestions/project/{project_id}', [
    'controller' => 'freelancers',
    'action'     => 'projectSuggestion',
]);
$router->addGet('/freelancers/works', [
    'controller' => 'freelancers',
    'action'     => 'works',
]);
$router->addPost('/freelancers/skills/{id}', [
    'controller' => 'freelancers',
    'action'     => 'addSkill',
]);
$router->addPost('/freelancers/skills/{id}/delete', [
    'controller' => 'freelancers',
    'action'     => 'deleteSkill',
]);
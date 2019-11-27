<?php

use Illuminate\Routing\Router;

$namespace = ['namespace' => 'Application\Controllers'];

$router->group($namespace, function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->get('/home/index', 'HomeController@index');
    $router->get('/home/exampleone', 'HomeController@exampleOne');
    $router->get('/home/exampletwo', 'HomeController@exampleTwo');

    $router->get('/user/index', 'UserController@index');
    $router->get('/user/register', 'UserController@register');
    $router->post('/user/postRegister', 'UserController@postRegister');
    $router->get('/user/logIn', 'UserController@logIn');
    $router->post('/user/postLogIn', 'UserController@postLogIn');
    $router->post('/user/postLogOut', 'UserController@postLogOut');
    $router->get('/user/{id}/editUserRole', 'UserController@editUserRole');
    $router->post('/user/updateUserRole', 'UserController@updateUserRole');

    $router->get('/song/index', 'SongController@index');
    $router->post('/song/searchSong', 'SongController@searchSong');
    $router->post('/song/addSong', 'SongController@addSong');
    $router->get('/song/{id}/softDeleteSong',  'SongController@softDeleteSong');
    $router->get('/song/{id}/editSong', 'SongController@editSong');
    $router->post('/song/updateSong', 'SongController@updateSong');

    $router->get('/role/index', 'RoleController@index');
    $router->post('/role/addRole', 'RoleController@addRole');
    $router->get('/role/{id}/softDeleteRole', 'RoleController@softDeleteRole');
    $router->get('/role/{id}/editRole', 'RoleController@editRole');
    $router->post('/role/updateRole', 'RoleController@updateRole');

    $router->get('/playlist/index', 'PlaylistController@index');
    $router->post('/playlist/addPlaylist', 'PlaylistController@addPlaylist');
});

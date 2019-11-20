<?php

use Illuminate\Routing\Router;

$namespace = "Application\\Controllers\\";

$router->get('/',$namespace . 'HomeController@index');
$router->get('/home/index',$namespace . 'HomeController@index');
$router->get('/home/exampleone',$namespace . 'HomeController@exampleOne');
$router->get('/home/exampletwo',$namespace . 'HomeController@exampleTwo');

$router->get('/user/index',$namespace . 'UserController@index');
$router->get('/user/register',$namespace . 'UserController@register');
$router->post('/user/postRegister',$namespace . 'UserController@postRegister');
$router->get('/user/logIn',$namespace . 'UserController@logIn');
$router->post('/user/postLogIn',$namespace . 'UserController@postLogIn');
$router->post('/user/postLogOut',$namespace . 'UserController@postLogOut');
$router->get('/user/{id}/editUserRole',$namespace . 'UserController@editUserRole');
$router->post('/user/updateUserRole',$namespace . 'UserController@updateUserRole');

$router->get('/song/index',$namespace . 'SongController@index');
$router->post('/song/searchSong',$namespace . 'SongController@searchSong');
$router->post('/song/addSong',$namespace . 'SongController@addSong');
$router->get('/song/{id}/deleteSong',$namespace . 'SongController@deleteSong');
$router->get('/song/{id}/editSong',$namespace . 'SongController@editSong');
$router->post('/song/updateSong',$namespace . 'SongController@updateSong');

$router->get('/role/index',$namespace . 'RoleController@index');
$router->post('/role/addRole',$namespace . 'RoleController@addRole');
$router->get('/role/{id}/softDeleteRole',$namespace . 'RoleController@softDeleteRole');
$router->get('/role/{id}/editRole',$namespace . 'RoleController@editRole');
$router->post('/role/updateRole',$namespace . 'RoleController@updateRole');

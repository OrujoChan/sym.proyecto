<?php


$router->get("", "PagesController@index");
$router->get("registro", "authController@registro");
$router->post("check-registro", "authController@checkRegistro");
$router->get("profile", "app/controllers/profile.php");
$router->get("product", "app/controllers/product.php");
$router->get("cartas", "PagesController@cartas", 'ROLE_USER');
$router->get("nueva", "PagesController@nueva");
$router->post("nueva", "PagesController@nueva", 'ROLE_USER');
$router->get("login", "authController@login");
$router->get("cartas/:id", "PagesController@show");
$router->post('check-login', 'authController@checkLogin');
$router->get('logout', 'authController@logout');
$router->get('profile', 'authController@profile');
$router->get('profile/edit-picture', 'authController@editProfilePicture', 'ROLE_USER');
$router->post('profile/update-picture', 'authController@updateProfilePicture', 'ROLE_USER');
$router->get('profile/edit-username', 'authController@editProfileUsername', 'ROLE_USER');
$router->post('profile/update-username', 'authController@updateUsername', 'ROLE_USER');

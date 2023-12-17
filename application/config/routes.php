<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 * @param $group_ep group name (group endpoint)
 * @param $route_array route array in associative array
 * @return void
 * 
 * Example : 
 * group_route("api/user", [
 *   "get_all" => 'user/get_all',
 *    "get/(:num)" => 'user/get/$1'
 *  ]);
 * 
 */
global $route;
function group_route($group_ep, $route_array)
{
    global $route;
    foreach ($route_array as $k => $v) {
        $p = !empty($k) ? "/{$k}" : "";
        $route["{$group_ep}{$p}"] = $v;
    }
}

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//  ************************* PUBLIC *******************************
$route['default_controller'] = 'welcome';



//  ************************* PORTAL *******************************

$route['portal'] = 'home/index';

group_route("portal", [
    "login" => 'auth/index',
    "logout" => 'auth/session_logout',

    
    "dashboard" => 'home/index',
    "category" => 'category/index',
    "blog" => 'blog/index',
    "blog_image" => 'blog_image/index',
]);
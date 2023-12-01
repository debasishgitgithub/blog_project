<?php

function run_on_local_server()
{
  if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1') {
    return true;
  } else {
    return false;
  }
}

if (!function_exists('sidebar_base_url')) {
  function sidebar_base_url($string = '')
  {

    if (run_on_local_server()) {
      // if run on local server
      return base_url($string);
    } else {
      // if run on local live server
      if(!empty($string)){
        return "https://debasish.co.in/{$string}";
      } else {
        return "https://debasish.co.in/";
      }
    }
  }
}

if(!function_exists('pp')){
  function pp($value = null){
    echo "<pre>";
    print_r($value);
    echo "</pre>";
    exit();
  }
}
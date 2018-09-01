<?php

/*
Plugin Name: Sunday School Plugin
Plugin Uri: https://github.com/alnever/sunday-school-plugin
Description: Add a shortcode to get information from specific posts, created by ContactForms 7 and Flamingo Plugins
Version: 1.0
Author: Alex Neverov
Author URI: http://alneverov.ru

License: GPL2

    Copyright 2018 Alex Neverov

    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License,
    version 2, as published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

*/

namespace SundaySchoolPlugin;

/*
  Autoload function
*/
spl_autoload_register(
  function ($class_name) {
    if ( ! class_exists($class_name, FALSE) && strstr($class_name, __NAMESPACE__) !== FALSE )
    {
      $class_name = str_replace(__NAMESPACE__."\\","",$class_name);
      $class_name = strtolower($class_name);
      $class_name = str_replace("_","-",$class_name);
      $class_name = str_replace("\\","/",$class_name);
      include $class_name . ".php";
    }
  }
);

class Sunday_School_Plugin {
  public function __construct() {
    new Sunday_School();
  }
}

new Sunday_School_Plugin();


?>

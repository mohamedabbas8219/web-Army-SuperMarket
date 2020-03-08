<?php
require 'connection.php';
require 'classes.php';
$obj=new emp();
var_dump($obj->emp_name_privileges($conn, 2));
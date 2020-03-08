<?php

//only fo knowledge
$pages_abbreviations = array('revoke_all' => 'no', 'provide_all' => 'all', 'add_products' => 'st_p', 'add_emps' => 'st_e', 'privileges' => 'st_privs'
    , 'selling' => 'sell', 'bills' => 'bill', 'inventory_pages' => 'i_vx', 'inventory_day' => 'i_d', 'inventory_month' => 'i_m',
    'sold' => 'i_s', 'leak' => 'i_lk', 'increment' => 'i_inc');
//for work
$abbrev_nums = array('no' => '0', 'all' => '1', 'st_p' => '2', 'st_e' => '3', 'st_privs' => '4', 'sell' => '5', 'bill' => '6', 'i_vx' => '7',
    'i_d' => '8', 'i_m' => '9', 'i_inc' => '10', 'i_lk' => '11', 'i_so' => '12');
$income_abbrev = $_SESSION['page_abbrev'];
$found= array_key_exists("$income_abbrev", $abbrev_nums);
$page_prev = 0;
if($found){
    $page_prev = $abbrev_nums["$income_abbrev"];    // >> st_p   =  2
}
$inv_group = array(7, 8, 9, 10, 11, 12);
$user = $_SESSION["username"];
$pass = $_SESSION['password'];
$user_id = user_id($conn, $user, $pass);
//$perioritiy = periorities($conn, $user_id);
$perioritiy = periorities2($conn, $user_id, $page_prev, $inv_group);
if ($perioritiy) {
    
} else {
    //echo 'not found';
    $redirectURL = "opps.php";
    header("Location:" . $redirectURL);
}

<?php

$a = array(1, 2, 2, 3, 3, 2, 4);
$ch = array_search(4, $a);
if ($ch && $ch == 6) {
    echo "found at 6 ";
}
if ($ch && $ch == 5) {
    echo "not found at 5 ";
}
require 'connection.php';
require 'classes.php';
$prods_data = prod_data_to_arr2(get_products($conn));
$all_prods_ass_arr = array();
$all_ids = array();
echo 'Name  &  q   &   r<br />';
for ($i = 0; $i < count($prods_data); $i++) {
    //  echo '<br />'.$prods_data[$i][1].' >> '.$prods_data[$i][3].' & '.$prods_data[$i][7];
}

echo dayName($conn, get_date($conn));
echo '<br />';
$c = (get_month_products($conn, '1-4-2019')[1][1]);
if (!$c) {
    echo '==null';
} else {
    echo"!=null";
}
echo '<br /><br />';
//var_dump(get_leaks($conn,'2019-04-01')[0]);

$d = get_date($conn);
$month = month($conn, $d) + 1;
$datel = "2019-$month-01";
//echo "date : $datel";
//var_dump(get_bills($conn)[1]);
foreach (get_bills($conn)[1][0] as $key => $value) {
    //  echo $value[1]." & ".$value[5]."<br />";
}

var_dump(get_bills($conn)[0]);
//$all_customers= customers($conn);


$valuei = 1;
$upd_remain_q = "UPDATE products SET quantity=quantity+$valuei, remaining_quantity=remaining_quantity+$valuei WHERE id=1";
//echo "updated";
$conn->query($upd_remain_q);


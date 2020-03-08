<?php
require 'connection.php';
require 'classes.php';
$msg='';
//$products_data_arr=prod_data_to_arr(get_products($conn));
$products_data_fetsh=get_products($conn);
$products_data_arr=prod_data_to_arr($products_data_fetsh);
var_dump($products_data_arr);
echo 'count: '.count($products_data_arr).'<br />';
//echo 'ids: ';
echo '<script>
        function m(){
        var products=[]; 
        ';
foreach ($products_data_arr as $i => $row) {
    echo 'var products2=[];';
    foreach ($row as $j => $v) {
        // echo 'var products2=[0];';
        echo ' products2[' . $j . ']="' . $v . '";';  //id
    }
     echo " products2[10]='<br />';";
    echo " products[products2[0]]=products2;";  //id
    //echo " products[$i]=products2;";  //id
}
echo "document.getElementById('b').innerHTML=products;";
echo "
             return products;
              }
              function ma(){
               var s=m();
              document.getElementById('b').innerHTML=s+'<br />';
              }
            </script> ";
?>
<html>
    <head></head>
    <body onpageshow="m()">
        <p id='b'>thank GOD</p>
    </body>
</html>









<?php
session_start();
require 'connection.php';
require 'classes.php';
$_SESSION['page_abbrev'] = 'st_p';
require 'check_sess_user.php';

$products_data_arr = array();
$id = $name = $pic = $quantity = $price = $prod_date = $exp_date = $remaining = $type = $disc = $title = '';
$edit = 1;
$product_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (isset($_POST['save'])) {
    $new_quantity =$_POST['new_quantity'];
    if ($new_quantity == '') {
        echo "<center> <p id='p' style='color: green; font-size: 22px; width:98%;text-align:center;'> !!  عفوا, لم يتم ادخال الكمية </p></center>";
    } else {
        $insert = "update products set quantity=quantity+$new_quantity,remaining_quantity=remaining_quantity+$new_quantity where id=$product_id";
        //,image='$image'
        if ($conn->query($insert)) {
            echo "<center> <p id='p' style='color: green; font-size: 22px; width:98%;text-align:center;'>تم الحفظ بنجاح</p></center>";
        } else {
            echo "<center> <p id='p' style='color: green; font-size: 22px; width:98%;text-align:center;'>عفوا لم يتم الحفظ , يحتمل وجود خطا او تكرار بالبيانات  !!</p></center>";
            // echo 'عفوا لم يتم الحفظ , يحتمل وجود خطا او تكرار بالبيانات  !!' ; 
        }
    }
}
$curr_date = get_date($conn);
//echo $curr_date; 

$all_products_arr = prod_data_to_arr(get_products($conn));
$products_names = array();
for ($i = 0; $i < count($all_products_arr); $i++) {
    $id_cc = $all_products_arr[$i][0];
    $products_names[$id_cc] = $all_products_arr[$i][1];
}
if ($edit == 1) {
    $title = "تعديل المنتج";
    $products_data_arr = prod_data_to_arr(get_products_edit($conn, $product_id));
    $curr_p = $products_data_arr[0];
    $id = $product_id;
    $name = $curr_p[1];
    $quantity = $curr_p[2];
    $price = $curr_p[3];
    $prod_date = $curr_p[4];
    $exp_date = $curr_p[5];
    $remaining = $curr_p[7];
    $type = $curr_p[9];
    $pic = $curr_p[8];
    $disc = $curr_p[10];
} else {
    $title = "إضافة منتج جديد";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <script src="scripts/functions.js" type="text/javascript"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="css/jquery.min.js" type="text/javascript"></script>
        <script src="css/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <style>
            *{
                background-image: url('images/sky.jpg');
                background-size: cover;
            }
            .img{}
        </style>
        <script>
            $(document).ready(function () {
                $('[data-toggle="popover"]').popover();
            });

        </script>
    </head>
    <body>

    <center> <h1 class="text-center"><?php echo $title; ?></h1>
        <form class="login" style="width: 60%;" method="post" enctype="multipart/form-data">
         
            <input class="form-control input-lg" type="text" <?php if ($edit) {
                echo "value='$name'";
            } ?>  name="prod_name" placeholder="إسم المنتج" required=""  disabled=""
                   autofocus="" onchange="document.getElementById('p').style.display = 'none'" autocomplete="on" data-toggle='popover' data-trigger='hover' data-content='إسم المنتج'/>
            
            <input class="form-control input-lg" type="text" <?php
            if ($edit) {
            echo "value='كمية المنتج الموجودة حاليا   = $quantity'";} ?> name="quantity" id="quantity" disabled=""
                   placeholder="الكمية" required="" autocomplete="off" onchange="p_quantity()" min="0"
                   data-toggle='popover' data-trigger='hover' data-content='كمية المنتج'/>
             
           
             <input class="form-control input-lg" type="number"  name="new_quantity" id="quantity"
                   placeholder="الكمية" required="" autocomplete="off" onchange="p_quantity()" min="0"
                   data-toggle='popover' data-trigger='hover' data-content='الكمية المضافة'/>
            
            
            
            
            <input class="btn btn-primary btn-block input-lg" value="حفظ الصورة" 
                   style="margin-top: 5px; font-size: 22px; " type="submit" name="save" />

        </form>        
    </center>


    <button id='h4' style="position: fixed; top: 1px; right:2px;"
            onclick="window.open('add_products_form.php?action=fill&edit=1&id=<?php echo $id; ?>', '_self')"> 
        <a style='color:#293f5a; font-size: 20px; font-weight: bold;'
           href="add_products_form.php?action=fill&edit=1&id=<?php echo $id; ?>">عودة لتعديل للمنتج </a> 
    </button>

</body>
</html>
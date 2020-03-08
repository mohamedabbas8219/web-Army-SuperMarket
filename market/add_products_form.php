<?php
session_start();
require 'connection.php';
require 'classes.php';
$_SESSION['page_abbrev']='st_p';
require 'check_sess_user.php';


$products_data_arr = array();
$id = $name = $pic = $quantity = $price = $prod_date = $exp_date = $remaining = $type = $disc = $title = '';
$edit = filter_input(INPUT_GET, 'edit', FILTER_SANITIZE_NUMBER_INT);
$product_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
//echo "<h1>$edit</h1>";
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
    $disc = $curr_p[10]*100;
} else {
    $title = "إضافة منتج جديد";
}

//print_r($products_data_arr);
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
        </style>
        <script>
            $(document).ready(function () {
                $('[data-toggle="popover"]').popover();
            });

        </script>
    </head>
    <body>
        <?php
        if (isset($_POST['save'])) {
            $check_found_name = 1;
            $name = $_POST['prod_name'];
            $srch = array_search($name, $products_names);
            if ($srch) {
                if ($edit == 1 && $srch == $product_id) {
                    $check_found_name = 0;
                }
            } else {
                $check_found_name = 0;
            }

            if ($edit == 0) {
                $id = next_id($conn);
            } else {
                $id = $product_id;
            }
            //var_dump($id);

            if (!$check_found_name) {
                $typee = $_POST['prod_type'];
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];
                settype($price, 'double');
                //if(!is_double($price)){$price=0;}
                $prod_date = $_POST['prod_date'];
                $exp_date = $_POST['exp_date'];
                $remaining = $_POST['remaining'];
                // $validity=$_POST['validity'];
                 $image="";
                 if(!$edit){
                 if ($_FILES['pic']['tmp_name'] != '' && getimagesize($_FILES['pic']['tmp_name']) != FALSE) {
                  $image = base64_encode(file_get_contents(addslashes($_FILES['pic']['tmp_name'])));
                 }
                 }
                $disc = $_POST['disc'] / 100;
                //$pic=$_POST['pic'];
                
                    $insert = '';
                    if ($edit == 1) {
                        $insert = "update products set product='$name',quantity=$quantity,price=$price,
            prod_date='$prod_date',expiry_date='$exp_date',validity=datediff(expiry_date,'$curr_date'),
                remaining_quantity=$remaining,ptype='$typee',discount=$disc where id=$product_id";
                    }//,image='$image'
                    else if(!$edit&&$image) {
                        $insert = "insert into products (id,product,quantity,price,prod_date,expiry_date,validity,remaining_quantity,image,ptype,discount)
                      values($id,'$name',$quantity,$price,'$prod_date','$exp_date',datediff(expiry_date,'$curr_date'),$remaining,'$image','$typee',$disc)";
                        //echo "id=$id";
                        // echo $curr_date;
                    }
                    if ($conn->query($insert)) {
                        echo "<center> <p id='p' style='color: green; font-size: 22px; width:98%;text-align:center;'>تم الحفظ بنجاح</p></center>";
                        if (!is_double($price)) {
                            echo "<center> <p style='color: brown;'>ولكن تم ادخال سعر خاطيء فاصبح السعر = 0</p></center>";
                        }
                        //$_FILES['pic']['tmp_name']=NULL;
                    } else {
                        echo "<center> <p id='p' style='color: green; font-size: 22px; width:98%;text-align:center;'>عفوا لم يتم الحفظ , يحتمل وجود خطا او تكرار بالبيانات  !!</p></center>";
                        // echo 'عفوا لم يتم الحفظ , يحتمل وجود خطا او تكرار بالبيانات  !!' ; 
                    }
               
            } else {
                echo "<center> <p id='p' style='color: brown; font-size: 22px; width:98%;text-align:center;'>هذا المنتج موجود مسبقاً . يمكنك التعديل عليه</p></center>";
            }
        }
        ?>
    <center> <h1 class="text-center"><?php echo $title; ?></h1>
        <form class="login" style="width: 60%;" method="post" enctype="multipart/form-data">
            <input class="form-control input-lg" type="text" <?php
            if ($edit) {
                echo "value='$name'";
            }
            ?> name="prod_name" placeholder="إسم المنتج" required="" 
                   autofocus="" onchange="document.getElementById('p').style.display = 'none'" autocomplete="on" data-toggle='popover' data-trigger='hover' data-content='إسم المنتج'/>
            <input class="form-control input-lg" type="text" <?php
            if ($edit) {
                echo "value='$type'";
            }
            ?>  name="prod_type"
                   placeholder="النوع" required="" autocomplete="on" data-toggle='popover'
                   data-trigger='hover' data-content='نوع المنتج'/>
            <input class="form-control input-lg" type="number" <?php
            if ($edit) {
                echo "value='$quantity'";
            }
            ?>  name="quantity" id="quantity" 
                   placeholder="الكمية" required="" autocomplete="off" onchange="p_quantity()" min="0"
                   data-toggle='popover' data-trigger='hover' data-content='كمية المنتج'/>
            <input class="form-control input-lg" type="number" <?php
            if ($edit) {
                echo "value='$remaining'";
            }
            ?> 
                   name="remaining" id="remaining" 
                   id="remaining" placeholder="الكمية الفعلية الموجودة بالمخزن" autocomplete="off"  min="0"
                   data-toggle='popover' data-trigger='hover' data-content='الكمية الفعلية الموجودة بالمخزن'/>

            <input class="form-control input-lg" type="text" <?php
            if ($edit) {
                echo "value='$price'";
            }
            ?>   name="price"
                   placeholder="السعر" required="" autocomplete="off"  min="0"
                   data-toggle='popover' data-trigger='hover' data-content='سعر المنتج'/>
            <input class="form-control input-lg" type="date" <?php
            if ($edit) {
                echo "value='$prod_date'";
            } else {
                echo "value='$curr_date'";
            }
            ?>  name="prod_date"
                   id="prod_date" required="" placeholder="تاريخ الانتاج" autocomplete="on"
                   data-toggle='popover' data-trigger='hover' data-content='تاريخ الانتاج'/>

            <input class="form-control input-lg" type="date" <?php
            if ($edit) {
                echo "value='$exp_date'";
            } else {
                $tr = add_date($conn, $curr_date, 50);
                echo "value='$tr'";
            }
            ?>  name="exp_date"  
                   id="exp_date" onchange="" placeholder="تاريخ الانتهاء" autocomplete="on"
                   data-toggle='popover' data-trigger='hover' data-content='تاريخ الانتهاء'/>

            <input class="form-control input-lg" onchange="disc2()" type="number" <?php
            if ($edit) {
                echo "value='$disc'";
            }
            ?>  name="disc" id="disc" value="0" 
                   placeholder="نسبة الخصم المئوي " autocomplete="off" max="99"  min="0"
                   data-toggle='popover' data-trigger='hover' data-content='نسبةالخصم المئوي % '/>
            <input class="form-control input-lg" type="file"  name="pic" <?php
            if ($edit) { echo 'disabled=""';}  ?>  placeholder="الصورة" autocomplete="off"
                   data-toggle='popover' data-trigger='hover' data-content='اختر صورة المنتج'/>

            <input class="btn btn-primary btn-block input-lg" value="حفظ المنتج" 
                   style="margin-top: 5px; font-size: 22px;" type="submit" name="save" />  
        </form>        
    </center>
    <button id='h4' style="position: fixed; top: 1px; left:2px; display: none;"
            onclick="window.open('add_new_products.php', '_self')"> 
        <a style='color:#293f5a; font-size: 20px; font-weight: bold;' href="add_new_products.php">عودة للمنتجات </a> 
    </button>
    <button id='h4' style="position: fixed; top: 1px; right:2px;" 
            onclick="window.open('add_products_form.php?action=fill&edit=0', '_self')"> 
        <a style='color:#293f5a; font-size: 20px; font-weight: bold;'
           href="add_products_form.php?action=fill&edit=0">اضافة منتج جديد +</a> 
    </button>

    <button id='h4' style="position: fixed; top: 40px; right:2px; <?php
    if (!$edit) {
        echo "display:none;";
    }
    ?>" 
            onclick="window.open('modify_prod_img.php?action=fill&edit=1&id=<?php echo $id; ?>', '_self')"> 
        <a style='color:#293f5a; font-size: 20px; font-weight: bold;'
           href="modify_prod_img.php?action=fill&edit=1&id=<?php echo $id; ?>">تغير صورة المنتج .</a> 
    </button>

    <button id='h4' style="position: fixed; top: 80px; right:2px; <?php
    if (!$edit) {
        echo "display:none;";
    }
    ?>" 
            onclick="window.open('modify_prod_quantity.php?action=fill&edit=1&id=<?php echo $id; ?>', '_self')"> 
        <a style='color:#293f5a; font-size: 20px; font-weight: bold;'
           href="modify_prod_quantity.php?action=fill&edit=1&id=<?php echo $id; ?>"> إضافة كمية جديدة+ </a> 
    </button>
</body>
</html>
<?php
//}
//else{
//    $redirectURL = "market_login_page.php";
//             header("Location:" . $redirectURL);
//}









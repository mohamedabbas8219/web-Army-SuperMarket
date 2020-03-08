<?php
require 'connection.php';
require 'classes.php';
//require 'showdata.php';
session_start();
$user = $_SESSION["username"];
$pass = $_SESSION['password'];
$user_id = 0;
if ($_SESSION["username"] && $_SESSION["password"] && check_user($conn, $user, $pass)) {
    $user_id = user_id($conn, $user, $pass);
    $dd = get_date($conn);
    $show_tb = 'm';
    ?>
    <html>
        <head>
            <title>نادي ض ق م برأس البر </title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <style>   /*fatora*/    
                table{ border-radius:4px; width:99%; border:1px solid silver;}
                table tr td{text-align:center; background-color: whitesmoke; color: black; font-weight: bold;
                            border:1px solid black;}
                table tr th{text-align:center; background-color: #DDDDDD; color: black; font-weight: bold;
                            border:2px solid black;}
                table tr td img{width:100%; border-radius:40%;}

                #all_products tr th{
                    background-color: #293f5a; color: white; font-size: 20px;}


            </style>

        </head>
        <!-- ####################################################################################################### -->
        <body id="body" dir="rtl" onpageshow="disp_selec_tbl(),show_msg()" onpagehide="alert('m')">
        <center>

            <?php
            $show_tbl = 'm';
            $inv_type = '';
            $products_global_fetsh2 = get_global_products($conn);
            if (isset($_POST['show_inv'])) {
                $inv_type = $_POST['inv_type'];
                $date = $_POST['ddate'];
                $dd = $date;
                if ($inv_type == 'm') {
                    $show_tbl = 'm';
                } else {
                    $show_tbl = 'd';
                }
                //real_value$i
                for ($i = 0; $i < count($products_global_fetsh2[0]); $i++) {
                    $cid = $products_global_fetsh2[0][$i];

                    if (isset($_POST["real_value$i"]) && $_POST["real_value$i"] != '') {
                        $cq = $_POST["real_value$i"];
                        update_real_quantity_inv($conn, $cid, $cq);
                    }
                }
            }

            $dd = date("jF, Y");
            $dd_m = date("F, Y");
            ?>
            <form method="post" action="" enctype="multipart/form-data" > 

                <!-- ############################################################################## -->   
                <div style=" position:fixed; top: -1px;width: 100%;height: 28px;">
                    <table style='direction:rtl;text-align: center;border-top-width: 4px; width: 100%; ' id="ffatora">
                        <tr>
                            <th colspan="3"><?php if ($show_tbl == 'm') {
                echo'جرد الماركت ';
            } else {
                echo'يومية الماركت ';
            } ?></th>
                        </tr>
                        <tr>
                            <th style="width:25%;">نوع الجرد</th><th style="width:25%;">شهر</th>  <th style="">تاريخ</th>
                        </tr>
                        <tr class='data' style='text-align: center;'>
                            <td style='text-align: center;'>
                                <select name="inv_type" id="inv_type" style='width: 95%; text-align: center; font-size: 18px;' >
                                    <option <?php if ($show_tbl == 'd') {
                echo "selected=''";
            } ?> value="d" >يومي</option>
                                    <option <?php if ($show_tbl == 'm') {
                echo "selected=''";
            } ?> value="m" >شهري  / عام</option>

                                </select>      
                            </td>
                            <td><b style="width: 55%; text-align: center; width: 99%; font-weight: bold;
                                   font-size: 18px;" > <?php echo $dd_m; ?></b>
                            </td>
                            <td><b style="width: 55%; text-align: center; width: 99%; font-weight: bold;
                                   font-size: 18px;" > <?php echo $dd; ?></b>
                            </td>
                        </tr>
                    </table>
                </div> 
                <div id="content" class="content" style="text-align: center; width: 100%; ">

                    <?php
                    $assoc_products_arr = assoc_arr_id(prod_data_to_arr(get_products($conn)));

                    $products_day_fetsh = get_day_products($conn, $dd);
                    $sshow_data = array();
                    $all_ids = array();
                    $products_global_fetsh = get_global_products($conn);
                    $products_data_fetsh = get_products($conn);
                    $products_data_arr = prod_data_to_arr($products_data_fetsh);
                    for ($i = 0; $i < count($products_data_arr); $i++) {
                        $img = $products_data_arr[$i][8];
                        $curr_prod = $products_data_arr[$i];
                        $id_p = $curr_prod[0];
                        $all_ids[$i] = $id_p;

                        $sshow_data[$id_p] = array($curr_prod[2], $curr_prod[7], 0);
                        $upd_remain_q = "UPDATE products SET remaining_quantity=quantity WHERE               id=$id_p";
                        // if($conn->query($upd_remain_q)){echo" done11 $id_p<br />";}
                    }
                    ?>

                    <center>
                            <?php $id = 2; ?>
                        <!--<form method='post'>          -->
                        <table  id="all_products" style="  width: 100%; margin-top: 99px; text-align: center; ">
                            <?php
                            echo th($show_tbl);
                            $day_name = 'الشهر';
                            $show_tbl = 'm';
                            $total_pricess = 0;
                            $total_leak_pricess = 0;
                            if ($show_tbl == 'm') {
                                $curr_prod = $products_global_fetsh;
                                $day_name = ' الشهر';
                            } else {
                                $curr_prod = $products_day_fetsh;
                            }

                            if (count($curr_prod[0]) > 0) {  //for repeat to check height
                                for ($i = 0; $i < count($curr_prod[0]); $i++) {
                                    $id_p = $curr_prod[0][$i];
                                    $quantity = $curr_prod[1][$i];
                                    $upd_remain_q = "UPDATE products SET remaining_quantity=quantity-$quantity WHERE id=$id_p";
//   if($conn->query($upd_remain_q)){echo" done22 $id_p<br />";}



                                    $sshow_data[$id_p][2] = $quantity;
                                }
                            }



                            if (count($all_ids) > 0) {  //for repeat to check height
                                for ($i = 0; $i < count($all_ids); $i++) {

                                    $id_p = $all_ids[$i];
                                    $full_quantity = $sshow_data[$id_p][0];
                                    $remain_quantity = $sshow_data[$id_p][1];
                                    $quantity = $sshow_data[$id_p][2];
                                    $name = $assoc_products_arr["$id_p"]['name'];
                                    $img = $assoc_products_arr["$id_p"]['image'];
                                    $full_quantity = $assoc_products_arr["$id_p"]['quantity'];
                                    // $remain_quantity = $assoc_products_arr["$id_p"]['remain'];
                                    $discc = $assoc_products_arr["$id_p"]['discount'];
                                    $price = $assoc_products_arr["$id_p"]['price'];
                                    $leak = $quantity - ($full_quantity - $remain_quantity);
                                    $total_leak_pricess += ($leak * $price);
                                    $totl_price = $price * $quantity - ($price * $quantity * $discc);
                                    $total_pricess += $totl_price;

                                    if ($i % 2 != 0) {
                                        ?>
                                        <tr class="odd" style='background-color: #f2f2f2;'
                                            onmouseover="overtr(this)" onmouseout="outtr(this, 1)">
            <?php } else {
                ?>
                                        <tr class="even" style="background-color: #293f5a;"
                                            onmouseover="overtr(this)" onmouseout="outtr(this, 0)" >
            <?php }
            ?>
                                        <td style='width:8%;'>
                                    <center><b class="mtd" name='<?php echo "product_id$i" ?>'><?php echo ($i + 1); ?></b></center>
                                    </td>
                                    <td style='font-weight:bold; width:15%;'>
                                        <b class="mtd" id='h1' style='color:black;' name='<?php echo "product_name$i"; ?>' 
                                           data-toggle='popover' data-trigger='hover' data-content='المنتج' ><?php echo $name; ?></b>
                                    </td>

            <?php if ($show_tbl == 'd') { ?>

                                        <td style="width: 10%; "><center>
                                            <b class="mtd" id="h1" style='color:black;' name="<?php echo "quantity$i"; ?>"
                                               data-toggle='popover' data-trigger='hover' data-content='الكمية المباعة خلال اليوم'/>
                <?php echo "$quantity"; ?></b>
                                            </td> 
                                            <td style="width: 10%; "><center>
                                                <b class="mtd" id="h1" style='color:black;' name="<?php echo "price$i"; ?>"
                                                   data-toggle='popover' data-trigger='hover' data-content='سعر الوحدة'/>
                                                    <?php echo "$price"; ?></b>
                                                </td> 
                                                <td style="width: 15%; "><center>
                                                    <b class="mtd" id="h1" style='color:black;' name="<?php echo "total_price$i"; ?>"
                                                       data-toggle='popover' data-trigger='hover' data-content='اجمالي سعر المنتج'/>
                <?php echo "$totl_price"; ?></b>
                                                    </td> 

                <?php
            } else {
                ?>
                                                    <td style="width: 10%; "><center>
                                                        <b class="mtd" id="h1" style='color:black;' name="<?php echo "full_quantity$i"; ?>"
                                                           data-toggle='popover' data-trigger='hover' data-content='كمية الوارد'/>
                <?php echo "$full_quantity"; ?></b>
                                                        </td>
                                                        <td style="width: 10%; "><center>
                                                            <b class="mtd" id="h1" style='color:black;' name="<?php echo "quantity$i"; ?>"
                                                               data-toggle='popover' data-trigger='hover' data-content='الكمية المباعة خلال الشهر'/>
                <?php echo "$quantity"; ?></b>
                                                            </td> 
                                                            <td style="width: 10%; "><center>
                                                                <b class="mtd" id="h1" style='color:black;' name="<?php echo "remain$i"; ?>"
                                                                   data-toggle='popover' data-trigger='hover' data-content='الكمية المتبقية'/>
                <?php echo "$remain_quantity"; ?></b>
                                                                <td style="width: 10%; text-align: center; "><center>
                                                                    <input type="number" min="0" style='color:black; width: 70%; text-align: center; font-size: 19px; z-index:-2;'
                                                                           name="<?php echo "real_value$i"; ?>" value="<?php echo $remain_quantity; ?>"
                                                                           data-toggle='popover' data-trigger='hover' data-content='الكمية الفعلية'/>
                                                                    </td>  
                                                                    <td style="width: 10%;"><center>
                                                                        <b class="mtd" id="h1" style='color:black;' name="<?php echo "leak$i"; ?>"
                                                                           data-toggle='popover' data-trigger='hover' data-content='عجز / ذيادة'/>
                                                                        <?php echo "$leak"; ?></b>
                                                                        </td>  




                                                                    <?php } ?>
                                                                    </tr>
            <?php }
        if ($show_tbl == 'm') {
            ?> 
                                                                    <tr>
                                                                        <th colspan="8" style="text-align:center; background-color: #DDDDDD; color: #293f5a; font-weight: bold;
                                                                            border:2px solid black;">
                                                                            <b>  قيمة العجز/ الزيادة : <?php echo ' ( ' . $total_leak_pricess . ' ) '; ?>  جنيهاً .</b></th>
                                                                    </tr>

        <?php
        }
    } else {
        ?>

                                                                <tr class="odd" style='background-color: #f2f2f2; text-align: center; font-size: 20px;font-weight: bold;'
                                                                    onmouseover="overtr(this)" onmouseout="outtr(this, 1)">
                                                                    <td colspan="7">لا يوجد مبيعات هذا  <?php echo $day_name; ?></td>
                                                                </tr>
    <?php } ?>
                                                            </table>
                                                            <!-- </form> -->
                                                        </center>
                                                        </div>
                                                        </form>
                                                    </center>
                                                  </body>
                                                    </html>

                                                    <?php
                                                } else {
                                                    $redirectURL = "market_login_page.php";
                                                    header("Location:" . $redirectURL);
                                                }

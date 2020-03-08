<?php
session_start();
$_SESSION['curr_page']='add_new_products_h.php';
require 'connection.php';
require 'classes.php';
$_SESSION['page_abbrev']='bill';
require 'check_sess_user.php';
?>
<html>
    <head>
        <title>نادي ض ق م برأس البر </title>
        <meta charset="UTF-8">
        <script src="scripts/searchpg.js" type="text/javascript"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="scripts/functions.js" type="text/javascript"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="css/layoutHome.css" rel="stylesheet" type="text/css"/>
        <script src="scripts/jquery-1.11.3.min.js" type="text/javascript"></script> 
        <!--                scroll         -->  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>
            function save_first() {
                document.getElementById("btn1").style.display = 'none';
                document.getElementById("print").style.display = 'none';
            }
            function resett() {
                document.getElementById("btn1").style.display = '';
                document.getElementById("print").style.display = '';
            }
        </script>

        <style>
            div.scrollmenu {
                overflow: auto;
                white-space: nowrap;
            }

            div.scrollmenu a {
                display: inline-block;
                text-align: center;
                padding: 14px;
                text-decoration: none;
            }

            div.scrollmenu a:hover {
            }
        </style>
        <!--               end scroll         -->  
        <style>
            #arrays_to_js{display: none;}
        </style>
        <style>   /*fatora*/    
            table{ border-radius:4px; width:99%; border:1px solid silver;}
            table tr td{text-align:center; background-color: whitesmoke; color: black; font-weight: bold;
                        border:1px solid black;}
            table tr th{text-align:center; background-color: #DDDDDD; color: black; font-weight: bold;
                        border:2px solid black;}
            table tr td img{width:100%; border-radius:40%;}
            img{ border-radius:40%;}
            .title{text-align:center;
                   width:99%;color: #55000D; font-size:20px;border-radius:10px; border:1px solid #2f002f;}

            fieldset{margin-bottom:12px; width:99%;  color:white; border-radius:2px; border-width: 1px; border-top-width: 4px;}
            #fatora{ width:98%; background-color:#cac7c7; border-radius: 5px;}
            #fatora_outer_div{  background-color:#e0dee6; border-radius: 5px; }

            .control{background-color:silver;font-size:33px;}
            .btn{background-color:#1B8B3d;font-size:20px; color:white;}
            .data{color:white;font-size:18px;}
            #all_products{height: 30px; width: 100%; border: 3px #190f4a solid; border-top-width:6px;  border-bottom-width: 5px;}
            #all_products tr td {width:16px;height:20px; border: none; }
            #cell_tbl tr td {width:16px;height:20px; background-color: #fafafa; border-style: none; }
            #cell_tbl tr td img {height:101%;}

            .tdsimg{border-radius: 50px; width: 100%; height: 80%;}
            #hidden_tbl_for_ids{width: 100%; height: auto; background-color:#fafafa; margin-top: 22px; display: none;}
            #hidden_tbl_for_ids tr td{width: 10%; color:blue; font-size: 22px;}
            #x{width:10%; margin-right:0px; background-color: brown; border-radius: 3px; color: whitesmoke; }
            .odd td{background-color: silver;}
            .mtd:hover{color: white;}

            #all_products2 tr th{
                background-color: #293f5a; color: white; font-size: 20px;}

            .data{
                color: #080326;
                font-size: 20px; font-weight:bold;
            }
        </style>

    </head>
    <!-- ####################################################################################################### -->
    <body id="body" dir="rtl" onpageshow="disp_selec_tbl(),show_msg()" onpagehide="alert('m')">
    <center>

        <?php
        $show_tbl = 'm';
        $inv_type = '';
        $dd = get_date($conn);
        $real_date = $dd;
        $curr_month = month($conn, $dd);
        //$products_global_fetsh2= prod_data_to_arr2(get_products($conn));

        $assoc_products_arr2 = assoc_arr_id(prod_data_to_arr(get_products($conn)));

        $bills_data2 = get_bills($conn);
        $bills_dates2 = get_bills($conn)[0];
        // $products_day_fetsh= get_day_products($conn,$dd);
        //$all_customers= customers($conn);
       //$rres="xxx";
        for ($i = 0; $i < count($bills_dates2); $i++) {
            $bill_number = $bills_dates2[$i];
            if (isset($_POST["cancel_bill$i"])) {
                $curr_month = $_POST['curr_date'];
                for ($j = 0; $j < count($bills_data2[1][$i]); $j++) {
                    $prod_id = $bills_data2[1][$i][$j][2];
                    $quantity = $bills_data2[1][$i][$j][3];
                    if (del_prod_orders($conn, $bill_number, $prod_id)) {
                        update_remaining($conn, $prod_id, $quantity);
                       // $rres="done : prod_id : $prod_id & bill : $bill_number";
                    }
                }
            }

            for ($j = 0; $j < count($bills_data2[1][$i]); $j++) {
                $prod_id2 = $bills_data2[1][$i][$j][2];
                $quantity2 = $bills_data2[1][$i][$j][3];
                if (isset($_POST["cancel_prod$j"])) {
                    $curr_month = $_POST['curr_date'];
                    if (del_prod_orders($conn, $bill_number, $prod_id2)) {
                        update_remaining($conn,$prod_id2,$quantity2);
                    }
                }
            }
        }
        if (isset($_POST['show_month_bills'])) {
            // $inv_type=$_POST['inv_type'];
            $inv_type = 'm';
            $date = $_POST['ddate'];
            $dd = $date;
            $curr_month = month($conn, $date);
            if ($inv_type == 'm') {
                $show_tbl = 'm';
            } else {
                $show_tbl = 'd';
            }
        }
        if (isset($_POST['show_all_bills'])) {
            $curr_month = 0;
            if ($inv_type == 'm') {
                $show_tbl = 'm';
            } else {
                $show_tbl = 'd';
            }
        }

        $prods_data = prod_data_to_arr2(get_products($conn));
        $all_prods_ass_arr = array();
        $all_ids = array();
        for ($i = 0; $i < count($prods_data); $i++) {
            $all_ids[$i] = $prods_data[$i][0];
            $all_prods_ass_arr[$prods_data[$i][0]] = array($prods_data[$i][2], $prods_data[$i][7], 0);
        }
        ?>

        <div class="wrapper col1" id="home" style="position: fixed;  top: 0px; z-index:2;background-color: #293f5a; ">

            <center><h1 style="color: white; font-size: 24px;">ماركت نادي ضباط القوات المسلحة برأس البر</h1></center><br />
            <!-- ############################################# -->
            <div class="wrapper col2"   >
                <div id="topnav" style="width:98%; background-color:whitesmoke; border-bottom-color:#293f5a;" >
                    <form name="searchform">
                        <center>
                            <!-- style="border:5px black solid; height:1px; -->
                            <ul class="uris" >  
                                <li>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>  
                                <li > <a href="settings_h.php" style="font-size: 1.2em;">
                                        <b >الإعدادات و الإضافة</b></a> </li>
                                <?php //#dad9ff    ?>
                                <li><a href="selling.php" style="font-size: 1.4em; ">
                                        <b>صفحة البيع</b></a></li>
                                <li><a href="" style="font-size: 1.8em; color:white; background-color: #293f5a; 
                                       padding:5px 5px 9px 5px; text-shadow: 5px 2px 5px gray;"><b>عرض الفواتير</b></a></li>
                                <li><a href="inventory_day_h.php" style="font-size: 1.2em;"> <b>صفحة الجرد</b></a> </li>
                                <li><a href="" style="font-size: 1.2em;"> <b>استعلامات</b></a> </li> 
                                <!-- <li><a href="#" ><b style="font-size: 1.5em;">Search Here</b> </a></li> -->
                                <li>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li> 
                                <li><input type="text" maxlength="55" id="myInput" autocomplete="none" autofocus=""
                                           disabled=""  onkeyup="myFunction()" placeholder=""
                                           title="Type in a name" style="font-size: 1.2em; direction: rtl; 
                                           border: 0px; margin-bottom: 12px; height:24px; width:180%;" > 
                                </li>
                            </ul>

                        </center>   
                    </form>
                </div>
            </div>
        </div> 
        <a href="bridge_to_login.php"
           style="color: white; z-index: 3; font-size: 18px; position: fixed; top: -3px; left: -3px;
           text-decoration: none;"
           onmouseover="this.style.color = '#960000'" onmouseout="this.style.color = '#dddfe2'">
            <b>   تسجيل الخروج   &nbsp;&nbsp;</b></a>




        <form method="post" action="" enctype="multipart/form-data" > 
            <center>
                <fieldset id='fatora' style="text-align: center;border-top-width: 4px; position: fixed; width: 99%;
                          top: 100px; border-radius: 0px; background-color: #e4e5ee; border-bottom-right-radius:8px; border-bottom-left-radius:8px;">
                    <table style='direction:rtl; border:2px #0F4D21 solid;  width: 100%;' id="ffatora">
                        <tr>
                            <th style="width:10%;">عدد الفواتير</th> <th style="width:35%;">تاريخ</th> <th style="width:25%;">الشهر</th> 
                            <td rowspan='2' class='control'  style="border-style: none; border-radius: 10px;">
                        <center>
                            <input type='submit' class='btn' id='btn1' name="show_month_bills" value=' إظهار فواتير الشهر'  />
                            <input type='submit' class='btn' id='btn1' name="show_all_bills" value=' إظهار كل الفواتير '  />
                            <input type="text" name="curr_date" value="<?php echo $curr_month; ?>" style="display: none;" />
                        </center>
                        </td>
                        </tr>
                        <tr class='data' style='text-align: center; '>
                            <td><?php echo count_bills($conn, $curr_month); ?></td>
                            <td><input required="" type="date" value="<?php echo $dd; ?>" name="ddate" placeholder='غير التاريخ' style="width: 55%;
                                       text-align: center; width: 99%; font-weight: bold; font-size: 22px; background-color: silver;" />
                            </td>
                            <td style='text-align: center; ' >
                                <?php echo ' , ' . monthName($conn, $dd); ?>    
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </center>
            <!-- ############################################################################## -->   
            <div id="content" class="content" style="text-align: center; width: 100%; ">

                <?php
                $assoc_products_arr = assoc_arr_id(prod_data_to_arr(get_products($conn)));
                $products_global_fetsh = get_month_products($conn, $dd);
                $bills_data = get_bills($conn);
                $bills_dates = get_bills($conn)[0];
                // $products_day_fetsh= get_day_products($conn,$dd);
                $all_customers = customers($conn);
                ?>
                <center>
                    <div id="fatora_outer_div" style="margin-top:190px; " >
                        <?php
                        for ($i = 0; $i < count($bills_dates); $i++) {
                            $bill_number = $bills_dates[$i];
                            $bill_date = $bills_data[1][$i][0][5];
                            $bill_month = month($conn, $bill_date);
                            if (!$curr_month || $curr_month == $bill_month) {
                                $customer_id = $bills_data[1][$i][0][6];
                                $seller_id = $bills_data[1][$i][0][7];
                                $customer = customer_name($conn, $customer_id);
                                $seller = seller_name($conn, $seller_id);
                                $cash = $bills_data[1][$i][0][8];
                                $notes = $bills_data[1][$i][0][9];
                                $total_pricess = 0;
                                ?>
                                <fieldset id="fatora" >
                                    <table id="all_products" >
                                        <tr>
                                            <th colspan="2">رقم الفاتورة : <b id="data"><?php echo $bill_number; ?></b></th>
                                            <th colspan="3">اليوم : <b id="data" ><?php echo dayName($conn, $bill_date); ?></b></th>
                                            <th colspan="2">التاريخ : <b id="data" ><?php echo $bill_date; ?></b></th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">العميل : <b class="data"><?php echo $customer; ?></b></th>
                                            <th colspan="3">الموظف : <b class="data" ><?php echo $seller; ?></b></th>
                                            <th colspan="2">الدفع : 
                                                <b id="data" > <?php
                                                    if ($cash) {
                                                        echo 'نقدي';
                                                    } else {
                                                        echo 'آجل';
                                                    }
                                                    ?> </b>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="width: 8%;">م</th>
                                            <th style="width: 15%;">الصنف</th>
                                            <th style="width: 10%;">الكمية</th>
                                            <th style="width: 10%;">السعر</th>
                                            <th style="width: 8%;">خصم</th>
                                            <th style="width: 15%;">الاجمالي</th>
                                            <th style=""> 
                                                <?php if ($cash == 1 && (month($conn, $real_date) == month($conn, $bill_date))) { ?>
                                                    <input type="submit" name="<?php echo "cancel_bill$i"; ?>" class='btn'  value='ارجاع الفاتورة' style="background-color: brown;" />
                                                <?php } ?>
                                                <input type="button" class='btn'  name="print" onclick="window.open('print.php?p=<?php echo "$bill_number"; ?>')" id='print' value='طباعة ' />
                                            </th>
                                        </tr>
                                        <?php
                                        for ($j = 0; $j < count($bills_data[1][$i]); $j++) {
                                            $prod_id = $bills_data[1][$i][$j][2];
                                            $prod_name = $assoc_products_arr[$prod_id]['name'];
                                            $quantity = $bills_data[1][$i][$j][3];
                                            $discc = $assoc_products_arr["$prod_id"]['discount'];
                                            $price = $assoc_products_arr["$prod_id"]['price'];
                                            $totl_price = $price * $quantity - ($price * $quantity * $discc);
                                            $total_pricess += $totl_price;
                                            ?>
                                            <tr>
                                                <td style="width: 8%;"><b class="data" ><?php echo ($j + 1); ?></b></td>
                                                <td style="width: 15%;"><b class="data" ><?php echo $prod_name; ?></b></td>
                                                <td style="width: 10%;"><b class="data" ><?php echo $quantity; ?></b></td>
                                                <td style="width: 10%;"><b class="data" ><?php echo $price; ?></b></td>

                                                <td style="width: 10%;"><b class="data" >
                                                        <?php
                                                        $ds = $discc * 100;
                                                        echo "$ds %";
                                                        ?>
                                                    </b></td>
                                                <td style="width: 8%;"><b class="data" ><?php echo $totl_price; ?></b></td>
                                                <td style="">
                                                    <?php if ($cash == 1 && (month($conn, $real_date) == month($conn, $bill_date))) { ?>  
                                                        <input type="submit" name="<?php echo "cancel_prod$j"; ?>" class='btn'  value='ارجاع المنتج' style="background-color: brown;" />  
            <?php } ?>
                                                </td>
                                            </tr>

        <?php }  //end for j    ?>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="2"><b class="data" >الإجمالي</b></td>
                                            <td colspan=""><b class="data" style="color: #0d187a;" ><?php echo "( $total_pricess ) جنيه"; ?></b></td>

                                            <td style="" colspan=""><b class="data" >
                                                    <?php
                                                    if ($notes == '') {
                                                        echo 'مبيعات يومية';
                                                    } else {
                                                        echo $notes;
                                                    }
                                                    ?></b></td>
                                        </tr>
                                    </table>
                                </fieldset>

                                <?php
                            }     // end if(month 
                        } /* end bill_date for */
                        ?>
                    </div>
                </center>
            </div>
        </form>
    </center>

    
</body>
</html>

<?php
if (isset($_POST['save_inv'])) {
    $date = $_POST['ddate'];
    for ($i = 0; $i < count($prods_data); $i++) {
        $cid = $prods_data[$i][0];
        $leak_q = $_POST["leak$i"];
        if ($leak_q != 0) {
            reset_inv_month($conn, $date);
            update_inv_month($conn, $cid, $leak_q, $date, 0);
        }
    }
}

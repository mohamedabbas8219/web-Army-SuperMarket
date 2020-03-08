<!DOCTYPE html>
<html> 
    <?php
    include_once "./classes.php";
    include_once "./connection.php";
    session_start();
    $_SESSION['page_abbrev']='st_p';
     require 'check_sess_user.php';
    ?>
    <head>
        <script src="scripts/searchpg.js" type="text/javascript"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="css/jquery.min.js" type="text/javascript"></script>
        <script src="css/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/forinsert_products.css" rel="stylesheet" type="text/css"/>
        <link href="css/admin_forinsert_products.css" rel="stylesheet" type="text/css"/>
        <title></title>
        <style>
            #all_products {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                direction: rtl;
                border: solid 2px #8aa5ec;  
                border-radius: 40em;
            }
            #all_products td:hover {background-color: #ddd;}
            #all_products td {border: 1px graytext solid; border-radius: 4px;}

            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                direction: rtl;
                border: solid 2px #8aa5ec;  
                border-radius: 40em;
            }
            #table td:hover {background-color: #ddd;}

            .variables_html{display: none;}
        </style>

        <script>
            $(document).ready(function () {
                $('[data-toggle="popover"]').popover();
            });

        </script>
    </head>
    <body onchange="document.getElementById('p').style.display = 'none';"> 
        <div id="variables_html" class="variables_html">
            <div>  
                <?php
                ////////////////////////////////////////////is set 
                $products_data_arr2 = prod_data_to_arr(get_products($conn));
                
                if (isset($_POST['dalete_all_prods'])) {
                    if (delete_all_product($conn)) {
                            echo "<center> <p style='color: green; font-size: 22px; position:fixed;bottom:0px;' id='p' width:98%;text-align:center;'>تم الحذف بنجاح</p></center>";
                        } else {
                            echo "<center> <p style='color: brown; font-size: 22px; position:fixed;bottom:0px;' id='p'  width:98%;text-align:center;'> عفوا, لم يتم الحذف</p></center>";
                        }
                }
                
                if (isset($_POST['add_new'])) {
                    $redirectURL = "add_products_form.php?action=fill&edit=0&id=0";
                    header("Location:" . $redirectURL);
                }
                if (isset($_POST['refresh_v'])) {
                    refresh_validity($conn);
                }
                for ($i = count($products_data_arr2) - 1; $i >= 0; $i--) {
                    if (isset($_POST["delete$i"])) {
                        $idd = $products_data_arr2[$i][0];
                        //$delete_prod_q = "delete from products WHERE id=$idd ";
                        if (delete_product($conn, $idd)) {
                            echo "<center> <p style='color: green; font-size: 22px; position:fixed;bottom:0px;' id='p' width:98%;text-align:center;'>تم الحذف بنجاح</p></center>";
                        } else {
                            echo "<center> <p style='color: brown; font-size: 22px; position:fixed;bottom:0px;' id='p'  width:98%;text-align:center;'> عفوا, لم يتم الحذف</p></center>";
                        }
                    }
                }
                $products_data_arr = prod_data_to_arr(get_products($conn));
                ?>
            </div>
        </div>

    <center>

        <div style=" margin:auto; position: fixed; top:0;  font-family: -apple-system, BlinkMacSystemFont, 
             'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 
             'Segoe UI Symbol';">
            <form method="post">
                <table  style="position: fixed; margin-top: 0px;width:100%; border:2px #008dde solid;"  id="table">
                    <tr style="color: #293f5a; background-color: #ddd; text-align: center;">
                        <td colspan="5">
                            <input type="submit" name="add_new" id="h4" style="width:88%; font-size: 20px; margin-top: 10px;"
                                   value="إضافة منتج جديد++" />
                        </td>
                        <td colspan="5">
                            <input type="text" maxlength="55" id="myInput" autocomplete="none"
                                   onkeyup="myFunction()" placeholder="...إبحث بإسم المنتج او الصنف"
                                   title="Type in a name" style="font-size: 1.2em; direction: rtl; 
                                   margin-bottom: 12px; height:24px; width:90%; margin-top: 10px;" > 
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 5%;"> م </th>
                        <th style="width: 15%;">الصنف</th>
                        <th style="width: 8%;">الصورة</th>
                        <th style="width: 10%;">السعر</th> 
                        <th style="width: 8%;">الكمية</th> 
                        <th style="width: 12%;">ت الانتاج</th> 
                        <th style="width: 9%;"><input type="submit" id="h4" value="الصلاحية" name="refresh_v" /></th> 
                        <th style="width: 5%;">خصم</th> 
                        <th></th> 
                    </tr>
                </table> </form>
        </div>
        <table style="width:100%;margin-top:110px;" dir="rtl"  id="all_products">
            <?php
            $c3 = 0;
            for ($i = count($products_data_arr) - 1; $i >= 0; $i--) {
                $curr_prod = $products_data_arr[$i];
                $id_p = $curr_prod[0];

                $c3++;
                echo "
     <form method='post'>
       ";
                if ($i % 2 != 0) {
                    echo "<tr style='background-color: #f2f2f2;'>";
                } else {
                    echo "<tr>";
                }
                //$crs_id[$i]
                ?>
                <td style='width:5%;'>
                <center><b class="mtd" name='<?php echo "product_id$i" ?>'><?php echo ($c3); ?></b></center>
                </td>
                <td style='font-weight:bold; width:15%; text-align: center;'>
                    <b class="mtd" id='h1' style='color:black;' name='<?php echo "product_name$i"; ?>' 
                       data-toggle='popover' data-trigger='hover' data-content='المنتج' ><?php echo $curr_prod[1]; ?></b>
                </td>
                <td style='width:8%;'>
                    <p id="h1" style='color:black;' name="<?php echo "img$i"; ?>"
                       data-toggle='popover' data-trigger='hover' data-content='صورة المنتج'/>
                    <?php echo "$curr_prod[8]"; ?></p>
                </td>   
                <td style="width: 10%; "><center>
                    <b class="mtd" id="h1" style='color:black;' name="<?php echo "price$i"; ?>"
                       data-toggle='popover' data-trigger='hover' data-content='سعر الوحدة'/>
                    <?php echo "($curr_prod[3]) " . "جنيه"; ?></b>
                    </td> 
                    <td style="width: 8%; "><center>
                        <b class="mtd" id="h1" style='color:black;' name="<?php echo "quantity$i"; ?>"
                           data-toggle='popover' data-trigger='hover' data-content='كمية المخزن'/><?php echo "$curr_prod[7]"; ?></b>
                        </td> 
                        <td style="width: 12%; "><center>
                            <b class="mtd" id="h1" style='color:black;' name="<?php echo "p_date$i"; ?>"
                               data-toggle='popover' data-trigger='hover' data-content='تاريخ الانتاج'/><?php echo date($curr_prod[4]); ?></b>
                            </td> 

                            <td style="width: 9%;   <?php
                            if ($curr_prod[6] < 7) {
                                echo "background-color: red;";
                            } elseif ($curr_prod[6] >= 7 && $curr_prod[6] < 15) {
                                echo "background-color:yellow;";
                            } else {
                                
                            }
                            ?> "><center>
                                <b class="mtd" id="h1" style='color: black;' name="<?php echo "validity$i"; ?>"
                                   data-toggle='popover' data-trigger='hover' data-content='المدة المتبقية في الصلاحية'/>
                                <?php echo "$curr_prod[6] يوما  "; ?></b>
                                </td> 
                                <td style="width: 5%; "><center>
                                    <b class="mtd" id="h1" style='color:black;' name="<?php echo "discount$i"; ?>"
                                       data-toggle='popover' data-trigger='hover' data-content='الخصم'/><?php
                                       $d = $curr_prod[10] * 100;
                                       echo "$d %";
                                       ?></center>
                                </td> 
                                <td style="text-align: center;">
                                <nobr> 
                                    <button id='h4' value='<?php echo"course$i"; ?>'  data-toggle='popover' 
                                            data-trigger='hover' data-content='إضغط لتعديل المنتج' > 
                                        <a style='color:white;' href="add_products_form.php?action=fill&edit=1&id=<?php echo $curr_prod[0]; ?>">تعديل المنتج</a> 
                                    </button>
                                    <input type="submit" value="حذف المنتج" name="<?php echo"delete$i"; ?>" id="h4"
                                           onclick="if (!confirm('هل تريد حذف المنتج !'))
                                                                   return false;
                                                               document.getElementById('p').style.display = ''" />
                                </nobr>      
                                </td>
                                </tr>
                                </form>

                                <?php
                            }
                            ?>
                            </table>
        <form method="post">
            <br />
           <?php if(count($products_data_arr)>0){ ?>
             <input type="submit" value="حذف المنتجات منتهية الصلاحية" name="dalete_exp_prods" id="h4"
                   onclick="if (!confirm('هل تريد حذف المنتجات منتهية الصلاحية !')) return false;
                        document.getElementById('p').style.display = ''" />
             <input type="submit" value="حذف جميع المنتجات" name="dalete_all_prods" id="h4"
                   onclick="if (!confirm('هل تريد حذف المنتجات !')) return false;
                        document.getElementById('p').style.display = ''" />
           <?php  } ?>
        </form>
                        </center>
                        </body>
                        </html>
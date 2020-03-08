<?php
require 'connection.php';
require 'classes.php';
session_start();
$_SESSION['curr_page']='add_new_products_h.php';
$_SESSION['page_abbrev']='sell';
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
            #fatora{ width:98%; background-color:#dddfe2; }
            .control{background-color:silver;font-size:33px;}
            .btn{background-color:#1B8B3d;font-size:20px; color:white;}
            #del_btn,#del_btn_all{background-color:brown;font-size:20px; color:white; width: auto;}
            
            .data{color:white;font-size:18px;}
            #selected_products{width:auto;  height: 20px; overflow:auto;}
            #selected_products tr td{width: 160px; height: 30px;} 
            
            #selected_products tr td input{ width: 60%; height:25px; font-size: 18px;background-color:silver; 
                         text-align: center; border-radius: 10px; }  
            
            #selected_products tr td img{ align-items: center;}
            #selected_products tr td b{z-index: 2;}
            #all_products{height: 30px; width: 100%;}
            #all_products tr td {width:16px;height:20px; border: none; }
            #cell_tbl tr td {width:16px;height:20px; background-color: #fafafa; border-style: none; }
            #cell_tbl tr td img {height:101%;}
           
            .tdsimg{border-radius: 50px; width: 100%; height: 80%;}
            #hidden_tbl_for_ids{width: 100%; height: auto; background-color:#fafafa; margin-top: 22px; }
            #hidden_tbl_for_ids tr td{width: 10%; color:blue; font-size: 22px;}
            #x{width:10%; margin-right:0px; background-color: brown; border-radius: 3px; color: whitesmoke; }
            .odd td{background-color: silver;}
            .mtd:hover{color: white;}
            
            #all_products tr td:hover{
               background-color: #293f5a; color: red;}
            #all_products2 tr th{
               background-color: #293f5a; color: white; font-size: 20px;}
            #show_fatora_div,#hide_fatora_div{
               
            }
            #show_fatora_div,#hide_fatora_div_b{
                position: fixed; bottom: 6px; color:#293f5a; font-size: 18px; right: 1px;
                background-color: #e9e9e7;
                border: 2px #777774 solid;
                border-radius: 3px;
                
            }
            
            
        </style>
       
    </head>
    <!-- ####################################################################################################### -->
    <body id="body" dir="rtl" onpageshow="disp_selec_tbl(),show_msg()">
       <?php
          $msg = '';
          $done=-1;
           $dd= get_date($conn);  
        $assoc_arr_id=assoc_arr_id(prod_data_to_arr(get_products($conn)));
        $total_price=0.00;
        
        if(isset($_POST['save_fatora'])){
            $bill_no= next_bill_no($conn);
           $ids_str=$_POST['text_ids'];
           $ids_arr=array();
           if(strlen($ids_str)>0){
          // $ids_arr= str_split($ids_str,",");
           $part='';$inc=0;
           for($i=0;$i<strlen($ids_str);$i++){
               if($ids_str[$i]!=','){$part.="$ids_str[$i]";}
                  else {$ids_arr[$inc]=$part;$part='';$inc++;}
                if($i==strlen($ids_str)-1) {$ids_arr[$inc]=$part;} 
                 }
           //var_dump($ids_str);
            
           $all_total_prices=0;     
           for ($i = 0; $i < count($ids_arr); $i++) {
               $idi=$ids_arr[$i];
               //$quantity_p=1;
               
               $quantity_p=$_POST["num_$idi"];
               //$ddate= get_date($conn);
               $bill_date=$_POST['ddate'];
               $dd=$bill_date;
              //$bill_no= next_bill_no($conn);
              //$bill_date=$_POST['ddate'];
              $cash=$_POST['cash'];
              $customer=$_POST['customer'];
              $customer_id=customer_id($conn,$customer);
             if($i==0){ $notes=$_POST['notes'];}
             else{$notes='';}
              $discount=$assoc_arr_id["$idi"]['discount'];
              $pricee=$assoc_arr_id["$idi"]['price'];
              $total_pricee=$quantity_p*$pricee-($quantity_p*$pricee*$discount);
              $seller_id=$user_id;
              if($quantity_p&&$user_id){
                 if(new_order($conn, $bill_no,$bill_date, $idi, $quantity_p, $total_pricee, $customer_id, $seller_id, $cash, $notes, $discount)){
                   update_remaining($conn,$idi,-($quantity_p));
                   $all_total_prices+=$total_pricee;
                     $done=1; 
                   $msg="<b style='color:green;'>تم الحفظ بنجاح</b>";
                 }else{$done=0;
                 $msg="<b style='color:brown;'>عفوآ , لم يتم الحفظ</b>";
                 }
              }
           }
           $total_price=$all_total_prices;
           }
        }
        if(isset($_POST['reset'])){
             $dd=$_POST['ddate'];
             
        }
        $ids_str='';
        $quantity_p=0;
        $bill_no= next_bill_no($conn);
        ?>
        
        <center>
        <!-- ############################################################################## -->
        
        <div class="wrapper col1" id="home" style="position: fixed;  top: 0px; z-index:2;background-color: #293f5a; ">
          
            <center><h1 style="color: white; font-size: 24px;">ماركت نادي ضباط القوات المسلحة برأس البر</h1></center><br />
            <!-- ############################################# -->
            <div class="wrapper col2"   >
                <div id="topnav" style="width:98%; background-color:whitesmoke; border-bottom-color:#293f5a;" >
                    <form name="searchform">
                        <center>
                            <ul class="uris" >  
                                <li>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>  
                                <li > <a href="settings_h.php" style="font-size: 1.2em;">
                                        <b >الإعدادات و الإضافة</b></a> </li>
                                <?php //#dad9ff   ?>
                                <li><a href="#" style="font-size: 1.2em;color:white; background-color: #293f5a; font-size: 1.9em; 
                                       padding:5px 5px 9px 5px; text-shadow: 5px 2px 5px gray;">
                                        <b>صفحة البيع</b></a></li>
                                        <li><a href="bills_page.php"><b style="font-size: 1.2em;">عرض الفواتير</b></a></li>
                                <li><a href="inventory_day_h.php" style="font-size: 1.2em;"> <b>صفحة الجرد</b></a> </li>
                                <li><a href="" style="font-size: 1.2em;"> <b>استعلامات</b></a> </li> 
                                <!-- <li><a href="#" ><b style="font-size: 1.5em;">Search Here</b> </a></li> -->
                                <li>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li> 
                                
                                <li><input type="text" maxlength="55" id="myInput" autocomplete="none" autofocus=""
                                               onkeyup="myFunction()" placeholder="...إبحث بإسم المنتج او الصنف"
                                               title="Type in a name" style="font-size: 1.2em; direction: rtl; 
                                               margin-bottom: 12px; height:24px; width:180%;" > 
                                     
                                    </li>
                                
                        </center>   
                    </form>
                </div>
            </div>
        </div> 
          <a href="bridge_to_login.php"
                  style="color: white; z-index: 3; font-size: 18px; position: fixed; top: -3px; left: -3px;
                  text-decoration: none;"
                  onmouseover="this.style.color='#960000'" onmouseout="this.style.color='#dddfe2'">
             <b>   تسجيل الخروج   &nbsp;&nbsp;</b></a>
        
        <form method="post" action="" enctype="multipart/form-data" > 
            <fieldset id='fatora' style="text-align: center;border-top-width: 4px; position: fixed;
                      top: 104px; border-radius: 0px;">
           <!-- ####### selected ################################################################### --> 
            <?php /* echo get_date($conn);  */ ?>
            <table style='direction:rtl; border:2px #0F4D21 solid;' id="ffatora">
                <tr>
                    <th>رقم الفاتورة</th> <th>عدد الاصناف</th> <th>المشتري</th> <th>الدفع</th> <th>ملاحظات</th> <th>إجمالي السعر</th>
                    <td class='control'>
                <?php //echo date("F j, Y, g:i a");
                  //$dd= get_date($conn);   ?>
                <input type="date" value="<?php echo $dd;  ?>" name="ddate" placeholder='غير التاريخ' style="width: 64%;
               text-align: center; height: 20px; font-size: 15px; background-color: silver;" />
            </td>
                </tr>
                <tr class='data'>
                    <td><?php echo $bill_no;  ?></td> 
                    <td><input type="text" style="text-align: center;width: 92px;" value='0' id='count_prods' disabled="none" /></td>
                    <td style='text-align: center;'>
                        <select name="customer" id="customer" style='width: 95%; text-align: center; font-size: 18px;' >
                    <?php
                    $customers= customers($conn);
                    for ($i = 0; $i < count($customers); $i++) {
                        $curr_cust=$customers[$i];
                        if($i==0){echo "<option>$curr_cust[1]</option>";}
                        else{
                           echo "<option>$curr_cust[1]</option>"; }
                       }
                    ?>
                      </select>      
                    </td>
                    <td>
                        <select name="cash" style='width: 95%; text-align: center; font-size: 18px;' >
                            <option value="1">نقدي</option>
                            <option value="0">أجل</option>
                      </select>     
                    </td>
                    <td><input type="text" name="notes" style='width:95%;' /></td>  
                    <td><input type="text" style="text-align: center;width: 92px;" name="total_price_td" id='total_price_td' value="<?=$total_price ?>" disabled="none" /></td>
                    <td >
                        <center><nobr>
                        <input type='submit' class='btn' id='btn1' name="save_fatora" value=' حفظ  الفاتورة' />
                        <input type='submit' onclick="window.open('marketHome.php','_self')" class='btn' name="reset" id='btn2' value='إلغاء / تنشيط' /><br />
                    </nobr>
                </center>
                    </td>
                </tr>
            </table>
        </fieldset>
            <!--   margin-top:182px;  -->
            <div class="scrollmenu" id="selected_products_div" style="  bottom: -1px;  position: fixed;
                 width: 100%; height: 132px;  background-image: url('images/sky.jpg'); background-size: cover;">
                  <table name='selected_items' id="selected_products" dir="rtl" onchange="sum();"
                        style="height: auto; width: 100%;" >
                    <tr>
                       <th style="width:10%;"></th> <th style="width:10%;">م</th> <th style="width:25%;"> إسم المنتج </th>
                        <th style="width:15%; height: 33px;">الكمية</th><th style="width:15%;">سعر الوحدة</th> <th style="width:15%;">الاجمالي</th>
                        <th>
                           <!-- <input type="checkbox" name="all_ch" id="all_ch" onclick="check_all()" style="font-weight: bold; font-size: 20px;"/>
                            <button id='del_btn_all' name='del_btn_all' oncheck='delete_all()' >إرجاع</button></th>
                           -->
                </tr>
            </table>
                <!--<input type="text" name="row_index" id="row_index"  value="1"/>-->
                <input type="text" style="display: none;" id="done_input"
                     <?php  echo "value='$done'"; ?> />
                  <h1 id="msg" style="display: none; font-size: 22px;"><?php echo "$msg";  ?></h1>
                  <table id="hidden_tbl_for_ids" style=" display: none;">
                       <tr></tr>
                       <?php   //<td><input type="text" value="0" id="hid_ids" name="hid_ids" /></td>  display: none;
                       ?>
                   </table>
       <input type="text" id="text_ids" value="" name="text_ids" style="color:black; display: none;" />
       
        </div>
         
    <!-- ############################################################################## -->   
      <div style=" position:fixed; top: 181px;width: 100%;height: 28px;">
     <table id="all_products2" style=" width: 100%; z-index: 2;
          font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue',Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';">
  <tr>
   <th style="width: 8%;"> م </th>
   <th style="width: 15%;">الصنف</th>
   <th style="width: 8%;">الصورة</th>
   <th style="width: 10%;">السعر</th> 
   <th style="width: 8%;">الكمية</th> 
   <th style="width: 15%;">ت الانتاج</th> 
   <th style="width: 15%;">ت الانتهاء</th> 
   <th style="width: 8%;">الصلاحية</th> 
   <th style="width: 8%;">خصم</th> 
  
 </tr>
   </table> 
   </div> 
    
    <div id="content" class="content" style="text-align: center; width: 100%; ">
           
           <?php 
            $products_data_fetsh=get_products($conn);
            $products_data_arr=prod_data_to_arr($products_data_fetsh);
            
            echo '<script>
        function m(){
        var products=[]; 
        ';
foreach ($products_data_arr as $i => $row) {
    //echo "alert('mmmmm');";
    echo 'var products2=[];';
    foreach ($row as $j => $v) {
        // echo 'var products2=[0];';
        echo ' products2[' . $j . ']="' . $v . '";';  //id
    }
    // echo " products2[10]='<br />';";
    echo " products[products2[0]]=products2;";  //id
    //echo " products[$i]=products2;";  //id
}
echo "document.getElementById('arrays_to_js').innerHTML=products;";
echo "
             return products;
              }
              function ma(){
               var s=m();
              document.getElementById('arrays_to_js').innerHTML=s+'<br />';
              }
            </script> ";
            
            echo "<p id='arrays_to_js'>thank GOD</p>";
            
            
            ?>
            
            
            <center>
                 <?php  $id=2; ?>
          <!--<form method='post'>          -->
             <table  id="all_products" style="  width: 100%; margin-top: 220px; text-align: center; ">
     <?php
 for($j=0;$j<1;$j++){
  for ($i=0;$i<count($products_data_arr);$i++)
   {
      $img=$products_data_arr[$i][8];
      $curr_prod=$products_data_arr[$i];
      $id_p=$curr_prod[0];
   if($i%2!=0)
   {?>
 <tr class="odd" style='background-color: #f2f2f2;' onclick="add_product(<?php echo $curr_prod[0];?>);" 
     onmouseover="overtr(this)" onmouseout="outtr(this,1)">
  <?php }
   else { ?>
 <tr class="even" style="background-color: #293f5a;" onclick="add_product(<?php echo $curr_prod[0];?>);"
   onmouseover="overtr(this)" onmouseout="outtr(this,0)" >
  <?php }
    ?>
         <td style='width:8%;'>
 <center><b class="mtd" name='<?php echo "product_id$i" ?>'><?php echo ($i+1);?></b></center>
  	</td>
        <td style='font-weight:bold; width:15%;'>
        <b class="mtd" id='h1' style='color:black;' name='<?php echo "product_name$i";?>' 
              data-toggle='popover' data-trigger='hover' data-content='المنتج' ><?php echo $curr_prod[1];?></b>
  	</td>
         <td style='width:8%; height: 40px;'>
             <p id="h1" style='color:black; height: 101%;' name="<?php echo "img$i";?>"
               data-toggle='popover' data-trigger='hover' data-content='صورة المنتج'/>
             <?php echo "$curr_prod[8]"; ?></p>
            </td>   
         <td style="width: 10%; "><center>
             <b class="mtd" id="h1" style='color:black;' name="<?php echo "price$i";?>"
                        data-toggle='popover' data-trigger='hover' data-content='سعر الوحدة'/>
                            <?php echo "( <b style='color:darkblue;'>".$curr_prod[3]."</b> ) جنيه"; ?></b>
         </td> 
         <td style="width: 8%; "><center>
             <b class="mtd" id="h1" style='color:black;' name="<?php echo "quantity$i";?>"
                        data-toggle='popover' data-trigger='hover' data-content='كمية المخزن'/><?php echo "$curr_prod[7]"; ?></b>
         </td> 
         <td style="width: 15%; "><center>
             <b class="mtd" id="h1" style='color:black;' name="<?php echo "p_date$i";?>"
                data-toggle='popover' data-trigger='hover' data-content='تاريخ الانتاج'/><?php echo date($curr_prod[4]); ?></b>
         </td> 
         <td style="width: 15%; "><center>
             <b class="mtd" id="h1" style='color:black;' name="<?php echo "ex_date$i";?>"
                data-toggle='popover' data-trigger='hover' data-content='تاريخ الانتهاء'/><?php echo date($curr_prod[4]); ?></b>
         </td> 
         <td style="width: 8%; "><center>
             <b class="mtd" id="h1" name="<?php echo "validity$i";?>"
                data-toggle='popover' data-trigger='hover' data-content='المدة المتبقية في الصلاحية'
               style=' <?php if($curr_prod[6]<7){echo 'color:red;'; }elseif($curr_prod[6]>=7&&$curr_prod[6]<=15){echo'color: #eef602;';}else{echo'color: black;';}?> '>
                    <?php echo "$curr_prod[6]أيام "; ?></b>
         </td> 
          <?php $d=$curr_prod[10]*100; ?>
         <td style="width: 8%;"><center>
             <b class="mtd" id="h1" style='<?php if($d>0){echo 'color:green;'; }else{echo'color:black;';}?>' name="<?php echo "discount$i";?>"
                        data-toggle='popover' data-trigger='hover' data-content='الخصم'/>
                            <?php $ds=$curr_prod[10]*100; echo "$ds %"; ?></center>
         </td> 

 </tr>
 <?php
   }
 }
 ?>
   </table>
            <!-- </form> -->

               
            </center>
        </div>
         </form>
       </center>
         
         <div id="show_fatora_div" onclick="show_fatora()">
             <nobr> <b id="show_fatora_div_b" style="" >أنظر الفاتورة </b>
         <img src="images/seen.png" alt="see fatora" id="seen" style="
             position: fixed; bottom: 8px; right: 85px; width: 30px; height: 20px;"/></nobr>
            
         </div>
         <div id="hide_fatora_div" onclick="hide_fatora()">
            <b id="hide_fatora_div_b" style="" > إخفي الفاتورة</b>
         </div>
         
         
        
         <button id="stretch_fatora_div" onclick="stretch_fatora()" 
                 style="background-color: #bebebc; color: white;position: fixed; bottom: 95px; right: 10px;
                 color:#293f5a; font-size: 20px; "> تكبير الفاتورة+ </button>
         <button id="shrink_fatora_div" onclick="shrink_fatora()" 
                 style="background-color: #bebebc; color: white;position: fixed; bottom: 374px; right: 10px;
                 color:#293f5a; font-size: 20px; "> تصغير الفاتورة </button>
         
         <table id="virtual_table" style="display: none;"></table>
         
         
    </body>
</html>
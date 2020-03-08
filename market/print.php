<?php
$show_tbl='d';
$inv_num=filter_input(INPUT_GET, 'p',FILTER_SANITIZE_NUMBER_INT);
if($inv_num&&$inv_num==2){ $show_tbl='d';}
else{ $show_tbl='m';}
require 'connection.php';
require 'classes.php';
//$dd= get_date($conn);
$dd= get_date($conn);
$recev_date = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_NUMBER_INT);;
if(isset($recev_date)){
    $dd=$recev_date;
}
$dd_m=date("F, Y");

?>
<html>
    <head>
        <title><?php if($show_tbl=='m'){echo'الجرد الشهري'.$dd;}else{echo'يومية الماركت '." ". dayName($conn, $dd)." ".$dd;} ?> </title>
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
            #print{
                width: 40%; height: 40px; background-color: #000066; color: white;
                border: 3px solid white; border-radius: 15px; font-size: 22px; font-weight: bold; font-style: italic;
                margin-right: 0px;
            }
            #print:hover{
                background-color: #b1b1d3; color: #000066;
                border: 3px solid #000066;  
            }
            #printer{
                width: 10%; height: 40px;  border-radius: 15px;
               margin-bottom: -15px;
            }
            
        </style>
       
    </head>
    <!-- ####################################################################################################### -->
    <body id="body" dir="rtl" onpageshow="">
      <center>
        <form method="post" action="" enctype="multipart/form-data" > 
          <!-- position: fixed;top: 0px;  -->
            <table style='direction:rtl;text-align: center;border-top-width: 4px; width: 100%; ' id="ffatora">
               <tr>
                  <th colspan="4"><?php if($show_tbl=='m'){echo'الجرد الشهري  ';}else{echo'يومية الماركت ';} ?></th>
                </tr>
               <tr>
                      <th style="width:40%;">نوع الجرد</th>
                     <?php if($show_tbl=='m'){?>
                     <th style="">شهر</th><?php }else{?> 
                      <th style="">يوم</th><?php }?> 
                      <th style="">التاريخ</th>
                      <th rowspan="2">
                          <button name="print" id="print" onclick="window.print()" >Print</button>
                          <img src="images/printer.jpg" alt="print" id="printer" onclick="window.print()" />
                      </th>
                      
                      
                </tr>
                <tr class='data' style='text-align: center;'>
                     <td style='text-align: center;'>
                         <b name="inv_type" id="inv_type" style='width: 95%; text-align: center; font-size: 18px;'>
                        <?php if($show_tbl=='m'){echo "شهري  / عام  ";}else{ echo 'يومي';}  ?> 
                         </b>   
                         
                    </td>
                    <?php if($show_tbl=='m'){?>
                     <td><b style="width: 55%; text-align: center; width: 99%; font-weight: bold;
                            font-size: 18px;" > <?php echo monthName($conn, $dd);  ?></b>
                    </td>
                    <?php }else{?> 
                     <td><b style="width: 55%; text-align: center; width: 99%; font-weight: bold;
                            font-size: 18px;" > <?php echo dayName($conn, $dd);  ?></b>
                                               
                    </td><?php }?>
                    <td>
                        <b style="width: 55%; text-align: center; width: 99%; font-weight: bold;
                            font-size: 18px;" > <?php echo $dd;  ?></b>
                    </td>
                </tr>
            </table>
     
    <!-- ############################################################################## -->   
   <!-- position: fixed;right: -3px; -->
    <!-- margin-top: 126px; -->
    <div id="content" class="content" style="text-align: center; width: 100%; top: 91px; ">
           
           <?php 
            $assoc_products_arr= assoc_arr_id(prod_data_to_arr(get_products($conn)));
            
            $products_global_fetsh= get_global_products($conn);
            $products_day_fetsh= get_day_products($conn,$dd);
           
            ?>
            
            <center>
                 <?php  $id=2; ?>
          <!--<form method='post'>          -->     
          
  <table  id="all_products" style="  width: 100%; margin-top: 1px; margin-bottom: 2px; text-align: center; ">
     
     <?php
     echo th($show_tbl);
     $day_name='اليوم';
     $total_pricess=0;
     $total_leak_pricess=0;
          if($show_tbl=='m'){ $curr_prod = $products_global_fetsh; $day_name=' الشهر';}
           else{ $curr_prod = $products_day_fetsh;} 
         if (count($curr_prod[0])>0) {  //for repeat to check height
             $incc=1;
             for ($i = 0; $i < count($curr_prod[0]); $i++) {
                 $incc++;
                 $id_p = $curr_prod[0][$i];
                 $name = $assoc_products_arr["$id_p"]['name'];
                 $img = $assoc_products_arr["$id_p"]['image'];
                 $full_quantity = $assoc_products_arr["$id_p"]['quantity'];
                 $remain_quantity = $assoc_products_arr["$id_p"]['remain'];
                 $discc = $assoc_products_arr["$id_p"]['discount'];
                 $price = $assoc_products_arr["$id_p"]['price'];
                 $quantity = $curr_prod[1][$i];
                 $leak=$quantity-($full_quantity-$remain_quantity);
                 $total_leak_pricess+=($leak*$price);
                 $totl_price = $price * $quantity-($price * $quantity*$discc);
                 $total_pricess+=$totl_price;
                 //if($incc==30&&$i<=count($curr_prod[0])-2){if($i>29){echo th2().th2();}echo th($show_tbl);$incc=1;}
                 if($i%2!=0)
   {?>
 <tr class="odd" style='background-color: #f2f2f2;'
     onmouseover="overtr(this)" onmouseout="outtr(this,1)">
  <?php }
   else { ?>
 <tr class="even" style="background-color: #293f5a;"
   onmouseover="overtr(this)" onmouseout="outtr(this,0)" >
  <?php }
    ?>
         <td style='width:5%;'>
            <center><b class="mtd" name='<?php echo "product_id$i" ?>'><?php echo ($i+1);?></b></center>
  	</td>
        <td style='font-weight:bold; width:15%;'>
            <b class="mtd" id='h1' style='color:black;' name='<?php echo "product_name$i";?>' 
              data-toggle='popover' data-trigger='hover' data-content='المنتج' ><?php echo $name;?></b>
  	</td>
          <?php if($show_tbl=='d'){  ?>
            
            <td style="width: 10%; "><center>
             <b class="mtd" id="h1" style='color:black;' name="<?php echo "quantity$i";?>"
                        data-toggle='popover' data-trigger='hover' data-content='الكمية المباعة خلال اليوم'/>
                            <?php echo "$quantity"; ?></b>
             </td> 
            <td style="width: 10%; "><center>
             <b class="mtd" id="h1" style='color:black;' name="<?php echo "price$i";?>"
                        data-toggle='popover' data-trigger='hover' data-content='سعر الوحدة'/>
                            <?php echo "$price"; ?></b>
            </td> 
          <td style="width: 15%; "><center>
             <b class="mtd" id="h1" style='color:black;' name="<?php echo "total_price$i";?>"
                data-toggle='popover' data-trigger='hover' data-content='اجمالي سعر المنتج'/>
                    <?php echo "$totl_price"; ?></b>
         </td> 
         
         <?php
           }
         else{ ?>
           <td style="width: 10%; "><center>
             <b class="mtd" id="h1" style='color:black;' name="<?php echo "full_quantity$i";?>"
                        data-toggle='popover' data-trigger='hover' data-content='كمية الوارد'/>
                            <?php echo "$full_quantity"; ?></b>
            </td>
            <td style="width: 10%; "><center>
             <b class="mtd" id="h1" style='color:black;' name="<?php echo "quantity$i";?>"
                        data-toggle='popover' data-trigger='hover' data-content='الكمية المباعة خلال الشهر'/>
                            <?php echo "$quantity"; ?></b>
             </td> 
          <td style="width: 10%; "><center>
             <b class="mtd" id="h1" style='color:black;' name="<?php echo "remain$i";?>"
                data-toggle='popover' data-trigger='hover' data-content='الكمية المتبقية'/>
                    <?php echo "$remain_quantity"; ?></b>
          
          <td style="width: 10%;"><center>
             <b class="mtd" id="h1" style='color:black;' name="<?php echo "leak$i";?>"
                data-toggle='popover' data-trigger='hover' data-content='عجز / ذيادة'/>
                    <?php echo "$leak"; ?></b>
         </td>  
         
        <?php } ?>
  </tr>
 <?php
 //if($i==16){echo '<tr><td colspan="7">_</td></tr><tr><td colspan="7">_</td></tr>'; }
   } ?>
  <tr>
      <th  <?php if($show_tbl=='d'){echo 'colspan="7"';}else{echo 'colspan="8"';} ?> style="text-align:center; background-color: #DDDDDD; color: #293f5a; font-weight: bold;
                        border:2px solid black;">
          <b> إجمالي المبيعات : <?php echo ' ( '.$total_pricess.' ) '; ?>  جنيهاً .</b></th>
  </tr> 
  
 <?php 
 if($show_tbl=='m' && $total_leak_pricess!=0){ 
     ?> 
  <tr>
      <th colspan="7" style="text-align:center; background-color: #DDDDDD; color: #293f5a; font-weight: bold;
                        border:2px solid black;">
          <b>  قيمة العجز/ الزيادة : <?php echo ' ( '.$total_leak_pricess.' ) '; ?>  جنيهاً .</b></th>
  </tr>
     
 <?php }
 
 
         }
 else{?>
  
 <tr class="odd" style='background-color: #f2f2f2; text-align: center; font-size: 20px;font-weight: bold;'
     onmouseover="overtr(this)" onmouseout="outtr(this,1)">
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

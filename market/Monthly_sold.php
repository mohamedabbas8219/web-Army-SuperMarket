<?php
require 'connection.php';
require 'classes.php';
session_start();
require 'check_sess_user.php';
$_SESSION['curr_page']='add_new_products_h.php';
    $dd=get_date($conn);
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
            function save_first(){
               document.getElementById("btn1").style.display='none';
               document.getElementById("print").style.display='none';
            }
            function resett(){
               document.getElementById("btn1").style.display='';
               document.getElementById("print").style.display='';
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
            #fatora{ width:98%; background-color:#dddfe2; }
            .control{background-color:silver;font-size:33px;}
            .btn{background-color:#1B8B3d;font-size:20px; color:white;}
            .data{color:white;font-size:18px;}
            #selected_products{width:auto;  height: 20px; overflow:auto;}
            #selected_products tr td{width: 160px; height: 60px;} 
            
            #selected_products tr td input{ width: 60%; height:18px; font-size: 16px;background-color:silver; 
                         text-align: center; border-radius: 10px; }  
            
            #selected_products tr td img{ align-items: center;}
            #selected_products tr td b{z-index: 2;}
            #all_products{height: 30px; width: 100%;}
            #all_products tr td {width:16px;height:20px; border: none; }
            #cell_tbl tr td {width:16px;height:20px; background-color: #fafafa; border-style: none; }
            #cell_tbl tr td img {height:101%;}
           
            .tdsimg{border-radius: 50px; width: 100%; height: 80%;}
            #hidden_tbl_for_ids{width: 100%; height: auto; background-color:#fafafa; margin-top: 22px; display: none;}
            #hidden_tbl_for_ids tr td{width: 10%; color:blue; font-size: 22px;}
            #x{width:10%; margin-right:0px; background-color: brown; border-radius: 3px; color: whitesmoke; }
            .odd td{background-color: silver;}
            .mtd:hover{color: white;}
            
            #all_products tr td:hover{
               background-color: #293f5a; color: red;}
            #all_products2 tr th{
               background-color: #293f5a; color: white; font-size: 20px;}
            
            
        </style>
       
    </head>
    <!-- ####################################################################################################### -->
    <body id="body" dir="rtl" onpageshow="disp_selec_tbl(),show_msg()" onpagehide="alert('m')">
      <center>
      
        <?php
        $show_tbl='m';
        $inv_type='';
        $products_global_fetsh2= prod_data_to_arr2(get_products($conn));
         
        
        if(isset($_POST['show_inv'])){
             // $inv_type=$_POST['inv_type'];
              $inv_type='m';
              $date=$_POST['ddate'];
              $dd=$date;
              if($inv_type=='m'){ $show_tbl='m';}
                 else{ $show_tbl='d';  }
          }
         
          $prods_data=prod_data_to_arr2(get_products($conn));
          $all_prods_ass_arr=array();
          $all_ids=array();
          for ($i = 0; $i < count($prods_data); $i++) {
              $all_ids[$i]=$prods_data[$i][0];
             $all_prods_ass_arr[$prods_data[$i][0]]=array($prods_data[$i][2],$prods_data[$i][7],0);
          }
          
          
          
          ?>
        <form method="post" action="" enctype="multipart/form-data" > 
            <fieldset id='fatora' style="text-align: center;border-top-width: 4px; position: fixed;
                     top: 0px; border-radius: 0px;">
               <table style='direction:rtl; border:2px #0F4D21 solid;  width: 100%;' id="ffatora">
                  <tr>
                      <th style="width:35%;">تاريخ</th> <th style="width:25%;">الشهر</th> 
                      <th style="border-style: none;"> 
                          <input type="text" maxlength="55" id="myInput" autocomplete="none" autofocus=""
                                               onkeyup="myFunction()" placeholder="...إبحث بإسم المنتج او الصنف"
                                               title="Type in a name" style="font-size: 16px; direction: rtl; 
                                               height:25px; width:95%;" > </th>
                </tr>
                <tr class='data' style='text-align: center; '>
                   
                     <td><input required="" type="date" value="<?php echo $dd;  ?>" name="ddate" placeholder='غير التاريخ' style="width: 55%;
                              text-align: center; width: 99%; font-weight: bold; font-size: 22px; background-color: silver;" />
                    </td>
                     <td style='text-align: center; ' >
                       <?php echo ' , '. monthName($conn,$dd);  ?>    
                    </td>
                    <td rowspan='' class='control'  style="border-style: none; border-radius: 10px;">
                        <center>
                            <input type='submit' class='btn' id='btn1' name="show_inv" value=' إظهار الجرد'  />
                       <input type="button" class='btn'  name="print" onclick="window.open('print.php?p=<?php if($show_tbl=='d'){echo 1;}else{echo 2;}  ?>','')" id='print' value='طباعة ' />
                     </center>
                 </td>
                   
                </tr>
            </table>
        </fieldset>
     
    <!-- ############################################################################## -->   
   <div style=" position:fixed; top: 95px;width: 100%;height: 28px;">
     <table id="all_products2" style=" width: 98%; z-index: 2;
          font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue',Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';">
  <tr>
   <th style="width: 8%;"> م </th>
   <th style="width: 15%;">الصنف</th>
   <th style="width: 10%;">الكمية المباعة</th>
 </tr>
   </table> 
   </div> 
    <div id="content" class="content" style="text-align: center; width: 100%; ">
           
           <?php 
            $assoc_products_arr= assoc_arr_id(prod_data_to_arr(get_products($conn)));
            
            $products_global_fetsh= get_month_products($conn,$dd);
           // $products_day_fetsh= get_day_products($conn,$dd);
            ?>
            
            <center>
                 <?php  $id=2; ?>
          <!--<form method='post'>          -->
       <table  id="all_products" style="  width: 98%; margin-top: 130px; text-align: center; ">
     <?php
     $day_name='اليوم';
     $total_pricess=0;
     $total_leak_pricess=0;
          if($show_tbl=='m'){ $curr_prod = $products_global_fetsh; $day_name=' الشهر';}
           else{ $curr_prod = $products_day_fetsh;} 
            for ($i = 0; $i < count($curr_prod[0]); $i++) {
                 $id_p = $curr_prod[0][$i];
                 $sold_quantity = $curr_prod[1][$i];
                 $all_prods_ass_arr[$id_p][2]=$sold_quantity;
            }
           $total_sold2=0;
            for ($i = 0; $i < count($all_prods_ass_arr); $i++) {
                 $id_p = $all_ids[$i];
                 $sold_quantity = $all_prods_ass_arr[$id_p][2];
                 $total_sold2+=$sold_quantity;
            }
            
           $total_sold=0;$inc=0;
         if ($total_sold2>0)
             {  //for repeat to check height  end} in line 361
     for ($i = 0; $i < count($all_prods_ass_arr); $i++) {
                 $id_p = $all_ids[$i];
                 $name = $assoc_products_arr["$id_p"]['name'];
                 $sold_quantity = $all_prods_ass_arr[$id_p][2];
           if($sold_quantity>0){  
               $inc++;
                 $total_sold+=$sold_quantity;
                  $price = $assoc_products_arr["$id_p"]['price'];
                  $discc = $assoc_products_arr["$id_p"]['discount'];
                  //$notess = $assoc_products_arr["$id_p"]['notes'];
                  $img = $assoc_products_arr["$id_p"]['image'];
                 $totl_price = $price * $sold_quantity-($price * $sold_quantity*$discc);
                 if($totl_price>0){$total_pricess+=$totl_price;}
                 else{}
                 
            if($inc%2!=0){?>
 <tr class="odd" style='background-color: #f2f2f2;'
     onmouseover="overtr(this)" onmouseout="outtr(this,1)">
  <?php }
   else { ?>
 <tr class="even" style="background-color: #293f5a;"
   onmouseover="overtr(this)" onmouseout="outtr(this,0)" >
  <?php }
    ?>
         <td style='width:8%;'>
            <center><b class="mtd" name='<?php echo "product_id$i" ?>'><?php echo ($i+1);?></b></center>
  	</td>
        <td style='font-weight:bold; width:15%;'>
            <b class="mtd" id='h1' style='color:black; font-size: 20px;' name='<?php echo "product_name$i";?>' 
              data-toggle='popover' data-trigger='hover' data-content='المنتج' ><?php echo $name;?></b>
  	</td>
        
            <td style="width: 10%; "><center>
             <b class="mtd" id="h1" style='<?php if($sold_quantity>0){echo "color:blue; font-size:19px;'";}else{echo "color:black;'";} ?> '
                name="<?php echo "quantity$i";?>"
                        data-toggle='popover' data-trigger='hover' data-content='الكمية المباعة خلال الشهر'/>
                            <?php echo "$sold_quantity"; ?></b>  
             </td> 
            
          
  </tr>
 <?php
   }
  }
   ?>
  
  <tr>
      <th  <?php if($show_tbl=='d')
          {echo 'colspan="7"';}else{echo 'colspan="8"';} ?> 
          style="text-align:center; background-color: #DDDDDD; color: #293f5a; font-weight: bold; border:2px solid black;">
          <b autofocus=""> إجمالي المبيع خلال الشهر : <?php echo ' ( '.$total_pricess.' ) '; ?>  جنيهاً .</b></th>
  </tr> 
  
 <?php 
 if($total_sold!=0){ 
     ?> 
  <tr>
      <th colspan="8" style="text-align:center; background-color: #DDDDDD; color: #293f5a; font-weight: bold;
                        border:2px solid black;">
          <b>  قيمة العجز/ الزيادة : <?php echo ' ( '.$total_leak_pricess.' ) '; ?>  جنيهاً .</b></th>
  </tr>
     
 <?php }
 
         }
 else{?>
  
 <tr class="odd" style='background-color: #f2f2f2; text-align: center; font-size: 20px;font-weight: bold;'
     onmouseover="overtr(this)" onmouseout="outtr(this,1)">
     <td colspan="7" autofocus="">لا يوجد مبيعات هذا الشهر</td>
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


if(isset($_POST['save_inv'])){
              $date=$_POST['ddate'];
               for ($i = 0; $i < count($prods_data); $i++) {
                     $cid=$prods_data[$i][0];
                        $leak_q=$_POST["leak$i"];
                        if($leak_q!=0){
                        reset_inv_month($conn, $date);
                        update_inv_month($conn, $cid,$leak_q,$date,0);
                        }
                 }
}

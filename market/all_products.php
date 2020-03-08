<?php
require 'connection.php';
require 'classes.php';
//require 'showdata.php';
session_start();
$user=$_SESSION["username"];
$pass=$_SESSION['password'];
if($_SESSION["username"]&&$_SESSION["password"]&&check_user($conn,$user, $pass)){
$msg = '';
?>
<html>
    <head>
        <title>نادي ض ق م برأس البر </title>
        <meta charset="UTF-8">
        <script src="scripts/searchpg.js" type="text/javascript"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script src="scripts/jquery-1.11.3.min.js" type="text/javascript"></script> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/tables_adm.css" rel="stylesheet" type="text/css"/>
        <script src="scripts/searchpg.js" type="text/javascript"></script>
        <style>
            #all_products tr:odd{background-color: red;}
        </style>
    </head>
    <body>
        <?php
        $products_data_fetsh=get_products($conn);
        $products_data_arr=prod_data_to_arr($products_data_fetsh);
         $counter=0;
                        for($i=0;$i<count($products_data_arr);$i++){
                            $counter++;
                            $img=$products_data_arr[$i][8];
                        }
                           ?>
        
        <center>
<table id="table" style=" position: fixed; width: 100%; top:1px;
          font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue',Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';">
    <tr><th colspan="5">
                <input type="text" maxlength="55" id="myInput"
                       onkeyup="myFunction()" placeholder="...إبحث بإسم المنتج او الصنف"
                       title="Type in a name" style="font-size: 1.2em; direction: rtl; 
                       margin-bottom: 12px; height:24px; width:90%;" > 
          </th>
          <th colspan="4">
              
          </th>
    
    </tr>
        <tr>
   <th style="width: 9%;"> م </th>
   <th style="width: 15%;">الصنف</th>
   <th style="width: 15%;">الصورة</th>
   <th style="width: 10%;">السعر</th> 
   <th style="width: 8%;">الكمية</th> 
   <th style="width: 15%;">ت الانتاج</th> 
   <th style="width: 8%;">الصلاحية</th> 
   <th style="width: 8%;">خصم</th> 
   <th></th>
 </tr>
   </table>
<table  id="all_products" style="margin-top:41px;  width: 100%; text-align: center; ">
<?php
  for ($i=0;$i<count($products_data_arr);$i++)
   {
      $curr_prod=$products_data_arr[$i];
      $id_p=$curr_prod[0];
   echo "<form method='post'> ";
   if($i%2!=0)
   {
   echo "<tr style='background-color: #f2f2f2;'>";
   }
   else {echo "<tr>";}
    ?>
         <td style='width:8%;'>
         <center><b name='<?php echo "product_id$i" ?>'><?php echo ($i+1);?></b></center>
  	</td>
  	<td style='font-weight:bold; width:15%;'>
        <b id='h1' style='color:black;' name='<?php echo "product_name$i";?>' 
              data-toggle='popover' data-trigger='hover' data-content='المنتج' ><?php echo $curr_prod[1];?></b>
  	</td>
         <td style='width:15%;'> <p id="h1" style='color:black;' name="<?php echo "img$i";?>"
               data-toggle='popover' data-trigger='hover' data-content='صورة المنتج'/>
             <?php echo "$curr_prod[8]"; ?></p>
            </td>   
         
         <td style="width: 10%; "><center>
             <b id="h1" style='color:black;' name="<?php echo "price$i";?>"
                        data-toggle='popover' data-trigger='hover' data-content='سعر الوحدة'/><?php echo "$curr_prod[3]جنيه"; ?></b>
         </td> 
         <td style="width: 8%; "><center>
             <b id="h1" style='color:black;' name="<?php echo "quantity$i";?>"
                        data-toggle='popover' data-trigger='hover' data-content='كمية المخزن'/><?php echo "$curr_prod[7]"; ?></b>
         </td> 
         <td style="width: 15%; "><center>
             <b id="h1" style='color:black;' name="<?php echo "p_date$i";?>"
                data-toggle='popover' data-trigger='hover' data-content='تاريخ الانتاج'/><?php echo date($curr_prod[4]); ?></b>
         </td> 
         <td style="width: 8%; "><center>
             <b id="h1" style='color:black;' name="<?php echo "validity$i";?>"
                data-toggle='popover' data-trigger='hover' data-content='المدة المتبقية في الصلاحية'/><?php echo "$curr_prod[6]أيام "; ?></b>
         </td> 
         <td style="width: 8%; "><center>
             <b id="h1" style='color:black;' name="<?php echo "discount$i";?>"
                        data-toggle='popover' data-trigger='hover' data-content='الخصم'/><?php $d=$curr_prod[10]*100; echo "$d %"; ?></center>
         </td> 

         <td>
<center>
    <input id="h4" type='submit' name="<?php echo"edit$id_p" ?>" value="تعديل المنتج" />
 <input type='submit' onclick="if (!confirm('هل تريد حذف المنتج'))return false;"  
         name="<?php echo"delete$i";?>" data-toggle='popover' data-trigger='hover'
         data-content='إضغط لحذف هذا المنتج' id='h4' value="حذف " />
 
</center>
</td>
 </tr>
 </form>
 <?php
   }
 ?>
   </table>

</center>

        
        
        
    </body>
</html>
<?php

}
else{
    echo "<h1>يرجي تسجيل الدخول اولا .</h1>";
    

    $redirectURL = "market_login_page.php";
             header("Location:" . $redirectURL);
    
}

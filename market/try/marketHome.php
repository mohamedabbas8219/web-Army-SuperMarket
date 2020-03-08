<?php
require 'connection.php';
require 'classes.php';
//require 'showdata.php';
$msg = '';
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
            table tr td img{width:140%; border-radius:40%;}
            img{width:140px; border-radius:40%;}
            .title{text-align:center;
                   width:99%;color: #55000D; font-size:20px;border-radius:10px; border:1px solid #2f002f;}

            fieldset{margin-bottom:12px; width:99%;  color:white; border-radius:2px; border-width: 1px; border-top-width: 4px;}
            #fatora{ width:98%; background-color:#dddfe2; }
            .control{background-color:silver;font-size:33px;}
            .btn{background-color:#1B8B3d;font-size:20px; color:white;}
            .data{color:white;font-size:18px;}
            #selected_products{width:auto;  height: 20px; overflow:auto;}
            #selected_products tr td{width: 160px; height: 60px;} 
            #selected_products tr td:last-child{width: 40%;}
            #selected_products tr td input{ width: 60%; height:18px; font-size: 16px;background-color:silver; 
                         text-align: center; border-radius: 10px; }  
            
            #selected_products tr td img{width: 100%; height: 52%; align-items: center;}
            #selected_products tr td b{z-index: 2;}
            #all_products{height: 30px; width: 100%;}
            #all_products tr td {width:16%;height:20%; }
            #cell_tbl tr td {width:16%;height:20%; background-color: #fafafa; border-radius: 8px; }
            #cell_tbl tr td img {width:10%;height:100%; background-color: red;}
           
            .img{width:100%;height:20%;}
            #cell_tbl tr td{border-style: none;}
            .tdsimg{border-radius: 50px; width: 10%;}
            #hidden_tbl_for_ids{width: 100%; height: auto; background-color:#fafafa; margin-top: 22px; display: none; }
            #hidden_tbl_for_ids tr td{width: 10%; color:blue; font-size: 22px;}
            #x{width:10%; margin-right:0px; background-color: brown; border-radius: 3px; color: whitesmoke;}
        </style>
       
    </head>
    <!-- ####################################################################################################### -->
    <body id="body" dir="rtl" onpageshow="disp_selec_tbl()">
       
        <center>
        <!-- ############################################################################## -->
        <div class="wrapper col1" id="home" style="position: fixed; top: 0px; z-index:2;background-color: #293f5a; ">
            <center><h1 style="color: white;">ماركت نادي ضباط القوات المسلحة برأس البر</h1></center>
            <!-- ############################################# -->
            <div class="wrapper col2"   >
                <div id="topnav" style="width:98%; background-color:whitesmoke; border-bottom-color:#293f5a;" >
                    <form name="searchform">
                        <center>
                            <!-- style="border:5px black solid; height:1px; -->
                            <ul class="uris" >  
                                <li>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>  
                                <li > <a href="add_new_products.php" style="font-size: 1.2em;">
                                        <b >الإعدادات</b></a> </li>
                                <?php //#dad9ff   ?>
                                <li><a href="#" style="font-size: 1.2em;color:white; background-color: #293f5a; font-size: 1.9em; 
                                       padding:5px 5px 9px 5px; text-shadow: 5px 2px 5px gray;">
                                        <b>صفحة البيع</b></a></li>
                                <li><a href="#hpage"><b style="font-size: 1.2em;">عرض الفواتير</b></a></li>
                                <li><a href="" style="font-size: 1.2em;"> <b>صفحة الجرد</b></a> </li>
                                <li><a href="" style="font-size: 1.2em;"> <b>استعلامات</b></a> </li> 
                                <!-- <li><a href="#" ><b style="font-size: 1.5em;">Search Here</b> </a></li> -->
                                <li>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li> 
                                <form name="searchform">
                                    <li><input type="text" maxlength="55" id="myInput"
                                               onkeyup="myFunction()" placeholder="...إبحث بإسم المنتج او الصنف"
                                               title="Type in a name" style="font-size: 1.2em; direction: rtl; 
                                               margin-bottom: 12px; height:24px; width:150%;" > 
                                     
                                    </li>
                                </form> 
                                <a href="#" id="logout" style="margin-top: -10px; color:white; background-color: #293f5a; 
                                   height:15px; font-size: 1.4em; border-radius: 12px; 
                                   padding:5px 5px 10px 5px;" onclick="logoutf()" >
                                    <b >&nbsp; Log out &nbsp;</b> </a>
                        </center>                       
                </div>
            </div>
        </div>  
        <fieldset id='fatora' style="text-align: center;border-top-width: 4px; position: fixed;top: 84px; border-radius: 0px;">
           <!-- ####### selected ################################################################### --> 
            
            <?php /* echo get_date($conn);  */ ?>
            <table style='direction:rtl; border:2px #0F4D21 solid;' id="ffatora">
                <tr>
                    <th>رقم الفاتورة</th> <th>عدد الاصناف</th> <th>المشتري</th> <th>الدفع</th> <th>ملاحظات</th> <th>إجمالي السعر</th>
                    <td rowspan='2' class='control'><center>
                    <input type='button' class='btn' id='btn1' value=' حفظ  الفاتورة' />
                    <input type='button' class='btn' id='btn2' value='إلغاء' /><br />
                    <b style="font-size: 12px;"><?php echo $msg; ?></b>
                </center></td>
                </tr>
                <tr class='data'>
                    <td>1</td> <td>3</td> <td>customer</td>
                    <td>
                        نقدي<input type="radio" value="222" checked="" name="cash" />
                        آجل<input type="radio" value="111" name="cash" />

                    </td>
                    <td>لا يوجد</td>  
                    <td><input type="text" style="text-align: center;width: 92px;" id='total_price_td' value="0.00" disabled="none" /></td>
                </tr>
            </table>
        </fieldset>
         
        <div class="scrollmenu" style=" margin-top:162px;">
                <table name='selected_items' id="selected_products" dir="ltr" onchange="sum();" class="selected_items_tbl" >
                <tr id="selected_prod_row">
                   
                 
                </tr>
            </table>
        </div>
    <!-- ############################################################################## -->   
        <div id="content" class="content" style="text-align: center; width: 99%; ">
           
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
               <form method='post'>
                <fieldset style='width:96%; border:2px solid gray; border-top-width: 3px; color:white;'>
                    <table id="all_products">
                        <tr>
                     <?php
                         $counter=0;
                        for($i=0;$i<count($products_data_arr);$i++){
                            $counter++;
                            $img=$products_data_arr[$i][8];
                        ?>
                            
                            
                            
                           <td onclick="add_product(<?php echo $products_data_arr[$i][0];?>);" 
                               style="background-image:url('');"
                               onmouseover ="this.style.backgroundColor='#00f47a';" 
                               onmouseout ="this.style.backgroundColor='#fafafa';" >                                
                               <table style="width:99%;" id="cell_tbl">
                                   <tr><td rowspan="2" style="background-image: url(''); border-radius: 50px; width: 10%;">
                                   <center><big><?php echo $img; ?></big></center>
                                     </td>
                                      <td><b><?php echo $products_data_arr[$i][1];?></b></td></tr>
                                   <tr><td> <?php echo "الكمية :(".$products_data_arr[$i][2].')';  ?></td> </tr>
                                   <tr><td><b><?php echo "(".$products_data_arr[$i][3].")جنيه ";?></b></td>
                                   <?php $disctt=$products_data_arr[$i][10]*100;
                                   if($disctt>0){echo "<td style='border-radius: 5px; background-color:#00f47a;'>خصم:$disctt%</td>";}
                                   else{echo "<td>_</td>";}
                                       ?>
                                   </tr>
                               </table>
                           </td>
                          
                           
                           <?php
                           if($counter==5||$i==count($products_data_arr)-1){
                               echo '</tr>';
                               $counter=0;
                               if(count($products_data_arr)>$i-1){
                                   echo '<tr>';
                               }
                           }
                        }
                         ?>  
                        
                        
                    </table>
                </fieldset>
                   <table id="hidden_tbl_for_ids">
                       <tr></tr>
                       <?php   //<td><input type="text" value="0" id="hid_ids" name="hid_ids" /></td>
                       ?>
                   </table>
               </form>



            </center>
        </div>
       </center>
    </body>
</html>
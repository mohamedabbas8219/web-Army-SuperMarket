<!DOCTYPE html>
<html>
<head>
   
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="css/jquery.min.js" type="text/javascript"></script>
<script src="css/bootstrap.min.js" type="text/javascript"></script>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="css/forinsert_products.css" rel="stylesheet" type="text/css"/>
<link href="css/admin_forinsert_products.css" rel="stylesheet" type="text/css"/>
<title></title>
<style>
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
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});

</script>
</head>
<body> 
    <?php
  include_once "./classes.php";
  include_once "./connection.php";
 
  ////////////////////////////////////////////is set 
 ?>
    
    <div id="variables_html" class="variables_html">
        <div>
 <?php
 $products_data_arr=prod_data_to_arr(get_products($conn));
 for($i=1;$i<count($products_data_arr);$i++)
   {
     if(isset($_POST["save$i"]))
     {
      $new_crs_name=$_POST["prod_name$i"] ;
      $new_dept_name=$_POST["type$i"] ;
     // echo $new_crs_name;
      //$crsid=$crs_id2[$i];
      //echo $crs_id2[$i];
      
      if($new_crs_name!=""&&!check_crs_found($conn, $new_crs_name,$new_dept_name))
      {
       if(update_crs($conn,$new_crs_name,$new_dept_name,$crsid))
       {
         $result_upd= 'تم التعديل بنجاح';
       }
       else {
         $result_upd= 'تم التعديل بنجاح';   
       }
      }
      else {
          //$result_upd= 'عفوا لم يتم التعديل ';  
          //if(check_crs_found($conn,$new_crs_name,$new_dept_name))
         // {
            $result_upd="المادة موجودة بالفعل";  
          //}
       }
     }
   }
    for($i=1;$i<count($crs_id2);$i++)
   {
     if(isset($_POST["delete$i"]))
     {
      $crsid=$crs_id2[$i];
      $max_crs_id=max_crs_id($conn)+1;
      if($crsid<$max_crs_id&&$crsid>0)
      {
       if(delete_crs($conn,$crsid))
       {
         $result_upd= 'تم الحذف بنجاح';
        // echo'onclick="if(!confirm("هل تريد حذف المادة")return false;"';
       }
       else {
         $result_upd= 'تم الحذف بنجاح';
       }
      }
      else {
          $result_upd= 'عفوا لم يتم الحذف ';   
       }
     }
   }
   
   if(isset($_POST["add_new_crs"]))
     {
      $new_crs_name=$_POST["new_crs_name"] ;
      $new_dept_name=$_POST["new_dept_name"] ;
      $new_crs_id=max_crs_id()+1;
      if(!(check_crs_found($conn,$new_crs_name,$new_dept_name)))
      {
         //refresh_server($conn);
       if(new_crs($conn,$new_crs_id,$new_crs_name,$new_dept_name))
       {
         $result_upd= 'تمت الاضافة بنجاح';
        }
       else {
          $result_upd= 'تمت الاضافة بنجاح'; 
       }
      }
      else {
//          $result_upd= 'عفوا لم تتم الاضافة';
//          if(check_crs_found($conn,$new_crs_name)==1)
//          {
            $result_upd="المادة موجودة بالفعل";  
          //}
       }
     }
   
    ?>
   </div>
    </div>
   <?php
   function check_crs_found($conn,$crs_name,$new_dept_name)
     {
         $crsname_sql="SELECT count(crs_id) FROM allcourses where crs_name='$crs_name' and v_dept='$new_dept_name'";   
         $crsname_q=mysqli_query($conn,$crsname_sql);
        $crs_name_f=mysqli_fetch_all($crsname_q,MYSQLI_NUM);  // number
        return $crs_name_f[0][0];
        //return 1;
     }
     
  
  //////////////////////////////////////////////////////////////// 
  $all_courses=all_courses($conn);
  $crs_id=$all_courses['crs_ids'];
 $crs_names=$all_courses['all_courses'];
 $all_crsdepts=$all_courses['all_crsdepts'];
 $alldepts=$all_courses['alldepts'];
  ?>  
    
    
    
<center>
     
     <div style=" margin:auto; position: fixed; top:0;  font-family: -apple-system, BlinkMacSystemFont, 
          'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 
          'Segoe UI Symbol';">
  
   <table  style="position: fixed; margin-top: 0px;width:100%; border:2px #008dde solid;"  id="table">
   <tr>
    <th colspan="4"> اضافة المواد بالكلية</th>
  </tr>
   <tr>
 <th style="width:8%;">م</th>
   <th style="width:25%;"> إسم المادة</th>
   <th style="width:20%;"> القسم</th>
   <th>
      
   </th>
 </tr>
  <form method='post'>
      <tr style='background-color:#f2f2f2;'>
          <td><center><b>+</b></center></td>
          <td>
          <center><input type='text' id='h1' style='color:black;' required
                            placeholder="مادة جديدة"  data-toggle="popover" data-trigger="hover" data-content="أكتب المادة هنا واضغط اضافة" 
                             name='new_crs_name' value=''></center>
          </td>
          <td>
          <center>
              <select name="new_dept_name"  data-toggle="popover" data-trigger="hover" data-content="إختر القسم" >
                  
                  <?php
                  for($i=0;$i<count($alldepts);$i++)
                  {
                      echo "
                       <option>$alldepts[$i]</option>
                     ";
                  }
                ?>
              </select>
              </center>
          </td>
          <td>
      <center>
          <input type='submit' name='add_new_crs' data-toggle='popover'
                 data-trigger='hover' data-content='إضغط لاضافة المادة' id='h4'
                 value='&nbsp; إضافة المادة &nbsp;&nbsp;' />
     <input type='submit' name='cancel_new_crs'
            data-toggle="popover" data-trigger="hover" data-content="إلغاء الاضافة" id='h4' value='إلغاء الاضافة' />
     
   </center>
   </td>
  </tr> 
 </form>
 
   </table>
   </div>
     
    
    
    <table id="table" style=" position: fixed; width: 100%; top:121px;">
      <tr>
 <th style="width:8%;">م</th>
   <th style="width:25%;"> إسم المادة</th>
   <th style="width:20%;"> القسم</th>
   <th>
      
        <form method="post" action="">
               <input type='submit' style=" margin-bottom: 0px; margin-top: -100px; font-weight: bold; color: white;"
                     id="h4" value='  تحديث  '/> &nbsp;&nbsp;&nbsp;
            <b style="font-weight: bold; ">    <?php echo "$result_upd"; ?></b>
     </form>
   </th>
 </tr>
                   
     </table> 

     <hr />
  
     <table style="margin-top: 144px; width:100%;"  id="table">
 <?php
 $c3=0;
   for ($i=count($crs_names)-1;$i>0;$i--)
   {
     $c3++;  
   echo "
     <form method='post'>
       ";
   if($i%2!=0)
   {
   echo "<tr style='background-color: #f2f2f2;'>";
   }
   else {echo "<tr>";}
   //$crs_id[$i]
    echo "
         <td style='width:8%;'>
  	   <center><b name='$crs_id[$i]'>$c3</b></center>
  	</td>
  	<td style='align:center; font-weight:bold; width:25%;'>
        <center>
        <input type='text' id='h1' style='color:black;' name='crs_name$i' value='$crs_names[$i]' required
             data-toggle='popover' data-trigger='hover' data-content='تعديل المادة' ></center>
  	</td>
         <td style='width:20%;'>
         <center>
              <select name='dept_name$i'  data-toggle='popover' data-trigger='hover' data-content='إختر القسم' >
                 
         ";
        
                  for($j=0;$j<count($alldepts);$j++)
                  {
                      if($alldepts[$j]==$all_crsdepts[$i])
                      {
                      echo "<option selected value='$alldepts[$j]'>$alldepts[$j]</option> ";
                      }
                       else 
                           {
                            echo "<option value='$alldepts[$j]'>$alldepts[$j]</option> ";
                           }
                  }
    echo "
        
      </select>
      </center>
      </td>
       <td>
<center>
 <input type='submit' name='save$i' data-toggle='popover' data-trigger='hover' data-content='إضغط لحفظ التعديلات'  id='h4' value='حفظ التعديلات ' />
 <input type='submit' name='' data-toggle='popover' data-trigger='hover' data-content='إضغط لالغاء التعديلات' id='h4' value='إلغاء' />
 ";
    ?>
 <button type='submit' onclick="if (!confirm('  حذف المادة يحذف اي تخصيص للدكاترة لهااو اي استخدام لها\n هل تريد حذف هذه المادة !'))return false;"  name='<?php echo"delete$i";?>' data-toggle='popover' data-trigger='hover' data-content='إضغط لحذف هذه الماد\n ة' id='h4'> حذف</button>
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





     <!-- ############### الاصناف المرشحة#########--> 
                <fieldset>
                    <div class="title">الاصناف المرشحة</div>
                    <table id="predicted">
                        <tr></tr>
                    </table>
                </fieldset>    
    <!-- ####################################### -->    
    
    
    
    
    
    
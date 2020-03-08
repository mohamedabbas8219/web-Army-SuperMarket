<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css_admin/test.css">
  <link href="css/admin.css" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" href="css_admin/bootstrap.min.css">
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
    require 'connection.php';
require 'classes.php';
$_SESSION['page_abbrev'] = 'st_p';
//require 'check_sess_user.php';
 
$x=new emp();
$u=$x->users_data($conn);
$emps_count= count($u);
$objects=array();
for($i=0;$i< count($u);$i++){
    $objects[$i]="obj$i";
}
for($i=0;$i< count($u);$i++){
  $objects[$i]=new emp();
  $objects[$i]->set_data($u[$i][0], $u[$i][1], $u[$i][2], $u[$i][3], $u[$i][4], $u[$i][5]) ;
}
  ?>
    <div id="variables_html" class="variables_html">
        <div>
 <?php
  $result_upd="";
 for($i=0;$i<$emps_count;$i++)
   {
     $ii=$i-1;
     if(isset($_POST["save$i"]))
     {
      $empid=$objects[$i]->id;
      $full_name=$_POST["full_name$i"] ;
      $user_name=$_POST["user_name$i"] ;
      $password=$_POST["password$i"] ;
      $periority=$_POST["periority$i"] ;
      if($user_name!=""&&$full_name!=""&&!check_emp_found($conn, $user_name,$empid))
      {
       if(update_emp_data($conn,$empid, $full_name, $user_name, $password,$periority) )
       {
         $result_upd= 'تم التعديل بنجاح';
       }
       else {
         $result_upd= 'تم التعديل بنجاح';   
       }
      }
      else {
          $result_upd="المادة موجودة بالفعل";  
          }
     }
   }

for($i=0;$i<$emps_count;$i++)
   {
     if(isset($_POST["delete$i"]))
     {
      $empid=$objects[$i]->id;
     if(delete_emp($conn,$empid))
       {
         $result_upd= 'تم الحذف بنجاح';
       }
       else {
          $result_upd= 'عفوا لم يتم الحذف ';   
       }
      }
     }
   
   
   if(isset($_POST["add_new_emp"]))
     {
       $new_full_name=$_POST["new_full_name"] ;
     $new_user_name=$_POST["new_user_name"] ;
     $new_password=$_POST["new_password"] ;
     $new_periority=$_POST["new_periority"] ;
      //$new_emp_id=max_emp_id($conn)+1;
      if(!(check_emp_found($conn,$new_user_name,0)))
      {
       if(new_emp($conn,$new_full_name,$new_user_name,$new_password,$new_periority))
       {
         $result_upd= 'تمت الاضافة بنجاح';
        }
       else {
          $result_upd= 'تمت الاضافة بنجاح'; 
       }
      }
      else {
            $result_upd="الموظف موجود بالفعل";
       }
     }
     $x2=new emp();
     $u2=$x2->users_data($conn);
$emps_count2= count($u2);
$objects2=array();
for($i=0;$i< count($u2);$i++){
    $objects2[$i]="obj$i";
}
for($i=0;$i< count($u2);$i++){
  $objects2[$i]=new emp();
  $objects2[$i]->set_data($u2[$i][0], $u2[$i][1], $u2[$i][2], $u2[$i][3], $u2[$i][4], $u2[$i][5]) ;
}
  
    ?>
   </div>
    </div>
   
    
<center>
     
     <div style=" margin:auto; position: fixed; top:0;  font-family: -apple-system, BlinkMacSystemFont, 
          'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 
          'Segoe UI Symbol';">
  
   <table  style="position: fixed; margin-top: 0px;width:100%; border:2px #008dde solid;"  id="table">
   <tr>
       <th colspan="6" style="font-size:22px;"> سجل الموظفين </th>
  </tr>
   <tr>
 <th style="width:5%;">م</th>
   <th style="width:20%;"> إسم الموظف ثلاثيا</th>
   <th style="width:20%;">اسم المستخدم </th>
   <th style="width:15%;">الرقم السري </th>
   <th style="width:10%;">الاولوية </th>
   <th>
   </th>
 </tr>
  
      <tr style='background-color:#f2f2f2;'>
      <form method='post' action="">    
          <td><center><b>إضافة</b></center></td>
          <td>
          <center><input type='text' id='h1' style='color:black; width:99%;' required
                            placeholder="الاسم ثلاثيا"  data-toggle="popover" data-trigger="hover" data-content="الاسم بالكامل" 
                             name='new_full_name' value='' /></center>
          </td>
          <td>
          <center>
             <input type='text' id='h1' style='color:black; width:99%;' required
                   placeholder="اسم المستخدم"  data-toggle="popover" data-trigger="hover" data-content="اسم المستخدم" 
                             name='new_user_name' value='' />
            </center>
          </td>
          <td>
          <center>
             <input type='text' id='h1' style='color:black; width:99%;' required
                   placeholder="الرقم السري"  data-toggle="popover" data-trigger="hover" data-content="الرقم السري" 
                             name='new_password' value='' />
            </center>
          </td>
          <td>
          <center>
              <select name='new_periority' style='text-align:center; font-weight:bold; font-size:20px; width:90%;'  data-toggle='popover' data-trigger='hover' data-content='إختر الاولوية' > ";
                  <option selected value='1'>1</option>
                  <option value='2'>2</option>
                  <option value='3'>3</option>
            </select></center>
          </td>
          <td>
      <center>
          <input type='submit' name='add_new_emp' data-toggle='popover'
                 data-trigger='hover' data-content=' إضافة موظف جديد' id='h4'
                 value='&nbsp; إضافة موظف &nbsp;&nbsp;' />
     <input type='submit' name='cancel_new_emp'
            data-toggle="popover" data-trigger="hover" data-content="إلغاء الاضافة" id='h4' value='إلغاء ' />
     
   </center>
   </td>
      </form>
  </tr> 
   </table>
   </div>
     
    <table id="table" style=" position: fixed; width: 100%; top:131px;">
      <tr>
 <th style="width:5%;">م</th>
   <th style="width:20%;"> إسم الموظف ثلاثيا</th>
   <th style="width:20%;">اسم المستخدم </th>
   <th style="width:15%;">الرقم السري </th>
   <th style="width:10%;">الاولوية </th>
   <th>
        <form method="post" action="">
               <input type='submit' style=" margin-bottom: 0px; margin-top: -100px; font-weight: bold; color: white;"
                     id="h4" value='Refresh  '/> &nbsp;&nbsp;&nbsp;
            <b style="font-weight: bold; ">    <?php echo "$result_upd"; ?></b>
     </form>
   </th>
 </tr>             
     </table> 
     <hr />
     <table style="margin-top: 153px; width:100%;"  id="table">
 <?php
 $c3=0;
   for ($i=count($u2)-1;$i>=0;$i--)
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
   //$emp_id[$i]
    echo "
         <td style='width:5%;'>
  	   <center><b name='".$objects2[$i]->id."'>".$objects2[$i]->id."</b></center>
  	</td>
  	<td style='align:center; font-weight:bold; width:20%;'>
        <center>
        <input type='text' id='h1' style='color:black; width:99%;' name='full_name$i' value='".$objects2[$i]->full_name."' required
             data-toggle='popover' data-trigger='hover' data-content='تعديل الاسم' ></center>
  	</td>
  	<td style='align:center; font-weight:bold; width:20%;'>
        <center>
        <input type='text' id='h1' style='color:black; width:99%;' name='user_name$i' value='".$objects2[$i]->user_name."' required
             data-toggle='popover' data-trigger='hover' data-content='user name' ></center>
  	</td>
  	<td style='align:center; font-weight:bold; width:15%;'>
        <center>
        <input type='text' id='h1' style='color:black; width:99%;' name='password$i' value='".$objects2[$i]->password."' required
             data-toggle='popover' data-trigger='hover' data-content='password' ></center>
  	</td>
         <td style='width:10%; text-align:center;'>
             <center>
              <select name='periority$i' style='text-align:center; font-weight:bold; font-size:20px; width:90%;'  data-toggle='popover' data-trigger='hover' data-content='إختر الاولوية' > ";
        for($j=1;$j<4;$j++)
                  {
                      if($objects2[$i]->periority==$j)
                      {
                      echo "<option selected value='$j'>$j</option> ";
                      }
                       else 
                           {
                            echo "<option value='$j'>$j</option> ";
                           }
                  }
    echo "
      </select>
      </center>
      </td>
       <td>
<center>
 <input type='submit' name='save$i' data-toggle='popover' data-trigger='hover' data-content='إضغط لحفظ التعديلات'  id='h4' value='حفظ  ' /> ";
    ?>
 <button type='submit' onclick="if (!confirm('  هل تريد حذف هذا الموظف !'))return false;"  name='<?php echo"delete$i";?>' data-toggle='popover' data-trigger='hover' data-content='إضغط لحذف هذه المادة' id='h4'> حذف الموظف </button>
 <button type='submit' onclick="window.open('employee_privileges.php?action=fill&id=<?php echo $objects2[$i]->id; ?>', '_self')" name='privileges' data-toggle='popover' data-trigger='hover' data-content='صلاحيات الموظف' id='h4'> 
     <a href="employee_privileges.php?action=fill&id=<?php echo $objects2[$i]->id; ?>" style="color: white;" >الصلاحيات</a> </button>
 
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
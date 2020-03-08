<?php
session_start();
require 'connection.php';
require 'classes.php';
$_SESSION['page_abbrev']='st_privs';
require 'check_sess_user.php';

$products_data_arr = array();
$emp_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$emp_id) {
    $emp_id = 0;
}
$done=0;
$msg_prev='';
$abbrev_nums = array('no' => '0', 'all' => '1', 'st_p' => '2', 'st_e' => '3', 'st_privs' => '4', 'sell' => '5', 'bill' => '6', 'i_vx' => '7',
    'i_d' => '8', 'i_m' => '9', 'i_inc' => '10', 'i_lk' => '11', 'i_so' => '12');
$abbrev_nums2=array("revoke_all"=>0,"provide_all"=>1,"add_prods"=>2,"add_emps"=>3,"privileges"=>4,"sell"=>5,"bills"=>6,"inv_pages"=>7,"i_d"=>8,"i_m"=>9,"i_inc"=>10,"i_lk"=>11,"i_so"=>12);

$abbrev_keys=array('0'=>'revoke_all','1'=>'provide_all','2'=>'add_prods','3'=>'add_emps','4'=>'privileges',
     '5'=>'sell','6'=>'bills','7'=>'inv_pages','8'=>'i_d','9'=>'i_m','10'=>'i_inc','11'=>'i_lk','12'=>'i_so');
 
 //echo 'abbrev_nums2=array(';
foreach ($abbrev_keys as $key => $value) {
   // echo '"'.$value.'"=>'.$key.',';
}
$revoke_all=$provide_all=$add_prods=$add_emps=$privileges=$sell=$bills=$inv_pages=$i_d=$i_m=$i_inc=$i_lk=$i_so=0;
$sett_all=0;

if (isset($_POST['save'])) { 
            $remain_abbrev_keys=array('0'=>'add_prods','1'=>'add_emps','2'=>'privileges',
     '3'=>'sell','4'=>'bills','5'=>'i_d','6'=>'i_m','7'=>'i_inc','8'=>'i_lk','9'=>'i_so');
             
            $result_save=array();
            $sett_all=$revoke_all=$provide_all=$add_prods=$add_emps=$privileges=$sell=$bills=$inv_pages=$i_d=$i_m=$i_inc=$i_lk=$i_so=1;
            if(isset($_POST['provide_all'])||(isset($_POST['sett_all'])&&isset($_POST['sell'])&&isset($_POST['bills'])&&isset($_POST['inv_pages']))){
               // $provide_all=1;
                $result_save[0]=1;
                $revoke_all=$add_prods=$add_emps=$privileges=$sell=$bills=$inv_pages=$i_d=$i_m=$i_inc=$i_lk=$i_so=0;
            }
            elseif (isset($_POST['revoke_all'])) {
                //$revoke_all=1;
                $result_save[0]=0;
                $provide_all=$add_prods=$add_emps=$privileges=$sell=$bills=$inv_pages=$i_d=$i_m=$i_inc=$i_lk=$i_so=1;
            }
           else{ if (isset($_POST['inv_pages'])) {
                $inv_pages=1;
                $result_save[0]=7;
                $i_d=$i_m=$i_inc=$i_lk=$i_so=0;
            }
            if(isset($_POST['sett_all'])){
                //$sett_all=1;
                $result_save[count($result_save)]=2;
                $result_save[count($result_save)]=3;
                $result_save[count($result_save)]=4;
                $add_prods=$add_emps=$privileges=0;
            }
            foreach ($remain_abbrev_keys as $key => $value) {
               if($$value){
                   if(isset($_POST["$value"])){
                        $result_save[count($result_save)]=$abbrev_nums2["$value"];
                   }
               }
            }
           }
            $result_save_str= implode(',', $result_save);
            if(update_emp_privileges($conn, $result_save_str, $emp_id)){
            $msg_prev= "<center> <p id='p' style='color: green; font-size: 22px; width:98%;text-align:center;'>تم تعديل الصلاحيات بنجاح</p></center>";
            $done=1;
            }
            else{
              $msg_prev= "<center> <p id='p' style='color: brown; font-size: 22px; width:98%;text-align:center;'> عفوا لم يتم التعديل </p></center>"; 
              $done=2;  
            }
              $revoke_all=$provide_all=$add_prods=$add_emps=$privileges=$sell=$bills=$inv_pages=$i_d=$i_m=$i_inc=$i_lk=$i_so=0;
              $sett_all=0;
              
              
              
            }
 
            
  $obj = new emp();
$emp_data = $obj->emp_name_privileges($conn, $emp_id);
$emp_full_name = $emp_data[0];
$emp_privs_arr = $emp_data[1];
$emp_privs_arr_srch=array(1234);
foreach ($emp_privs_arr as $key => $value) {
    $emp_privs_arr_srch[$key+1]=$value;
}
//groups
if(array_search(1,$emp_privs_arr_srch)){
   $sett_all=$provide_all=$add_prods=$add_emps=$privileges=$sell=$bills=$inv_pages=$i_d=$i_m=$i_inc=$i_lk=$i_so=1;
}
elseif(array_search(7,$emp_privs_arr_srch)){
  $inv_pages=$i_d=$i_m=$i_inc=$i_lk=$i_so=1;  
}
 else if(array_search(0,$emp_privs_arr_srch)){
     $provide_all=$add_prods=$add_emps=$privileges=$sell=$bills=$inv_pages=$i_d=$i_m=$i_inc=$i_lk=$i_so=0;
     $revoke_all=1;
 }
 else{}
 if($add_prods&&$add_emps&&$privileges){
     $sett_all=1;
 }
foreach ($emp_privs_arr as $key => $value) {
    $$abbrev_keys["$value"]=1;    
}   
if($add_prods&&$add_emps&&$privileges&&$sell&&$bills&&$inv_pages&&$i_d&&$i_m&&$i_inc&&$i_lk&&$i_so){
   $provide_all=1;
}
if($add_prods&&$add_emps&&$privileges){
    $sett_all=1;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <script src="scripts/functions.js" type="text/javascript"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="css/jquery.min.js" type="text/javascript"></script>
        <script src="css/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="scripts/check_box.js" type="text/javascript"></script>
        <style>
            *{
                background-image: url('images/sky.jpg');
                background-size: cover;
            }
            .center{text-align: center;}
            #priv_tbl{
                width:100%; font-size: 22px; font-weight: bold;
                direction:rtl; color: #110000;
                border: 3px solid #d9d6e2 ;
                
               <?php if($done==1){echo 'border-bottom-color: green; border-bottom-width: 5px;';}
               else if($done==2){echo 'border-bottom-color: brown;';}?>
                
            }
            #priv_tbl tr td:first-child{width:8%;}

        </style>

        <style>
            /* The container */
            .container2 {
                display: block;
                position: relative;
                padding-right: 0px;
                margin-right: -10px;
                margin-bottom: 22px;
                color: black;
                cursor: pointer;
                font-size: 22px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            /* Hide the browser's default checkbox */
            .container2 input {
                position: absolute;
                opacity: 0;
                cursor: pointer;
                height: 0;
                width: 0;
                
            }
            /* Create a custom checkbox */
            .checkmark2 {
                position: absolute;
                top: 0;
                left: 0;
                height: 25px;
                width: 30px;
                background-color: #ccc;
                border: 1px solid #410000;
                border-radius: 5px;
                color: black;   
            }

            /* On mouse-over, add a grey background color */
            .container2:hover input ~ .checkmark2 {
                background-color: #ccc;
            }
            /* When the checkbox is checked, add a blue background */
            .container2 input:checked ~ .checkmark2 {
                background-color: #ccc;
                border: 1px solid #410000;
                border-radius: 5px;
                color: black;
            }
            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark2:after {
                content: "";
                position: absolute;
                display: none;
            }
            /* Show the checkmark when checked */
            .container2 input:checked ~ .checkmark2:after {
                display: block;
            }
            /* Style the checkmark/indicator */
            .container2 .checkmark2:after {
                left: 9px;
                top: 5px;
                width: 8px;
                height: 15px;
                border: solid black;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }
        </style>
        <script>
            $(document).ready(function () {
                $('[data-toggle="popover"]').popover();
            });

        </script>
    </head>
    <body>
        <?php
      
        ?>
      
    <center> <h1 class="text-center" style="color: #1b5215; margin-top: -2px;"><?php echo "صلاحيات الموظف"; ?></h1>
        <form class="login" style="width: 60%;" method="post" enctype="multipart/form-data">
            <table id="priv_tbl">
                <tr>
                    <td style="width:70%;" colspan="2" class="text-center">إسم الموظف :</td>
                    <td style="" colspan="2" class="text-center"><b  style="color: #410000;">&nbsp;&nbsp;<?php echo "$emp_full_name"; ?>&nbsp;&nbsp;</b></td>
                </tr>
                <tr >
                    <th colspan="4" class="text-center" style="color: #410000; font-weight: bold;" >إختيار الصلاحيات</th>
                </tr>
                <tr>
                    <td colspan="">
                         <label class="container2">
                             <input type="checkbox" name="provide_all" id="provide_all" onclick="provide_all1()"
 <?php if($provide_all){echo 'checked="checked"';} ?> >
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td  style="font-size: 22px; color: #410000;" >&nbsp;&nbsp;&nbsp; إعطاء  كل الصلاحيات </td> 
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td style="" class="text-center">
                <label class="container2">
                    <input type="checkbox" name="sett_all" id="sett_all" onclick="sett_all1()" <?php if($sett_all){echo 'checked="checked"';} ?>>
                            <span class="checkmark2"></span>
                </label>
                    </td>
                    <td style="width:40%; font-size: 22px; color: #410000;">&nbsp;&nbsp;&nbsp; الاعدادات و الإضافة</td>
                    <td style="" colspan="2"></td>
                </tr>
                <tr>
                    <td class="text-center">
                    <label class="container2">
                        <input type="checkbox" name="add_prods" id="add_prods" onclick="sett_all2()" <?php if($add_prods){echo 'checked="checked"';} ?> >
                            <span class="checkmark2"></span>
                    </label>
                    </td>
                    <td style="width:40%;">&nbsp;&nbsp;&nbsp;  إضافة المنتجات </td>
                    <td style="width:8%;"class="text-center">
                        <label class="container2">
                            <input type="checkbox" name="add_emps" id="add_emps" onclick="sett_all2()"  <?php if($add_emps){echo 'checked="checked"';} ?> >
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td >&nbsp;&nbsp;&nbsp;  إضافة الموظفين </td>
                </tr>
                <tr>
                   <td class="text-center">
                        <label class="container2">
                            <input type="checkbox" name="privileges" id="privileges" onclick="sett_all2(),provide_all1()" <?php if($privileges){echo 'checked="checked"';} ?> >
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td style="">&nbsp;&nbsp;&nbsp;  تعديل الصلاحيات  </td>
                    <td style="width:8%;"class="text-center">
                        <label class="container2">
                            <input type="checkbox" name="" >
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td ></td>
                </tr>
                <tr><td colspan="4" style="color: #410000;">&nbsp;&nbsp;&nbsp;صفحات عرض المنتجات والاسعار والفواتير</td></tr>
                <tr>
                    <td class="text-center">
                        <label class="container2">
                            <input type="checkbox" name="sell" id="sell" onclick="provide_all2()" <?php if($sell){echo 'checked="checked"';} ?>>
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td style="width:40%;">&nbsp;&nbsp;&nbsp;  عرض و بيع المنتجات </td>
                   <td style="width:8%;"class="text-center">
                        <label class="container2">
                            <input type="checkbox" name="bills" id="bills" onclick="provide_all2()" <?php if($bills){echo 'checked="checked"';} ?> >
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td >&nbsp;&nbsp;&nbsp;  عرض  الفواتير </td>
                </tr>
                <tr>
                    <td style="" class="text-center">
                <label class="container2">
                    <input type="checkbox" name="inv_pages" id="inv_pages" onclick="inventory1()" <?php if($inv_pages){echo 'checked="checked"';} ?> >
                            <span class="checkmark2"></span>
                </label>
                    </td>
                    <td style="width:40%; font-size: 22px; color: #410000;">&nbsp;&nbsp;&nbsp;  صفحات الجرد </td>
                    <td style="" colspan="2"></td>
                </tr>
                <tr>
                    <td class="text-center">
                    <label class="container2">
                        <input type="checkbox" name="i_d" id="i_d"  onclick="inventory2()" <?php if($i_d){echo 'checked="checked"';} ?> >
                            <span class="checkmark2"></span>
                    </label>
                    </td>
                    <td style="width:40%;">&nbsp;&nbsp;&nbsp;  الجرد اليومي  </td>
                    <td style="width:8%;"class="text-center">
                        <label class="container2">
                            <input type="checkbox" name="i_m" id="i_m" onclick="inventory2()" <?php if($i_m){echo 'checked="checked"';} ?> >
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td >&nbsp;&nbsp;&nbsp;  الجرد الشهري  </td>
                </tr>
                <tr>
                   <td class="text-center">
                        <label class="container2">
                            <input type="checkbox" name="i_so" id="i_so" onclick="inventory2()" <?php if($i_so){echo 'checked="checked"';} ?>>
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td style="">&nbsp;&nbsp;&nbsp;  مبيعات الاشهر  </td>
                    <td style="width:8%;"class="text-center">
                        <label class="container2">
                            <input type="checkbox" name="i_inc" id="i_inc" onclick="inventory2()" <?php if($i_inc){echo 'checked="checked"';} ?>>
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td style="">&nbsp;&nbsp;&nbsp;  الزيادة الشهرية   </td>
                </tr>
                <tr>
                   <td class="text-center">
                        <label class="container2">
                            <input type="checkbox" name="i_lk" id="i_lk" onclick="inventory2()" <?php if($i_lk){echo 'checked="checked"';} ?> >
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td style="">&nbsp;&nbsp;&nbsp;  العجز الشهري   </td>
                    <td style="width:8%;"class="text-center">
                        <label class="container2">
                            <input type="checkbox" name="" >
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td style="">&nbsp;&nbsp;&nbsp;      </td>
                </tr>
                <tr>
                    <td colspan="">
                         <label class="container2">
                             <input type="checkbox" name="revoke_all" onclick="revoke_all1()" id="revoke_all" <?php if($revoke_all){echo 'checked="checked"';} ?> >
                            <span class="checkmark2"></span>
                        </label>
                    </td>
                    <td  colspan="" class="text-center" style="font-size: 22px; color: #410000;" > الحرمان من كل الصلاحيات </td> 
                    <td colspan="2"></td>
                </tr>
            </table>

            <input class="btn btn-primary btn-block input-lg" value="حفظ المنتج" 
                   style="margin-top: 5px; font-size: 22px;" type="submit" name="save" /> 
            <?php echo $msg_prev;?>
        </form>        
    </center>
    <button id='h4' style="position: fixed; top: 1px; right:2px; "
            onclick="window.open('employee_privileges.php?id=<?php echo $emp_id; ?>', '_self')"> 
        <a style='color:#293f5a; font-size: 20px; font-weight: bold;' href="#">refresh</a> 
    </button>

</body>
</html>

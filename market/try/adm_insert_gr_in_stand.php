<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css_admin/test.css">
	<link rel="stylesheet" href="css_admin/admin.css">
	<link rel="stylesheet" href="css_admin/bootstrap.min.css">
        
        <meta charset="utf-8">
	<title></title>
        
        
		 
</head>
<body>
<center>
<?php
 $br='<br />';
$conn = new mysqli("localhost", "root","", "mytables");
 mysqli_set_charset($conn,"utf8");
 if ($conn->connect_error) 
  {
   die("Connection failed: " . $conn->connect_error);
  } 
  
  ?>
    <div style="margin-bottom:-1px; margin-top: 2px;"> 
       <center>
           <form action="" method="post" name="stands_btn" dir="rtl">
    <?php
    $stands=all_stands($conn);
  //echo "Stands : ";
  
    ?>
     </form>
     </center>
  </div>  
  
  <?php
   ///////////////////////////////////////////              all groups
  //$stand='مدرج1';
 $count_stands=count($stands);
for($s=1;$s<=$count_stands;$s++)
{
 if(isset($_POST["stand$s"]))
  {
     $stand="مدرج$s";
     $update_stand_q = "UPDATE admin_modi_states SET current_stand='$stand' where adm_id=1";
      $conn->query($update_stand_q);
   }
}
// if($stand=="مدرج1")
//{
//$stand=get_stand($conn);
//}
$stand=filter_input(INPUT_GET, 'stand_name',  FILTER_SANITIZE_STRING);
//echo $stand;


function get_stand($conn)
{
 $c_stand_sql="SELECT current_stand FROM admin_modi_states where adm_id=1";   
 $c_stand_q=mysqli_query($conn,$c_stand_sql);
 $c_stand_f=mysqli_fetch_all($c_stand_q,MYSQLI_NUM);
 $c_stand=$c_stand_f[0][0];
 return $c_stand;
}
  
function all_stands($conn)
{
          $stand_sql="SELECT distinct stand FROM showtables";   
           $stand_q=mysqli_query($conn,$stand_sql);
           $stand_f= mysqli_fetch_all($stand_q,MYSQLI_NUM);
            
            
            $stands_c_sql="SELECT count(distinct stand) FROM showtables";   
            $stands_c_q=mysqli_query($conn,$stands_c_sql);
           $stands_c_f= mysqli_fetch_all($stands_c_q,MYSQLI_NUM);
            $stands_count=$stands_c_f[0][0];  
            
            $stands=array();
            for($i=0;$i<$stands_count;$i++)
            {
              $stands[$i]= $stand_f[$i][0]; 
            }
            return $stands; 
}
 
//$stands=all_stands($conn);
  ////////////////        is set  
 
  $all_groups_depts2=all_groups_f($conn);
  $all_gr_d_ids2=$all_groups_depts2['all_gr_d_ids'];                      //  3  
  $stand_groups_depts2=stand_g_dpts($conn,$stand);  
  $doc_c_ids_stand2=$stand_groups_depts2['doc_c_ids_stand'];              //  2
  $full_groups_depts2=$all_groups_depts2['fullgroupname'];               //  1
  
   try
       { $modi_groups=array();
           $modi_g_ids=array();
           $result="";
           $redundant_groups_day2=ch_max_group_day($conn);
            $max_redun_gr_day2=2;    
            $max_gr_c_day=$max_redun_gr_day2;     //   اقصي عدد للفرقة في اليوم     
           if(isset($_POST['save']))
           {
              for($i=0;$i<36;$i++)
             {
              $modi_groups[$i]=$_POST["cell$i"];
              }
             // echo '$modi_groups : '. $modi_groups[1];
             for($i=0;$i< count($modi_groups);$i++)
             {
                                   //////   لو بتساوي اللي داخلة امسح وضيف
                  for($f=0;$f< count($full_groups_depts2);$f++)
                {
                 if($modi_groups[$i]==$full_groups_depts2[$f])
                 {
                    // update_group_in_stand($conn,$stand,$doc_c_ids_stand2[$i],$all_gr_d_ids2[$f]);
                     if(update_group_in_stand($conn,$stand,$doc_c_ids_stand2[$i],$all_gr_d_ids2[$f],$max_gr_c_day))
                      {
                       $result="تم التعديل بنجاح ";  
                      }
                   
                   else{
                      
                       $result="غير مسموح بأكثر من فرقتين في اليوم ";}
                 }
                }
                 if($modi_groups[$i]=="_")
                 {
                     $cell_crs_group_data=cell_crs_group_data($conn,$stand,$doc_c_ids_stand2[$i]);
                    $c_data=$cell_crs_group_data['c_data'];
                    $g_data=$cell_crs_group_data['g_data'];
                       //echo 'id : '.$doc_c_ids_stand[$i].'  >>  ';
                      //  echo 'cro : '.$c_data.'  >>  ';
                       // echo 'grs : '.$g_data.$br;
                    if($c_data!=0)
                    {
                    if(free_crs($conn,$g_data,$c_data))
                    {
                         $result="تم التعديل بنجاح ";  
                    }
                      else {$result="عفوا لم يتم الحذف ";}
                    }
                   if(update_group_in_stand($conn,$stand,$doc_c_ids_stand2[$i],0,$max_gr_c_day))
                   {
                       // update_group_in_stand($conn,$stand,$doc_c_ids_stand2[$i],0);
                      $result="تم التعديل بنجاح ";
                   }
                 }
             }
         }
         if(isset($_POST["delete_all"]))
         {
             empty_full_stand($conn,$stand);
         }
       } 
       catch (Exception $ex)
       {
         echo 'Sorry , Something go wrong in Your prcess';
       }
  
  
  
  function all_groups_f($conn)
{
    $all_groups=array(); 
    $all_depts=array();
    $all_gr_d_ids=array();
   
    
    
    $count_sql="SELECT count(st_group) FROM s_groups where group_id >0";
  $count_q=mysqli_query($conn,$count_sql);
  $count_f=mysqli_fetch_all($count_q,MYSQLI_NUM);
   $count=$count_f[0][0];
    
   
   $c3=0;
 $groupsids_sql="SELECT group_id FROM s_groups where group_id>0";  
  $result = $conn->query($groupsids_sql);
if ($result->num_rows>0) {
     while($row = $result->fetch_assoc()) {
       $all_gr_d_ids[$c3]=$row["group_id"];
       $c3++;
     }
   }
 
              /////////////////////////// array
  for($i=0,$ii=$count;$i<$ii;$i++)
  {
    // $all_gr_d_ids[$i]=$groupsids_f[$i][0];
   }
   $groupsdept_sql="SELECT dept FROM s_groups where group_id>0";
  $groupsdept_q=mysqli_query($conn,$groupsdept_sql);
  $deptsname_f=mysqli_fetch_all($groupsdept_q,MYSQLI_NUM);
  
  $groupsname_sql="SELECT st_group FROM s_groups where group_id >0";
  $groupsname_q=mysqli_query($conn,$groupsname_sql);
  $groupsname_f=mysqli_fetch_all($groupsname_q,MYSQLI_NUM);
   
   $fullgroupname=array();
  for($i=0,$ii= $count;$i<$ii;$i++)
  {
   // $all_gr_d_ids=$groupsids_f[$i][0];
   $all_depts[$i]= $deptsname_f[$i][0];
   $all_groups[$i]=$groupsname_f[$i][0];
   $fullgroupname[$i]=$all_groups[$i].' - '.$all_depts[$i];
  }
  $all_groups_depts_f=array('all_gr_d_ids'=>$all_gr_d_ids,'all_groups'=>$all_groups,'all_depts'=>$all_depts,'fullgroupname'=>$fullgroupname);
     return $all_groups_depts_f;
}
  
$all_groups_depts=all_groups_f($conn);
$all_gr_d_ids=$all_groups_depts['all_gr_d_ids'];                      //  3
$all_depts=$all_groups_depts['all_depts'];
$all_groups=$all_groups_depts['all_groups'];
$full_groups_depts=$all_groups_depts['fullgroupname'];               //  1
//print_r($all_gr_d_ids);
//echo $br;
//print_r($all_depts);
//echo $br;
for($gg=0;$gg<count($full_groups_depts);$gg++)
{
   // printf($full_groups_depts[$gg]);
   // echo $br;
}

 
function stand_g_dpts($conn,$stand)
{
    $stand_groups=array(); 
  $stand_depts=array();
  $stand_groupsids=array();
  $doc_c_ids=array();
  $groupscount_sql="SELECT count(S_group) FROM showtables where stand='$stand'";   
 $groupscount_q=mysqli_query($conn,$groupscount_sql);
 $groupscount_f=mysqli_fetch_all($groupscount_q,MYSQLI_NUM);
 $groupscount=$groupscount_f[0][0];
  
 
  
  $doc_c_id_sql="SELECT doc_c_id FROM showtables where stand='$stand'";   
 $doc_c_id_q=mysqli_query($conn,$doc_c_id_sql);
 $doc_c_id_f= mysqli_fetch_all($doc_c_id_q,MYSQLI_NUM);
 
  
  $groupsid_sql="SELECT S_group FROM showtables where stand='$stand'";   
 $groupsid_q=mysqli_query($conn,$groupsid_sql);
 $groupsid_f= mysqli_fetch_all($groupsid_q,MYSQLI_NUM);
      //count of groups
 
  for($i=0,$ii=$groupscount;$i<$ii;$i++)
  {
      $doc_c_ids[$i]=$doc_c_id_f[$i][0];
    $stand_groupsids[$i]=$groupsid_f[$i][0];
   }
  //$inc_d=0;
  for($i=0,$ii= count($stand_groupsids) ;$i<$ii;$i++)
  {
  $groupsdept_sql="SELECT dept FROM s_groups where group_id=$stand_groupsids[$i] ";
  $groupsdept_q=mysqli_query($conn,$groupsdept_sql);
  $groupsdept_f=mysqli_fetch_all($groupsdept_q,MYSQLI_NUM);
  
  $groupsname_sql="SELECT st_group FROM s_groups where group_id =$stand_groupsids[$i]";
  $groupsname_q=mysqli_query($conn,$groupsname_sql);
  $groupsname_f=mysqli_fetch_all($groupsname_q,MYSQLI_NUM);
   
  $stand_groups[$i]=$groupsname_f[0][0];
  $stand_depts[$i]=$groupsdept_f[0][0];
  }
  
   $fullgroupname=array();
  for($i=0,$ii= count($stand_groupsids);$i<$ii;$i++)
  {
   $fullgroupname[$i]=$stand_groups[$i].' - '.$stand_depts[$i];
  }
  $all_groups_depts_f=array('doc_c_ids_stand'=>$doc_c_ids,'stand_groupsids'=>$stand_groupsids,'stand_groups'=>$stand_groups,'stand_depts'=>$stand_depts,'fullgroupname'=>$fullgroupname);
     return $all_groups_depts_f;
  
}
  
  $stand_groups_depts=stand_g_dpts($conn,$stand);
  $doc_c_ids_stand=$stand_groups_depts['doc_c_ids_stand'];                //  2
 // print_r($doc_c_ids_stand);
  //echo $br;
  
  $stand_groupsids=$stand_groups_depts['stand_groupsids'];
  $stand_groups=$stand_groups_depts['stand_groups'];
  $stand_depts=$stand_groups_depts['stand_depts'];
 $stand_fullgroupname=$stand_groups_depts['fullgroupname'];
  
   ?>
   
   <?php   
   ///////////////////////////                  is set methods
        function update_group_in_stand($conn,$stand,$doc_c_id_stand,$all_gr_d_id,$max_gr_c_day)
           {
                $result=1;
                 $count_group=1;
                 if($all_gr_d_id!=0)
                 {
                $g_day_sql="SELECT count(doc_c_id) FROM showtables where "
                         . "day=(SELECT day FROM showtables where doc_c_id=$doc_c_id_stand) and S_group=$all_gr_d_id";   
                 $g_day_q=mysqli_query($conn,$g_day_sql);
                  $g_day_f= mysqli_fetch_all($g_day_q,MYSQLI_NUM);
                   $count_group=$g_day_f[0][0];
                 }
                 
                if($count_group<$max_gr_c_day)
                {
                 $upd_table_group_q = "UPDATE showtables SET S_group=$all_gr_d_id , dr_id=0 ,crs_id=0 ,done=0 where stand='$stand' and doc_c_id=$doc_c_id_stand";
                if ($conn->query($upd_table_group_q) === TRUE) 
                {$result= 1;}
                else { $result=0;}
                }
                else{
                  //  $upd_table_group_q = "UPDATE showtables SET S_group=$all_gr_d_id , dr_id=0 ,crs_id=0 ,done=0 where stand='$stand' and doc_c_id=0";
                    // $conn->query($upd_table_group_q);
                    $result=0;}
                return $result;
            }
           
         function cell_crs_group_data($conn,$stand,$doc_c_id_stand)
         {
           $g_data_sql="SELECT S_group FROM showtables where stand='$stand' and doc_c_id=$doc_c_id_stand";   
           $g_data_q=mysqli_query($conn,$g_data_sql);
           $g_data_f= mysqli_fetch_all($g_data_q,MYSQLI_NUM);
           $g_data=$g_data_f[0][0];
           
           $c_data_sql="SELECT crs_id FROM showtables where stand='$stand' and doc_c_id=$doc_c_id_stand";   
           $c_data_q=mysqli_query($conn,$c_data_sql);
           $c_data_f= mysqli_fetch_all($c_data_q,MYSQLI_NUM);
           $c_data=$c_data_f[0][0];
          $cell_crs_g_data=array('g_data'=>$g_data,'c_data'=>$c_data);
            return $cell_crs_g_data;
           }
            
           function free_crs($conn,$gr,$crs)
           {
                $upd_table_group_q = "UPDATE courses_groups SET alocated=0 where s_group=$gr and crs_id=$crs";
                $conn->query($upd_table_group_q) ;
            }
           
            function empty_full_stand($conn,$stand)
            {
                $crs_count_sql="SELECT count(crs_id) FROM showtables where stand='$stand'";   
                $crs_count_q=mysqli_query($conn,$crs_count_sql);
                $crs_count_f=mysqli_fetch_all($crs_count_q,MYSQLI_NUM);  // number
                $crs_count=$crs_count_f[0][0];
                $crs_sql="SELECT crs_id FROM showtables where stand='$stand'";   
                $crs_q=mysqli_query($conn,$crs_sql);
                $crs_f=mysqli_fetch_all($crs_q,MYSQLI_NUM);  //    crs id
                
                $grs_sql="SELECT S_group FROM showtables where stand='$stand'";   
                $grs_q=mysqli_query($conn,$grs_sql);
                $grs_f=mysqli_fetch_all($grs_q,MYSQLI_NUM);  //    crs id
                
                 for($i=0,$ii=$crs_count;$i<$ii;$i++)
                 {
                     $gr=$grs_f[$i][0];
                     $crs=$crs_f[$i][0];
                     $upd_crs_group_q = "UPDATE courses_groups SET alocated=0 where s_group=$gr and crs_id=$crs";
                     $conn->query($upd_crs_group_q) ;
                  }
                  
               $result="";
                 $upd_table_group_q = "UPDATE showtables SET S_group=0 , dr_id=0 ,crs_id=0 ,done=0 where stand='$stand'";
                if ($conn->query($upd_table_group_q) === TRUE) 
                {
                 $result= "تم تفريغ المدرج بنجاح";
                }
                else {
                   $result="خطأ في التعديل : " . $conn->error;
                }
                return $result;  
            }
            
            function redundant_group($conn,$stand,$day,$lec)
            {
             $g_data_sql="SELECT S_group FROM showtables where stand!='$stand' and day=$day and lec=$lec";   
            $g_data_q=mysqli_query($conn,$g_data_sql);
           $g_data_f= mysqli_fetch_all($g_data_q,MYSQLI_NUM);
           $g_data=array();
           $count= count($g_data_f);
           for($i=0;$i<$count;$i++)
           {
               $g_data[$i]=$g_data_f[$i][0];
           }
           return $g_data;
            }
            
              function ch_max_group_day($conn)
                {
       $gr_ids_sql="SELECT group_id FROM s_groups";
       $gr_ids_q=mysqli_query($conn,$gr_ids_sql);
       $gr_ids_f= mysqli_fetch_all($gr_ids_q,MYSQLI_NUM);
       $gr_ids=array();
       $count_group_day=array();
       for($d=1;$d<7;$d++)
       {   
        $count_group=array();   
       for($i=0;$i<count($gr_ids_f);$i++)
           {
        $gr_ids[$i]=$gr_ids_f[$i][0];
       $g_data_sql="SELECT count(S_group) FROM showtables where day=$d and S_group=$gr_ids[$i]";
       $g_data_q=mysqli_query($conn,$g_data_sql);
       $g_data_f= mysqli_fetch_all($g_data_q,MYSQLI_NUM);
       $count_group["$gr_ids[$i]"]=$g_data_f[0][0];
           }
           $count_group_day["$d"]=$count_group;
       }  
       return $count_group_day;

}
$redundant_groups_day=ch_max_group_day($conn);
  $max_redun_gr_day=2;         
     ?> 
      <div id=""> 
           <h3 style='width:99%; color:background; background-color: buttonface; 
              margin-bottom:1px; margin-top:5px; border: 1px; border-radius:3px;'>
               <center> تعبئة الفرق    ب<?php echo $stand; ?></center> </h3>
      </div>
      <div class="ifset_actions" style="color:background; background-color: buttonface;
              margin-bottom: 1px; border: 1px; border-radius:3px;  width:99%; ">
       <center><b style="color:green;"><?php echo $result; ?></b></center> 
       </div>
  
    
    <form method="post" name="table">
    <table style="margin-top: 2px; width:99%; height: 400px; border: groove .5em #8aa5ec;  " id="table">
     <tr class="firsttr">
         <th><center>الايام  </center></th>
    <?php
      for($i=1;$i<7;$i++)
        { echo ' <th class="hhh"><center> المحاضرة  &nbsp;'.($i).'<center></th>';}
        ?>
        </tr>
      
       <?php
        $Days_n=array("السبت","الاحد","الاثنين","الثلاثاء","الاربعاء","الخميس","الجمعة");
        
        $inc2=0;
      for($i=0;$i<6;$i++)
      {
        echo '<th class="hhh" style="width:80px;"><center> '.$Days_n[$i].' </center></th> ';
       for($j=0;$j<6;$j++)
       { 
           $redundants=redundant_group($conn,$stand,$i+1,($j+1));
             echo '<td>';   
             //  echo $stand_groupsids[$inc2]."</br>";
              // foreach ($redundants as $t){ echo $t;}
              
               echo "<center>
              <select name='cell$inc2' id='cell$inc2' style='font-size:15px; font-weight:bold; width:98%;'>
               "; 
                echo " <option name='' value='_' selected>_</option>";
               for($z=0;$z< count($full_groups_depts);$z++)
                {
                  if($stand_groups[$inc2]!="_"&&$stand_depts[$inc2]!="_")
                  {
                     if($all_groups[$z]==$stand_groups[$inc2]&&$all_depts[$z]==$stand_depts[$inc2])
                     {
                         
                       echo " <option name='' selected value='$full_groups_depts[$z]'>$full_groups_depts[$z]</option>";
                     }
                else {
                    $ch=0;
                      $d=$i+1;
                        $cell_gr=$all_gr_d_ids[$z];
                         $redundant_groups_day_ch=$redundant_groups_day["$d"]["$cell_gr"];
                     
                      for($rr=0;$rr<count($redundants);$rr++)
                       {
                           if($redundants[$rr]==$all_gr_d_ids[$z]||$redundant_groups_day_ch>=$max_redun_gr_day)
                           {
                               $ch=1;
                           }
                       }
                           
                       if($ch==0)
                       {
                           echo "<option name='' value='$full_groups_depts[$z]'>$full_groups_depts[$z]</option>";   
                       } 
                       
                     }
                  }
             else {
                  
                      $ch=0;
                        $d=$i+1;
                        $cell_gr=$all_gr_d_ids[$z];
                         $redundant_groups_day_ch=$redundant_groups_day["$d"]["$cell_gr"];
                       if($redundant_groups_day_ch>=$max_redun_gr_day)  // >=2
                           {
                             $ch=1;  
                           }
                       if($ch==0)    
                       {
                      for($rr=0;$rr<count($redundants);$rr++)
                       {
                           if($redundants[$rr]==$all_gr_d_ids[$z])
                           {
                               $ch=1;
                           }
                       }
                      }
                       if($ch==0)
                       {
                           echo "<option name='' value='$full_groups_depts[$z]'>$full_groups_depts[$z]</option>";   
                       } 
                      
                 // echo " <option name='' value='$full_groups_depts[$z]'>$full_groups_depts[$z]</option>";
                  }
               }
                echo ' </select>';
               echo "</center></td> ";
               
            // echo "<td><input type='text' name='cell$inc2' value='' /></td>"; 
           
          $inc2++;
       }
         echo '</tr> ';
       }
       ?>
</table>
<div style="margin-top: 3px;">
 <input type='submit' name='delete_all' id='h4' value='تفريغ الكل' 
        onclick="if (!confirm('تفريغ المدرج يلغي كل تعديلات الدكاترة به \nهل تريد تفريغ المدرج كله')) return false;" />
 <input type='submit' name='cancel' id='h4' value='إظهار التعديلات ' />
<input type='submit' name='save'   id='h4' value='حفظ التعديلات ' />
<br />
 
<input type='button' value="<<  عودة للمدرجات" id='h4' name="back" style="font-weight: bold; width: auto; height: 35px;
       position: fixed; top: -2px; left: 5px;"
 onclick="window.open('adm_add_stand.php','_self')" ></button> 
<!-- <a href="adm_add_stand.php" >
    <img src="back arrow2.png" alt="عودة لصفحة المدرجات" 
     style="height: 35px; width: 80px; position: fixed; top: -2px; left: 5px;" />
</a>-->
</div>
</form> 
</center>
 
 
   </body>
</html>
 <?php
require 'connection.php';
try{
    
if(isset($_POST['submit'])){
   //$_POST['pic']!=NULL
    if(getimagesize($_FILES['pic']['tmp_name'])==FALSE){
        echo 'Please select an image .';
    }
    elseif($_FILES['pic']!=''){
     
    $image= base64_encode(file_get_contents(addslashes($_FILES['pic']['tmp_name'])));     
   $insert="insert into products insert into products (id,product,quantity,price,prod_date,expiry_date,validity,remaining_quantity,image,ptype,discount)
                                                   values(5,'كركاديه',7,10,'2019-01-01','2019-05-03',datediff(expiry_date,prod_date),20,7,'$image','اعشاب',0)";
    if($conn->query($insert)){
        echo " <p style='color: green; font-size: 22px;'>تم التعديل بنجاح</p>";
        //$_FILES['pic']['tmp_name']=NULL;
    }
     else {echo 'cann\'t save !!' ; }
    }
}     
} 
   catch (Exception $ex)
       {
         echo 'Sorry , Something go wrong in Your prcess';
       }

?>
<html dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>نادي ض ق م براس البر </title>
    </head>
    <body>
        <form method="post" action="" enctype="multipart/form-data" >
            <input type="file" name="pic" required="" />
            <input type="submit" name="submit" value="Upload" />
        </form>
        
    </body>
</html>
<?php
//https://www.youtube.com/watch?v=4ZpqQ3j1o2w
$query="SELECT * FROM products ";   
            $get=mysqli_query($conn,$query);
           $result= mysqli_fetch_all($get,MYSQLI_NUM);
          // print_r($result[0]);
           echo count($result);
           for ($i=0;$i<count($result);$i++){
           echo "<img style='width: 300px; height: 300px;' src='data:image;base64,".$result[$i][8]."' />";
           }
           
//https://www.youtube.com/watch?v=PK7GIWopAQY

$conn->close();









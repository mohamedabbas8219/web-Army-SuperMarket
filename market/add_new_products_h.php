
<?php
session_start();
$_SESSION['curr_page']='add_new_products_h.php';
require 'connection.php';
require 'classes.php';
$_SESSION['page_abbrev']='st_p';
require 'check_sess_user.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>نادي ض ق م برأس البر </title>
        <meta charset="UTF-8">
        <script src="js/jquery-3.2.1.min"></script>
        <script src="js/bootstrap.min.js"></script>
        <link href="css_admin/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css_admin/adm.css" rel="stylesheet" type="text/css"/>
        <style>
            .list-group-item{text-align: right; background-color: white; color: #293f5a; font-size: 22px;}
            #m{text-align: right; background-color: white; color: #293f5a; font-size: 22px;}
            #n{text-align: right;}
            #y{text-align: right;}
            #z{text-align: right;}
            #w{text-align: right;}
            #head{background-color: #293f5a; color: white; }

            #selected{
                text-align: right; 
                background-color: #e4e2e2;
                border-width: 2px;border-top-color: #293f5a;border-bottom-color: #293f5a;}
            .h_a{font-size: 1.2em;}
            .s_a{
                font-size: 1.2em;color:white;
                background-color: #293f5a; font-size: 1.6em;  width: 110%;
                padding:5px 5px 9px 5px; text-shadow: 5px 2px 5px gray;
            }
            #m:hover {background-color: #e4e2e2; font-size: 25px; }   
            #selected:hover {background-color: #e4e2e2;}   

        </style>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link href="css/divv.css" rel="stylesheet" type="text/css"/>
        <!--               head          -->
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
        <style>   /*fatora*/  
            #arrays_to_js{display: none;}
            ul li a{margin-top: -3px; width: 103%;}
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
            #hidden_tbl_for_ids{width: 100%; height: auto; background-color:#fafafa; margin-top: 22px; display: none;}
            #hidden_tbl_for_ids tr td{width: 10%; color:blue; font-size: 22px;}
            #x{width:10%; margin-right:0px; background-color: brown; border-radius: 3px; color: whitesmoke; }
            .uris li a{
                height: 142px;
            }

        </style>
    </head>
    <body>
        <div id="wraper" style="background-color: silver; height: 100px;" >
            <a href="bridge_to_login.php"
               style="color: #dddfe2; font-size: 18px; position: fixed; top: -3px;  text-decoration: none;"
               onmouseover="this.style.color = '#960000'" onmouseout="this.style.color = '#dddfe2'">
                <b>   تسجيل الخروج   &nbsp;&nbsp;</b></a>
            <div id="menutop" style="background-color:#293f5a;">
                <center><h2 style="color: white;">ماركت نادي ضباط القوات المسلحة برأس البر</h2></center>
                <div id="topnav" style="width:100%; height: 56px;  background-color:whitesmoke; border-bottom-color:#293f5a;" > 
                    <form name="searchform">
                        <center>
                            <!-- style="border:5px black solid; height:1px; -->
                            <ul class="uris" dir="rtl" style="" >  
                                <li>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>  
                                <li> <a href="#" class="h_a"
                                        style="color:white; background-color: #293f5a; height: 122px; 
                                        padding:5px 5px 9px 5px; text-shadow: 5px 2px 5px gray;">
                                        <b>الإعدادات و الإضافة</b></a> </li>

                                <li><a href="selling.php" class="h_a" style="margin-left: 2px; height: 122px;">
                                        <b>صفحة البيع</b></a></li>
                                        <li><a href="bills_page.php" class="h_a" style="height: 122px;"><b>عرض الفواتير</b></a></li>
                                <li><a href="inventory_day_h.php" class="h_a" style="height: 122px;"> <b>صفحة الجرد</b></a> </li>
                                <li><a href="" class="h_a" style="height: 122px;"> <b>استعلامات</b></a> </li> 
                                <!-- <li><a href="#" ><b style="font-size: 1.5em;">Search Here</b> </a></li> -->
                                <li>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li> 
                                <li><input type="text" maxlength="55" id="myInput" autocomplete="none" autofocus=""
                                           disabled=""   onkeyup="myFunction()" placeholder="...إبحث بإسم المنتج او الصنف"
                                           title="Type in a name" style="font-size: 1.2em; direction: rtl; 
                                           margin-bottom: 12px; height:24px; width:180%;" > 
                                </li>
                            </ul>
                        </center>   
                    </form>  
                </div> 
            </div>
            <div id="menutop" style="background-color: silver; height: 4px;"> </div>
            <div style="float:top; margin-bottom: 22px;  margin-top: 0px;">
                <div style="float: right; width: 23%; "> 
                    <a href="settings_h.php"  class="list-group-item" id="head"><h4> إملأ البيانات </h4></a>
                    <a href="add_new_products_h.php" class="list-group-item" id="selected">إضافة وتعديل المنتجات<h4></h4></a>
                    <a href="add_new_employee_h.php" class="list-group-item" id="m">إضافة وتعديل الموظفين</a>
                    <a href="#" class="list-group-item" id="m"> إضافة عميل</a>
                    <a href="#" class="list-group-item" id="m"> إعدادات</a>
                    <a href="#" class="list-group-item" id="m">--</a>
                    <!--<a href="left.html" target="left"> <a href="adm_insert_gr_in_stand.php" id="y" target="left" class="list-group-item" onclick="reeeeed();"> تعبئة الفرق بالمدرجات  </a></a>
                    -->
                    <div class="list-group-item" style="position:fixed; bottom: 12px; width: 23%; 
                         border-bottom-left-radius: 25% 100%; background-color: #293f5a;"></div>
                    <script src="js/jquery-3.2.1.min.js"></script>
                    <script src="js/bootstrap.min.js"></script>
                </div>  
                <div id="left" style=" border:3px solid #293f5a;">
                    <iframe src="add_new_products.php"  style="border-right-color: #293f5a; position: fixed; left: 0px; width: 77%; height: 82%; " name="cont"></iframe>
                </div>
            </div>
        </div>
    </body>
</html>



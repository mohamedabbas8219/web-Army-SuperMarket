<?php
//require './connection.php';
//require './bridge_to_login.php';
class product {

    public $id;
    public $name;
    public $quantity;
    public $carton_capacity;
    public $prod_date;
    public $expiry_date;
    public $validity;
    public $price;
    public $remaining_quantity;
    public $picture;
    public $type;

    public function __construct($id, $name, $type, $quantity, $carton_capacity, $prod_date, $expiry_date, $validity, $price, $remaining_quantity, $picture) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->quantity = $quantity;
        $this->carton_capacity = $carton_capacity;
        $this->prod_date = $prod_date;
        $this->expiry_date = $expiry_date;
        $this->validity = $validity;
        $this->price = $price;
        $this->remaining_quantity = $remaining_quantity;
        $this->picture = $picture;
    }

}

class orders {

    public $bill_no;
    public $id = array();
    public $product = array();
    public $quantitie = array();
    public $price = array();
    public $total_price;
    public $date;
    public $discount = array();
    public $iscash = array();
    public $seller = array();
    public $customer = array();

    public function __construct($bill_number, $id, $product, $quantitie, $price, $date, $discount, $isscah, $seller, $customer) {
        $this->bill_no = $bill_number;
        $this->id = $id;
        $this->product = $product;
        $this->quantitie = $quantitie;
        $this->price = get_price($price, $discount);
        $this->date = $date;
        $this->discount = $discount;
        $this->iscash = $isscah;
        $this->seller = $seller;
        $this->customer = $customer;
    }

    public function total_price() {
        $this->total_price = array_sum($this->prices);
        return $this->total_price;
    }

    public function get_price($price, $discount) {
        return $price - $price * $discount;
    }

}

class user {

    public $id;
    public $username;
    public $password;

    public function __construct($id, $username, $password) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

}

class customers {

    public $id;
    public $name;
    public $dean;

    public function __construct($id, $name, $dean) {
        $this->id = $id;
        $this->name = $name;
        $this->dean = $dean;
    }

}

class emp{
    public $id;
    public $user_name;
    public $password;
    public $full_name;
    public $periority;
    public $privelege=0;
    public function __construct(){}
    public function set_data($id,$user_name,$pass,$full_name,$periority,$privelege){
        $this->id=$id;
        $this->user_name=$user_name;
        $this->password=$pass;
        $this->full_name=$full_name;
        $this->periority=$periority;
        $this->privelege=$privelege;
    }
    public function users_data($conn)
 {
 $emps_sql="SELECT * FROM users_sellers";   
 $emps_q=mysqli_query($conn,$emps_sql);
 $emps_f=mysqli_fetch_all($emps_q,MYSQLI_NUM);  // number
  return $emps_f;
 }
 public function emp_name_privileges($conn, $id) {
     if($id){
    $query = "SELECT full_name , privileges FROM users_sellers where id=$id";  // return array
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    $user_data=$result[0];
    $arr_priv= $this->arr_previleges($user_data[1]);
    $full_name=$user_data[0];
    return array($full_name,$arr_priv);
     }
     else{
         return array("لم يتم تحديد الموظف",array()); 
     }
}
 function arr_previleges($privileges) {
    $exp = explode(',', $privileges);
    $user_prevs = array();
    foreach ($exp as $key => $v) {
        $user_prevs[$key] = $v;
    }
    return $user_prevs;
}
 
 
 
 
 
 
 
}

function check_user($conn, $username, $password) {
    $query = "SELECT * FROM users_sellers where user_name='$username' and password='$password'";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return count($result);
}

function user_id($conn, $username, $password) {
    $query = "SELECT id FROM users_sellers where user_name='$username' and password='$password'";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function periorities($conn, $id) {
    $query = "SELECT periority FROM users_sellers where id=$id";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    $query2 = "SELECT max(periority) FROM users_sellers";
    $get2 = mysqli_query($conn, $query2);
    $result2 = mysqli_fetch_all($get2, MYSQLI_NUM);
    // print_r($result[0]); ,max(periority)
    return array($result[0][0], $result2[0][0]);
}
function periorities2($conn, $id,$page_prev,$inv_group) {
    $query = "SELECT privileges FROM users_sellers where id=$id";  // return array
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    $user_prev_str=$result[0][0];
    $check_in=check_previleges($user_prev_str, $page_prev,$inv_group);
    return $check_in;
}
function check_previleges($user_prev_str, $page_prev,$inv_group) {
    $exp = explode(',', $user_prev_str);
    $user_prevs = array(8199);
    foreach ($exp as $key => $v) {
        $user_prevs[$key + 1] = $v;
    }
    $result = 0;
    if($page_prev==0){$result=0;}
    elseif (array_search(0, $user_prevs)) {
        $result = 0;
    } elseif (array_search(1, $user_prevs)) {
        $result = 1;
    } elseif (array_search($page_prev, $user_prevs)) {
        $result = 1;
    } else if (array_search($inv_group[0], $user_prevs)) {
        foreach ($inv_group as $key => $val) {
            if ($page_prev == $val) {
                $result = 1;
                break;
            }
        }
    }
    return $result;
}

function customer_id($conn, $customer) {
    $query = "SELECT id FROM customers where cust_name='$customer'";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function customer_name($conn, $customer_id) {
    $query = "SELECT cust_name FROM customers where id=$customer_id";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function seller_name($conn, $seller_id) {
    $query = "SELECT full_name FROM users_sellers where id=$seller_id";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function customers($conn) {
    $query = "SELECT * FROM customers";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result;
}

//echo check_user($conn,'m', '123');
function get_date($conn) {
    $query = "SELECT date(NOW())";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function month($conn, $date) {
    $query = "SELECT month('$date')";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function day($conn, $date) {
    $query = "SELECT DAY('$date')";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function dayName($conn, $date) {
    $query = "SELECT DAYNAME('$date')";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function monthName($conn, $date) {
    $query = "SELECT MONTHNAME('$date')";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function add_date($conn, $d, $v) {
    $query = "SELECT adddate('$d', interval '$v' day)";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function truncate_inventory($conn,$date){
    $upd_inv_q = "delete from inventory_2019 where month(date)=month('$date') and id>0";
    return ($conn->query($upd_inv_q));
}

function reset_inv_month($conn, $date) {
    $n_bill_no = next_bill_no($conn);  // from orders
    $upd_nbill_q = "update inventory_2019 set next_bill_no=$n_bill_no where id=0";
    $conn->query($upd_nbill_q);
    $upd_inv_q = "delete from inventory_2019 where month(date)=month('$date') and id>0";
    //$conn->query($upd_inv_q);
    return 1;
}

function buy_from_inv($conn, $id_p) {
    $upd_inv_q = "update inventory_2019 set paid=1 where product_id=$id_p";
    $conn->query($upd_inv_q);
}

function back_to_inv($conn, $id_p) {
    $upd_inv_q = "update inventory_2019 set paid=0 where product_id=$id_p";
    $conn->query($upd_inv_q);
}

function update_inv_month($conn, $id, $quantity, $date, $paid) {
    $next_id = max_inv_id($conn);
    $new_inv_q = "insert into inventory_2019(product_id,quantity,date,paid) 
               values($id,$quantity,'$date',$paid)";
    $conn->query($new_inv_q);
    return 1;
}

function max_inv_id($conn) {
    $query = "SELECT max(id) from inventory_2019 ";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0]+1;
}

function get_products($conn) {
    //where remaining_quantity>0
    $query = "SELECT * from products where id>0 order by ptype asc";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result;
}

function get_day_products($conn, $date) {
    $quantities = array();
    $query = "SELECT distinct product_id from orders where bill_date='$date'";
    $get1 = mysqli_query($conn, $query);
    $result1 = mysqli_fetch_all($get1, MYSQLI_NUM);
    // print_r($result[0]);
    for ($i = 0; $i < count($result1); $i++) {
        $id = $result1[$i][0];
        $result1[$i] = $result1[$i][0];
        $query2 = "SELECT sum(quantity) from orders where bill_date='$date' and product_id=$id";
        $get2 = mysqli_query($conn, $query2);
        $r = mysqli_fetch_all($get2, MYSQLI_NUM);
        $quantities[$i] = $r[0];
    }
    for ($j = 0; $j < count($quantities); $j++) {
        $quantities[$j] = $quantities[$j][0];
    }
    $result = array($result1, $quantities);
    // print_r($result[0]);
    return $result;
}

function get_global_products($conn) {
    // $result2=array();
    $quantities = array();
    //month(bill_date)=month('$date')
    //where month(bill_date)=3
    $query = "SELECT distinct product_id from orders ";
    $get1 = mysqli_query($conn, $query);
    $result1 = mysqli_fetch_all($get1, MYSQLI_NUM);
    // print_r($result[0]);
    for ($i = 0; $i < count($result1); $i++) {
        $id = $result1[$i][0];
        $result1[$i] = $result1[$i][0];
        $query2 = "SELECT sum(quantity) from orders where product_id=$id";
        $get2 = mysqli_query($conn, $query2);
        $r = mysqli_fetch_all($get2, MYSQLI_NUM);
        $quantities[$i] = $r[0];
    }
    for ($j = 0; $j < count($quantities); $j++) {
        $quantities[$j] = $quantities[$j][0];
    }
    $result = array($result1, $quantities);
    // print_r($result[0]);
    return $result;
}

function get_month_products($conn, $date) {
    // $result2=array();
    $quantities = array();
    //month(bill_date)=month('$date')
    //where month(bill_date)=3
    $query = "SELECT distinct product_id from orders ";
    $get1 = mysqli_query($conn, $query);
    $result1 = mysqli_fetch_all($get1, MYSQLI_NUM);
    // print_r($result[0]);
    for ($i = 0; $i < count($result1); $i++) {
        $id = $result1[$i][0];
        $result1[$i] = $result1[$i][0];
        $query2 = "SELECT sum(quantity) from orders where product_id=$id and month(bill_date)=month('$date')";
        $get2 = mysqli_query($conn, $query2);
        $r = mysqli_fetch_all($get2, MYSQLI_NUM);
        $quantities[$i] = $r[0];
    }
    for ($j = 0; $j < count($quantities); $j++) {
        if (!$quantities[$j][0]) {
            $quantities[$j] = 0;
        } else {
            $quantities[$j] = $quantities[$j][0];
        }
    }

    $result = array($result1, $quantities);
    // print_r($result[0]);
    return $result;
}

function get_bills($conn) {
    // $result2=array();
    $quantities = array();
    //month(bill_date)=month('$date')
    //where month(bill_date)=3
    $query = "SELECT distinct bill_number from orders order By bill_number desc ";
    $get1 = mysqli_query($conn, $query);
    $result1 = mysqli_fetch_all($get1, MYSQLI_NUM);
    // print_r($result[0]);
    for ($i = 0; $i < count($result1); $i++) {
        $b_d = $result1[$i][0];
        $result1[$i] = $result1[$i][0];
        $query2 = "SELECT * from orders where bill_number=$b_d";
        $get2 = mysqli_query($conn, $query2);
        $r = mysqli_fetch_all($get2, MYSQLI_NUM);
        $quantities[$i] = $r;
    }
    for ($j = 0; $j < count($quantities); $j++) {
        // $quantities[$j]=$quantities[$j][0];
    }
    $result = array($result1, $quantities);
    // print_r($result[0]);
    return $result;
}

function count_bills($conn, $month) {
    if ($month) {
        $query = "SELECT count(distinct bill_number) from orders where month(bill_date)=$month";
    } else {
        $query = "SELECT count(distinct bill_number) from orders";
    }
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function get_leaks($conn, $date) {
    $query2 = "SELECT * from inventory_2019 where month(date)=month('$date') and id>0 and quantity<0";
    $get2 = mysqli_query($conn, $query2);
    $result = mysqli_fetch_all($get2, MYSQLI_NUM);
    //$result=array(1,2,3);
    return $result;
}

function get_increases($conn, $date) {
    $query2 = "SELECT * from inventory_2019 where month(date)=month('$date') and id>0 and quantity>0";
    $get2 = mysqli_query($conn, $query2);
    $result = mysqli_fetch_all($get2, MYSQLI_NUM);
    //$result=array(1,2,3);
    return $result;
}

function get_products_edit($conn, $id) {
    $query = "SELECT * from products where id=$id order by ptype asc";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result;
}

function next_id($conn) {
    $query = "SELECT max(id)+1 from products";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    return $result[0][0];
}

function next_bill_no($conn) {
    $bill_no = 1;
    $query = "SELECT max(bill_number) from orders";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    // print_r($result[0]);
    if (!$result[0][0]) {
        $bill_no = 1;
    } else {
        $bill_no = $result[0][0] + 1;
    }
    return $bill_no;
}

function next_bill_inv_no($conn) {
    $query = "SELECT next_bill_no from inventory_2019 where id=0";
    $get = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($get, MYSQLI_NUM);
    $bill_no = $result[0][0];
    return $bill_no;
}

function prod_data_to_arr($o) {
    $res = array();               /////////////////////////// array
    for ($i = 0, $ii = count($o); $i < $ii; $i++) {
        if (count($o[$i]) == 1) {
            $res[$i] = $o[$i][0];
        } else {
            $res[$i] = array();
            for ($j = 0, $jj = count($o[$i]); $j < $jj; $j++) {
                if ($j == 8) {
                    $res[$i][$j] = "<img style='width: 90%; height: 100%;' src='data:image;base64," . $o[$i][$j] . "' />";
                } else {
                    $res[$i][$j] = $o[$i][$j];
                }
            }
        }
    }
    return $res;
}

function prod_invent_to_arr($o) {
    $res = array();               /////////////////////////// array
    for ($i = 0, $ii = count($o); $i < $ii; $i++) {
        if (count($o[$i]) == 1) {
            $res[$i] = $o[$i][0];
        } else {
            $res[$i] = array();
            for ($j = 0, $jj = count($o[$i]); $j < $jj; $j++) {
                $res[$i][$j] = $o[$i][$j];
            }
        }
    }
    return $res;
}

function prod_data_to_arr2($o) {
    $res = array();               /////////////////////////// array
    for ($i = 0, $ii = count($o); $i < $ii; $i++) {
        if (count($o[$i]) == 1) {
            $res[$i] = $o[$i][0];
        } else {
            $res[$i] = array();
            for ($j = 0, $jj = count($o[$i]); $j < $jj; $j++) {
                $res[$i][$j] = $o[$i][$j];
            }
        }
    }
    return $res;
}

function assoc_arr_id($prods) {
    $assoc_arr_ids = array();
    for ($i = 0, $jj = count($prods); $i < $jj; $i++) {
        $assoc_dta = array();
        //$assoc_dta['id']=$prods[$i][0];
        $assoc_dta['name'] = $prods[$i][1];
        $assoc_dta['quantity'] = $prods[$i][2];
        $assoc_dta['price'] = $prods[$i][3];
        $assoc_dta['prod_date'] = $prods[$i][4];
        $assoc_dta['expiry_date'] = $prods[$i][5];
        $assoc_dta['validity'] = $prods[$i][6];
        $assoc_dta['remain'] = $prods[$i][7];
        $assoc_dta['image'] = $prods[$i][8];
        $assoc_dta['type'] = $prods[$i][9];
        $assoc_dta['discount'] = $prods[$i][10];
        $id = $prods[$i][0];
        $assoc_arr_ids["$id"] = $assoc_dta;
    }
    return $assoc_arr_ids;
}

function new_order($conn, $bill_number, $bill_date, $product_id, $quantity, $total_price, $customer, $seller, $cash, $notes, $discount) {
    $new_order_q = "insert into orders(bill_number,bill_date,product_id,quantity,total_price,customer,seller,cash,notes,discount) 
               values($bill_number,'$bill_date',$product_id,$quantity,$total_price,$customer,$seller,$cash,'$notes',$discount)";
    return($conn->query($new_order_q));
    //$conn->close();
}


    function delete_product($conn, $prod_id) {
        $del_prod_q = "delete from products WHERE id=$prod_id ";
        $del_order_q = "delete from orders WHERE product_id=$prod_id ";
        $del_inv_q = "delete from inventory_2019 WHERE product_id=$prod_id and id>0 ";
        return( $conn->query($del_prod_q)&&$conn->query($del_order_q)&&$conn->query($del_inv_q));
    }
    function delete_all_product($conn) {
        $del_prod_q = "delete  from products where id>0 ";
        $del_order_q = "delete  from orders ";
        $del_inv_q = "delete  from inventory_2019 WHERE id>0 ";
        return( $conn->query($del_prod_q)&&$conn->query($del_order_q)&&$conn->query($del_inv_q));
    }
function del_prod_orders($conn, $bill_no, $prod_id) {
    $upd_inv_q = "delete from orders where bill_number=$bill_no and product_id=$prod_id";
    return ($conn->query($upd_inv_q));
}


function update_remaining($conn, $id, $value) { /// MA re Add ??!! re 
    $upd_remain_q = "UPDATE products SET remaining_quantity=remaining_quantity+$value WHERE id=$id";
    //echo "updated";
    return ($conn->query($upd_remain_q));
}

function update_real_quantity_inv($conn, $id, $quantity) {
    $upd_remain_q = "UPDATE products set remaining_quantity=$quantity  WHERE id=$id";
       $conn->query($upd_remain_q);
    return 1 ;
}

function update_full_quantity($conn, $cid, $cq) {
    $upd_remain_q = "UPDATE products SET quantity=$cq  WHERE id=$cid";
    return ($conn->query($upd_remain_q));
}

function refresh_validity($conn) {
    $curr_date = get_date($conn);
    $upd_remain_q = "UPDATE products SET validity=datediff(expiry_date,date(NOW()))";
    //echo "updated";
    return ($conn->query($upd_remain_q));
}

function th($show_tbl) {
    ?>
    <tr style="font-size: 20px;">
        <th style="width: 5%;"> م </th>
        <th style="width: 15%;">الصنف</th>

        <?php

        if ($show_tbl == 'd') {
            ?>
            <th style="width: 10%;"> الكمية المباعة </th> 
            <th style="width: 10%;">سعر الوحدة</th> 
            <th style="width: 15%;">الاجمالي</th> 
        <?php } else {
            ?>
            <th style="width: 10%;">كمية الوارد</th> 
            <th style="width: 10%;">الكمية المباعة</th> 
            <th style="width: 10%;">الكمية المتبقية</th>  

            <th style="width: 10%;">الفرق</th>   
            <?php

        }
        echo' </tr>';
    }

    function th2() {
        echo '<tr><td colspan="7">_</td></tr>';
    }

 function users_data($conn)
 {
 $emps_sql="SELECT * FROM users_sellers";   
 $emps_q=mysqli_query($conn,$emps_sql);
 $emps_f=mysqli_fetch_all($emps_q,MYSQLI_NUM);  // number

  return $emps_f;
 }
    
 function update_emp_data($conn,$id, $full_name, $user_name, $password,$periority) {
        $upd_crs_q = "UPDATE users_sellers SET full_name='$full_name',user_name='$user_name',password='$password',periority='$periority' "
                . "WHERE id=$id";
        $conn->query($upd_crs_q);
        return 1;
    }
     function check_emp_found($conn,$user_name,$id)
     {
         $maxid_sql="SELECT count(id) FROM users_sellers where user_name='$user_name' and id!=$id";   
         $maxid_q=mysqli_query($conn,$maxid_sql);
        $emp_id_f=mysqli_fetch_all($maxid_q,MYSQLI_NUM);  // number
        return $emp_id_f[0][0];
     }
     function new_emp_id($conn){
         $maxid_sql="SELECT max(id) FROM users_sellers";   
         $maxid_q=mysqli_query($conn,$maxid_sql);
        $emp_name_f=mysqli_fetch_all($maxid_q,MYSQLI_NUM);  // number
        return $emp_name_f[0][0];
     }
     function delete_emp($conn,$emp_id){
          $del_emp_q = "delete from users_sellers where id='$emp_id'";
            return ($conn->query($del_emp_q));
     }
     function new_emp($conn,$full_name,$user_name,$password,$periority){
         $id= new_emp_id($conn)+1;
          $new_emp_q = "insert into users_sellers(id,full_name,user_name,password,periority,privileges) "
                  . "values($id,'$full_name','$user_name','$password','$periority',0)";
           return ($conn->query($new_emp_q));
     }
     
     function update_emp_privileges($conn,$priv_str,$id){
          $upd_priv_q = "UPDATE users_sellers SET privileges='$priv_str' WHERE id=$id";
        return ($conn->query($upd_priv_q));
     }




//////////////////////////////////////////////////////////////////// false methods

    function max_crs_id() {
        $conn = new mysqli("localhost", "root", "", "mytables");
        mysqli_set_charset($conn, "utf8");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $max_crsid_sql = "SELECT MAX(crs_id)FROM allcourses";
        $max_crsid_q = mysqli_query($conn, $max_crsid_sql);
        $max_crsid_f = mysqli_fetch_all($max_crsid_q, MYSQLI_NUM);
        $max_crsid = $max_crsid_f[0][0];
        $conn->close();
        return $max_crsid;
    }

    function new_crs($conn, $new_crs_id, $new_crs_name, $new_dept_name) {
        $new_crs_q = "insert into allcourses(crs_id,crs_name,v_dept) values($new_crs_id,'$new_crs_name','$new_dept_name')";
        $conn->query($new_crs_q);
        //$conn->close();
    }

    function update_crs($conn, $new_crs_name, $new_dept_name, $crsid) {
        $upd_crs_q = "UPDATE allcourses SET crs_name='$new_crs_name',v_dept='$new_dept_name' WHERE crs_id=$crsid";
        $conn->query($upd_crs_q);

        return 1;
    }

    function delete_crs($conn, $crsid) {
        $upd_crs_g_q = "delete from courses_groups WHERE crs_id=$crsid ";
        $conn->query($upd_crs_g_q);

        $dr_id_c_sql = "SELECT count(dr_id) FROM allcourses where crs_id=$crsid ";
        $dr_id_c_q = mysqli_query($conn, $dr_id_c_sql);
        $dr_ids_c_f = mysqli_fetch_all($dr_id_c_q, MYSQLI_NUM);  // number
        $dr_ids_count = $dr_ids_c_f[0][0];
        for ($i = 0; $i < $dr_ids_count; $i++) {
            $upd_sh_t_q = "UPDATE showtables SET crs_id=0 , dr_id=0 ,done=0 WHERE crs_id=$crsid and done>0";
            $conn->query($upd_sh_t_q);
        }

        $sql = "DELETE from allcourses WHERE crs_id=$crsid";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        // echo $stmt->rowCount() . " records UPDATED successfully";
        //$delete_crs_q = "DELETE from allcourses WHERE crs_id=$crsid";
        //$conn->query($delete_crs_q);
        // $conn->close();
    }
    
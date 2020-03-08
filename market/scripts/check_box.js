
function check_box_function() {
 //var revoke_all = document.getElementById("revoke_all");
  //revoke_all.checked=false;
  provide_all2();
}

function provide_all1(){
   var provide_all = document.getElementById("provide_all");
  var sett_all = document.getElementById("sett_all");
  var add_prods = document.getElementById("add_prods");
  var add_emps = document.getElementById("add_emps");
  var privileges = document.getElementById("privileges");
  var sell = document.getElementById("sell");
  var bills = document.getElementById("bills");
  var inv_pages = document.getElementById("inv_pages");
  var i_d = document.getElementById("i_d");
  var i_m = document.getElementById("i_m");
  var i_inc = document.getElementById("i_inc");
  var i_lk = document.getElementById("i_lk");
  var i_so = document.getElementById("i_so");
  var revoke_all = document.getElementById("revoke_all");
    if(provide_all.checked==true){
    sett_all.checked=true;
    add_prods.checked=true;
    add_emps.checked=true;
    privileges.checked=true;
    sell.checked=true;
    bills.checked=true;
    i_d .checked=true;
    inv_pages.checked=true;
    i_m.checked=true;
    i_inc.checked=true;
    i_lk.checked=true;
    i_so.checked=true;
    revoke_all.checked=false;
    provide_all2();
}
else{
     sett_all.checked=false;
    add_prods.checked=false;
    add_emps.checked=false;
    privileges.checked=false;
    sell.checked=false;
    bills.checked=false;
    i_d .checked=false;
    inv_pages.checked=false;
    i_m.checked=false;
    i_inc.checked=false;
    i_lk.checked=false;
    i_so.checked=false;
    revoke_all.checked=true;
    provide_all2();
}
}
function provide_all2(){
    //var provide_all = document.getElementById("provide_all");
var provide_all = document.getElementById("provide_all");
  var sett_all = document.getElementById("sett_all");
  var add_prods = document.getElementById("add_prods");
  var add_emps = document.getElementById("add_emps");
  var privileges = document.getElementById("privileges");
  var sell = document.getElementById("sell");
  var bills = document.getElementById("bills");
  var inv_pages = document.getElementById("inv_pages");
  var i_d = document.getElementById("i_d");
  var i_m = document.getElementById("i_m");
  var i_inc = document.getElementById("i_inc");
  var i_lk = document.getElementById("i_lk");
  var i_so = document.getElementById("i_so");
  var revoke_all = document.getElementById("revoke_all");
   if(sett_all.checked==true&&sell.checked==true&&bills.checked==true&&inv_pages.checked==true){
       provide_all.checked=true;
       revoke_all.checked=false;
   }
   if(sett_all.checked==false||sell.checked==false||bills.checked==false||inv_pages.checked==false){
       provide_all.checked=false;
   }
   if(add_prods.checked==false && add_emps.checked==false&&privileges.checked==false&&sell.checked==false&&
           bills.checked==false&&inv_pages.checked==false&&i_d.checked==false&&i_m.checked==false&&i_inc.checked==false&&i_lk.checked==false&&i_so.checked==false){
       revoke_all.checked=true;
   }
    if(sell.checked==true||bills.checked==true){
        revoke_all.checked=false;
    }       
   if(privileges.checked==true){
     sett_all.checked=true;
    add_prods.checked=true;
    add_emps.checked=true;
    sell.checked=true;
    bills.checked=true;
    i_d .checked=true;
    inv_pages.checked=true;
    i_m.checked=true;
    i_inc.checked=true;
    i_lk.checked=true;
    i_so.checked=true;
    provide_all.checked=true;
    revoke_all.checked=false;
    provide_all2();
}
   
}
function revoke_all1(){
    var provide_all = document.getElementById("provide_all");
  var sett_all = document.getElementById("sett_all");
  var add_prods = document.getElementById("add_prods");
  var add_emps = document.getElementById("add_emps");
  var privileges = document.getElementById("privileges");
  var sell = document.getElementById("sell");
  var bills = document.getElementById("bills");
  var inv_pages = document.getElementById("inv_pages");
  var i_d = document.getElementById("i_d");
  var i_m = document.getElementById("i_m");
  var i_inc = document.getElementById("i_inc");
  var i_lk = document.getElementById("i_lk");
  var i_so = document.getElementById("i_so");
  var revoke_all = document.getElementById("revoke_all");
   if(revoke_all.checked == true) {
    sett_all.checked=false;
    add_prods.checked=false;
    add_emps.checked=false;
    privileges.checked=false;
    sell.checked=false;
    bills.checked=false;
    i_d .checked=false;
    inv_pages.checked=false;
    i_m.checked=false;
    i_inc.checked=false;
    i_lk.checked=false;
    i_so.checked=false;
    provide_all.checked=false;
   }
   else{
       if(add_prods.checked==false && add_emps.checked==false&&privileges.checked==false&&sell.checked==false&&
           bills.checked==false&&inv_pages.checked==false&&i_d.checked==false&&i_m.checked==false&&i_inc.checked==false&&i_lk.checked==false&&i_so.checked==false){
       if(revoke_all.checked==false){
        sell.checked=true;
    }
    else{revoke_all.checked=true;}
   }
   }
}

function sett_all1(){
    var sett_all = document.getElementById("sett_all");
  var add_prods = document.getElementById("add_prods");
  var add_emps = document.getElementById("add_emps");
  var privileges = document.getElementById("privileges");
  var revoke_all = document.getElementById("revoke_all");
  if(sett_all.checked==true){
     add_prods.checked=true;
    add_emps.checked=true;
    privileges.checked=true;
    revoke_all.checked=false;
  }
  else {
    add_prods.checked=false;
    add_emps.checked=false;
    privileges.checked=false;
  }
  revoke_all.checked=false;
  provide_all2();
}
function sett_all2(){
    var sett_all = document.getElementById("sett_all");
  var add_prods = document.getElementById("add_prods");
  var add_emps = document.getElementById("add_emps");
  var privileges = document.getElementById("privileges");
  var revoke_all = document.getElementById("revoke_all");
  if(add_prods.checked==true&&add_emps.checked==true&&privileges.checked==true){
     sett_all.checked=true;
     }
  else{
    sett_all.checked=false;
  }
  revoke_all.checked=false;
  provide_all2();
}

function inventory1(){
   var inv_pages = document.getElementById("inv_pages");
  var i_d = document.getElementById("i_d");
  var i_m = document.getElementById("i_m");
  var i_inc = document.getElementById("i_inc");
  var i_lk = document.getElementById("i_lk");
  var i_so = document.getElementById("i_so");
  var revoke_all = document.getElementById("revoke_all");
  revoke_all.checked=false;
  if(inv_pages.checked==true){
     i_d.checked=true;
    i_m.checked=true;
    i_inc.checked=true;
    i_lk.checked=true;
    i_so.checked=true;
  }
  else{
     i_d.checked=false;
    i_m.checked=false;
    i_inc.checked=false;
    i_lk.checked=false;
    i_so.checked=false;
  }
  provide_all2();
}
function inventory2(){
   var inv_pages = document.getElementById("inv_pages");
  var i_d = document.getElementById("i_d");
  var i_m = document.getElementById("i_m");
  var i_inc = document.getElementById("i_inc");
  var i_lk = document.getElementById("i_lk");
  var i_so = document.getElementById("i_so");
  var revoke_all = document.getElementById("revoke_all");
  revoke_all.checked=false;
  if(i_m.checked==true||i_inc.checked==true||i_lk.checked==true||i_so.checked==true){
     i_d.checked=true;
  }
  
  if(i_d.checked==true&&i_m.checked==true&&i_inc.checked==true&&i_lk.checked==true&&i_so.checked==true){
     inv_pages.checked=true;
  }
  else{
       inv_pages.checked=false;
  }
  
  provide_all2();
}
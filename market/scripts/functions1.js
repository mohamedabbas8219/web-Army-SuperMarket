function add_product(id){
    var check_found_id_bfre=document.getElementById("num_"+id);
    if (check_found_id_bfre){
            alert(" هذا المنتج مضاف مسبقا,\nيمكنك متابعة الاضافة لتعديل الكمية");
               }
var table=document.getElementById('selected_products');
var tr=table.rows[0];
var last_td=tr.cells.length;
var s=m();
//var product=document.getElementById('all_products').rows[0].cells[0].innerHTML;
var q =prompt('أدخل الكمية :');
var product_name=s[id][1];
var product_img=s[id][8];
var product_fullquantitiy=s[id][2];
var product_price=s[id][3];
var disc=s[id][10];
    if (q > 0 && (q % 1 === 0 || q % 2 === 0)) {
          if (!check_found_id_bfre){  
        var total_price = (product_price * q) - (product_price * q * disc);
            //alert("id not found");
            var cell = tr.insertCell(last_td);
             //cell.innerHTML="<div style='width:50%;'>"+product_img+"<div><br /><input type='number' id='num_"+id+"' onchange='count_price("+id+")' name='num"+id+"' value='"+q+"' min='1' max='"+product_fullquantitiy+"' /><br />"+product_name;
            cell.innerHTML = "<div id='x' onclick='delete_prod(" + id + "," + last_td + ")'>x</div><table style='width:99%;' id='cell_tbl'><tr><td class='tdsimg' rowspan='2'><center>" + product_img + "<center></td><td><div><br /><input type='number' id='num_" + id + "' onchange='count_prices()' name='num" + id + "' value='" + q + "' min='1' max='" + product_fullquantitiy + "' />: العدد </td> </tr><tr><td>" + product_name + " </td></tr><tr><td colspan='2' id='p_total_price_" + id + "'>  الإجمالي :" + total_price + "</td></tr></table>";
            var table_ids = document.getElementById('hidden_tbl_for_ids');
            var tr_ids = table_ids.rows[0];
            var cell_new_id = tr_ids.insertCell(tr_ids.cells.length);
            //var cell_num = tr_ids.cells.length;
            cell_new_id.innerHTML = id;
            //<input type='number' id='h_id_" + cell_num + "'  value='" + id + "' />
               //var q =prompt('تم اضافة عدد 1 من هذا الصنف \nلتغيير العدد من عدده بالفاتورة ');
          }else{
               document.getElementById("num_"+id).value=q;
          }
        count_prices();
    } else {
        alert("من فضلك أدخل رقم صحيح .");
    }
}
/*cell.ondblclick=confirm('هل تريد استرجاع هذا المنتج ؟ !')?alert('confirmed'):alert('not confirmed');*/

function alert_info(id){
    var s=m();
    var product_name=s[id][1];
    var product_img=s[id][8];
    var product_fullquantitiy=s[id][2];
    var p_price = s[id][3];
    var disc = s[id][10]*100+'%';
   alert("اسم المنتج :"+product_name+"\n"+"الكمية :"+product_fullquantitiy+"\n"+"سعر الوحدة :"
          +p_price+" جنيه" +"\n"+"خصم :"+disc);
}
function delete_prod(id,cell_num){
var table=document.getElementById('selected_products');
var tr=table.rows[0];

//var s=m();
var table_ids=document.getElementById('hidden_tbl_for_ids');
var tr_ids=table_ids.rows[0];
var tr_len=tr_ids.cells.length;
tr.deleteCell(0);
//var count = document.getElementById("num_"+id).value;
//var p_price = s[id][3];
 //var disc = s[id][10];
 //var prod_t_price = (count * p_price) - (count * p_price * disc);
 
 //var total_price=document.getElementById("total_price_td").value;
 //total_price-=prod_t_price;
 //document.getElementById("total_price_td").value=total_price;
 
  var i;
    for (i=0 ; i <= tr_len; i++) {
        var h_id=tr_ids.cells[i].innerHTML;
        if(h_id==id){
            //alert("del 1");
            tr_ids.deleteCell(i);
             count_prices();
            //alert("end del1");
            //document.getElementById("h_id_"+i+"").value=-1;
        }
    }
    alert("del");
    
    count_prices();
}

function count_prices(){
   // if(v==0){alert('changed');}
   var total_price=0;
   var prod_t_price=0;
 var s=m();
 var table_ids=document.getElementById('hidden_tbl_for_ids');
var tr_ids=table_ids.rows[0];
var tr_len=tr_ids.cells.length;

//document.getElementById("total_price_td").value=total_price;
  var i;
    for (i=0 ; i < tr_len; i++) {
      //alert("for");
        //var id =1; var count = 2;
        var id =tr_ids.cells[i].innerHTML;
       // alert(id);
       var count = document.getElementById("num_"+id).value;
         //alert(count);
        var p_price = s[id][3];
        var disc = s[id][10];
        prod_t_price = (count * p_price) - (count * p_price * disc);
        document.getElementById("p_total_price_"+id).innerHTML="  الإجمالي :"+prod_t_price;
        total_price+=prod_t_price;
       // alert("end for");
    }   
    
    document.getElementById("total_price_td").value= total_price;
}

function reverse_prod(){
    table=document.getElementById('selected_products');
tr=table.rows[0];
length=tr.cells.length;
for(i=0;i<length;i++){
    cell=tr.cells[i];
    cell.ondblclick=confirm('هل تريد استرجاع هذا المنتج ؟ !')?'':'';
    
}
}
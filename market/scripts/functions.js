function empty(){
    alert('welcome ');
}
function leave(){
    alert("GoodBy");
}
function row_index_f(r){
   // alert(r);
    document.getElementById("row_index").value=r;
    
}

function add_product(id){
    var check_found_id_bfre=document.getElementById("num_"+id);
    if (check_found_id_bfre){
            alert(" هذا المنتج مضاف مسبقا,\nيمكنك إضافة كمية اخري");
               }
var table=document.getElementById('selected_products');

//var last_td=tr.cells.length;
//var last_row=table.rows.length-1;
var s=m();
//var product=document.getElementById('all_products').rows[0].cells[0].innerHTML;
var product_name=s[id][1];
//var product_img=s[id][8];
var product_fullquantitiy=s[id][7];

//alert(product_fullquantitiy);

if(product_fullquantitiy!=0){
 var q =prompt('أضف الكمية :');
if(q&&(q*1)>(product_fullquantitiy*1))
{    q=product_fullquantitiy;
    document.getElementById("myInput").select();
}   
    
var product_price=s[id][3];
var disc=s[id][10];
    if (q > 0 && (q % 1 === 0 || q % 2 === 0)) {
      if (!check_found_id_bfre){ 
          var row_count=table.rows.length;
          table.insertRow(row_count);
          var tr=table.rows[row_count];
        var total_price = (product_price * q) - (product_price * q * disc);
            //alert("id not found");
             var cell0 = tr.insertCell(0);
             cell0.innerHTML="<input type='checkbox' name='check_" + id + "' id='check_" + id + "' />";
              var cell1 = tr.insertCell(1);
             cell1.innerHTML=row_count;
            var cell2 = tr.insertCell(2);
            cell2.innerHTML=product_name;
            var cell3 = tr.insertCell(3);
            cell3.innerHTML=" العدد  :<input style='margin_top:-4px;' type='number' id='num_" + id + "' onchange='count_prices()' name='num_" + id + "' value='" + q + "' min='1' max='" + product_fullquantitiy + "' />";
            
             var cell4 = tr.insertCell(4);
            cell4.innerHTML=product_price;
            var cell5 = tr.insertCell(5);
            cell5.innerHTML="<b id='p_total_price_" + id + "'>  الإجمالي :" + total_price + "</b>";
            var cell6 = tr.insertCell(6);
            cell6.innerHTML="<button id='del_btn' name='del_btn_" + id + "' onclick='delete_prod("+(row_count)+","+id+")'>إرجاع</button>";
               
         // cell1.innerHTML = "<div id='x' onclick='delete_prod(" + id +","+last_td+","+last_row+")'>x</div><table id='cell_tbl'><tr><td class='tdsimg' rowspan='2'><center>" + product_img + "<center></td><td><div><br /><input type='number' id='num_" + id + "' onchange='count_prices()' name='num_" + id + "' value='" + q + "' min='1' max='" + product_fullquantitiy + "' />: العدد </td> </tr><tr><td>" + product_name + " </td></tr><tr><td colspan='2' id='p_total_price_" + id + "'>  الإجمالي :" + total_price + "</td></tr></table>";
            
            var table_ids = document.getElementById('hidden_tbl_for_ids');
            var tr_ids = table_ids.rows[0];
            var cell_new_id = tr_ids.insertCell(tr_ids.cells.length);
           // var tr_rows = table_ids.rows[1];
            //var cell_new_row = tr_rows.insertCell(tr_ids.cells.length);
            //var cell_num = tr_ids.cells.length;
            cell_new_id.innerHTML = id;
           // cell_new_row.innerHTML = row_count;
            //<input type='number' id='h_id_" + cell_num + "'  value='" + id + "' />
               //var q =prompt('تم اضافة عدد 1 من هذا الصنف \nلتغيير العدد من عدده بالفاتورة ');
          }
          else{
               var last_num=document.getElementById("num_"+id).value;
               var new_num=(q*1)+(last_num*1);
               if(new_num>product_fullquantitiy)
               {
                   new_num=product_fullquantitiy;
               }   
               document.getElementById("num_"+id).value=new_num ;
          }
        count_prices();
        document.getElementById("myInput").select();
    } 
    else if(!q) {
        alert("من فضلك أدخل الكمية ! .");
        document.getElementById("myInput").select();
    }else{
        alert("من فضلك أدخل رقم صحيح .");
        document.getElementById("myInput").select();
    }
    document.getElementById("myInput").select();
    }
    else{
        alert("عفوا لقد نفذت الكمية");
        document.getElementById("myInput").select();
    }
    document.getElementById("myInput").select();
    count_prices();
   // disp_selec_tbl();
    
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

function sort_table(){
var tr,tr_len; 
var table2=document.getElementById('virtual_table');
table2.insertRow(0);
var row_count2=table2.rows.length;
var table=document.getElementById('selected_products');
var row_count=table.rows.length;
    for (var i = 0, max = row_count; i < max; i++) {
        tr=table.rows[i];
        tr_len=tr.cells.length;
        for (var j = 0; j < tr_len; j++) {
         var cell_content=tr.cells[j];
         row_count2=table2.rows.length;
         var tr2=table.rows[row_count2];
          var last_td2=tr2.cells.length;
         if(last_td2>0&&last_td2%8==0){
              table2.insertRow(row_count2);
          }
          var last_row2=table.rows.length-1;
           tr2=table.rows[last_row2];
          var last_td2=tr2.cells.length;
          
        }
    }



//var tr=table.rows[row_indx];
//var tr_len=tr_ids.cells.length;

}

function delete_prod(row_indx,id){
   // row_index_f(row_indx);
var table=document.getElementById('selected_products');
//var tr=table.rows[row_indx];
//alert(row_indx);
//count_prices();
//var s=m();
var table_ids=document.getElementById('hidden_tbl_for_ids');
var tr_ids=table_ids.rows[0];
var tr_len=tr_ids.cells.length;
if(confirm("هل تريد استرجاع المنتج ؟")){
  //  alert(row_indx);
table.deleteRow(row_indx);
//alert(table.rows.length);
  var i;
    for (i=0 ; i < tr_len; i++) {
        var h_id=tr_ids.cells[i].innerHTML;
        if(h_id==id){
           // alert("id= "+id);
           // alert("i= "+i);
           tr_ids.deleteCell(i);
          // alert('تم استرجاع المنتج');
          count_prices();
           }
    }
    }
count_prices();
}

function count_prices(){
   // if(v==0){alert('changed');}
   //alert("p");
   var total_price=0;
   var prod_t_price=0;
 var s=m();
 var table_ids=document.getElementById('hidden_tbl_for_ids');
var tr_ids=table_ids.rows[0];
var tr_len=tr_ids.cells.length;
//alert(tr_len);
//document.getElementById("total_price_td").value=total_price;
  var i;
    for (i=0 ; i < tr_len; i++) {
            //alert("for");
      //alert("for");
        //var id =1; var count = 2;
        var id =tr_ids.cells[i].innerHTML;
        //alert(id);
       var count = document.getElementById("num_"+id).value;
        // alert(count);
        var p_price = s[id][3];
        var disc = s[id][10];
        prod_t_price = (count * p_price) - (count * p_price * disc);
        prod_t_price=prod_t_price.toFixed(2);
        document.getElementById("p_total_price_"+id).innerHTML="  الإجمالي :"+prod_t_price;
        total_price+=(prod_t_price*1);
       // alert("end for");
    }   
    
    document.getElementById("total_price_td").value= total_price;
    document.getElementById("count_prods").value= tr_len;
    set_ids_txt();
    disp_selec_tbl();
}

function set_ids_txt(){
   // alert("alive");
     document.getElementById("text_ids").value="";
    var table_ids=document.getElementById('hidden_tbl_for_ids');
var tr_ids=table_ids.rows[0];
var tr_len=tr_ids.cells.length;
 for (var i=0 ; i < tr_len; i++) {
        var id =tr_ids.cells[i].innerHTML;
        //alert(id);
        document.getElementById("text_ids").value+=id;
        
        if(i<tr_len-1){
          document.getElementById("text_ids").value+=",";  
        }
    } 
}

function disp_selec_tbl(){
   // alert("disp");
     document.getElementById('selected_products_div').style.display="none";
      document.getElementById('hide_fatora_div').style.display="none";
      document.getElementById('msg').style.display="none";
      
    var table=document.getElementById('selected_products');
      var countt=table.rows.length;
      if(countt>1){
         show_fatora();
         
      }
      else{
      hide_fatora();
}
}

function show_fatora(){
    document.getElementById('selected_products_div').style.display="";
    document.getElementById('show_fatora_div').style.display="none";
    document.getElementById('hide_fatora_div').style.display="";
    document.getElementById('msg').style.display="none";
     document.getElementById('stretch_fatora_div').style.display="";
     document.getElementById('shrink_fatora_div').style.display="none";
}
function hide_fatora(){
    document.getElementById('selected_products_div').style.display="none";
    document.getElementById('show_fatora_div').style.display="";
    document.getElementById('hide_fatora_div').style.display="none";
    document.getElementById('msg').style.display="none";
    document.getElementById('selected_products_div').style.height="132px";
    document.getElementById('stretch_fatora_div').style.display="none";
    document.getElementById('shrink_fatora_div').style.display="none"; 
}
function stretch_fatora(){
    document.getElementById('selected_products_div').style.height="408px";
   // document.getElementById('selected_products_div').style.backgroundsize="cover";
    //document.getElementById('msg').style.display="none";
    document.getElementById('shrink_fatora_div').style.display="";
    document.getElementById('stretch_fatora_div').style.display="none";
}
function shrink_fatora(){
    document.getElementById('selected_products_div').style.height="132px";
    document.getElementById('shrink_fatora_div').style.display="none";
    document.getElementById('stretch_fatora_div').style.display="";
}

function check_all(){
    //alert("mmm");
//var table=document.getElementById('selected_products');
var table_ids=document.getElementById('hidden_tbl_for_ids');

var check_box=document.getElementById("all_ch");
var tr_ids=table_ids.rows[0];
var tr_len=tr_ids.cells.length;
if(check_box.checked==true){
  var i;
    for (i=0 ; i < tr_len; i++) {
        var h_id=tr_ids.cells[i].innerHTML;
        if(h_id){
         document.getElementById("check_" + h_id ).checked=true;
           //tr_ids.deleteCell(i);
           }
      }
  }
  else{
      var i;
    for (i=0 ; i < tr_len; i++) {
        var h_id=tr_ids.cells[i].innerHTML;
        if(h_id){
          document.getElementById("check_" + h_id ).checked=false;
           //tr_ids.deleteCell(i);
           }
      }
  }
      
}

function overtr(r){
    var row_index=r.rowIndex;
     //alert(row_index);
   var rrow= document.getElementById('all_products').rows[row_index];
   var r_lngth=rrow.cells.length;
  // alert(r_lngth);
   for(var i=0;i<r_lngth;i++){
       rrow.cells[i].style.backgroundColor='#a8a8ff';
   } 
}
function outtr(r,odd){
    var row_index=r.rowIndex;
     //alert(row_index);
   var rrow= document.getElementById('all_products').rows[row_index];
   var r_lngth=rrow.cells.length;
  // alert(r_lngth);
   for(var i=0;i<r_lngth;i++){
      if(odd==0){rrow.cells[i].style.backgroundColor='#f2f2f2';}
      else{rrow.cells[i].style.backgroundColor='#ddd';}
   }
}

function ddate(d){
    //alert(d);
    var ex=document.getElementById('exp_date').value;
    var v=document.getElementById('validity').value;
    //var v=document.getElementById('validity').value;
   if(d=='e'){
        // alert(ex);
        if(ex==''){
            document.getElementById('validity').disabled=false;
       }
       else{
         document.getElementById('validity').value='';
         document.getElementById('validity').disabled=true;
     }
   }
   
    if(d=='v'){
        // alert(ex);
        if(v==''){
            document.getElementById('exp_date').disabled=false;
       }
       else{
         document.getElementById('exp_date').value='';
         document.getElementById('exp_date').disabled=true;
     }
   }
}

function p_quantity(){
   // alert('22');
    var q=document.getElementById('quantity').value;
    document.getElementById('remaining').value=q;
}

function show_msg(){
    var done_input=document.getElementById('done_input').value;
    if(done_input!=-1){
         document.getElementById('selected_products_div').style.display="";
          document.getElementById('show_fatora_div').style.display="none";
          document.getElementById('hide_fatora_div').style.display="";
          document.getElementById('msg').style.display="";
    }
}

function disc2(){
    //var discc=document.getElementById('disc');
    if(document.getElementById('disc').value>100)
    {
        document.getElementById('disc').value=100;
    }
    else if(document.getElementById('disc').value<1){document.getElementById('disc').value=1;}
    if(document.getElementById('disc').value==''){document.getElementById('disc').value=0;}
    
}



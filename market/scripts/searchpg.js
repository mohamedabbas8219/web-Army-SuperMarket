function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("all_products");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
      for(j=0;j<2;j++){    
    td = tr[i].getElementsByTagName("td")[j];
    if (td) {
      txtValue = td.textContent || td.innerText;
     
                
      tr[i].style.display = "none";           
       if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        j=2;
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
 }
}


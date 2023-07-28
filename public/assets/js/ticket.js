$(document).ready(function(){
    var items = 0;
    $(".ticket-product").change(function(){
      items++;
      $("#products-table").show();
      var name = $(this).find(":selected").text();
      var id = $(this).val();
      if(!$("#row"+id).length){
        $("#products-table").append(`
            <tr id="row`+id+`" style="background-color:white">
            <td style="padding-top:20px;font-size:17px;font-weight:bold" >`+name+`</td>
            <td> <input type="hidden" name="invoice_product_ids[]" value="`+id+`" min="1"><input type="text" style="font-size:17px;font-weight:bold" name="descriptions[]"  class="form-control"></td>
            <td ><button  onclick="deleteRow(this)" type="button" style="margin-right: 40px" class="btn btn-danger " style="margin-right: 10px"><i class="fas fa-times"></i></button></td>
            </tr>
        `);
      }
    });
});
function deleteRow(btn) {
        var row = btn.parentNode.parentNode;
        var d = row.parentNode.parentNode.rowIndex;
        row.parentNode.removeChild(row);
}
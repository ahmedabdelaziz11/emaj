<label for="">منتجات الفاتورة</label>
<select name="invoice_product_id" class="select2 form-control" id="invoice_product_id">
    <option disabled selected>اختر منتج</option>
    @foreach ($invoiceProducts as $invoiceProduct)
        <option value="{{ $invoiceProduct->id }}">{{ $invoiceProduct->product->name }}</option>
    @endforeach
</select>

<script>
    $(document).ready(function(){
        $('.select2').select2();
    });
    $("#invoice_product_id").change(function(){
        let invoice_product_id = $(this).val();
        console.log(invoice_product_id);
        $.ajax({
            url: "/get-invoice-products-address/"+invoice_product_id,
            type: "GET",
        }).done(function(data){
            $("#address-textfield").val(data);
            console.log(data);
        }).fail(function(){
            console.log("Failed");
        });
    })
</script>
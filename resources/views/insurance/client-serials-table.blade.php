<label for="">منتجات الفاتورة</label>
<select name="invoice_product_id" class="select2 form-control" id="invoice_product_id">
    <option disabled selected>اختر منتج</option>
    @foreach ($serials as $serial)
        <option value="{{ $serial->id }}"> name ( {{ $serial->insurance->invoiceProduct->product->name }} ) serial ( {{ $serial->serial}} ) model ( {{$serial->model_number}} )</option>
    @endforeach
</select>

<script>
    $(document).ready(function(){
        $('.select2').select2();
    });
    $("#invoice_product_id").change(function(){
        let serial_id = $(this).val();
        console.log(serial_id);
        $.ajax({
            url: "/get-insurance-address/"+serial_id,
            type: "GET",
        }).done(function(data){
            $("#address-textfield").val(data);
            console.log(data);
        }).fail(function(){
            console.log("Failed");
        });
    });
</script>
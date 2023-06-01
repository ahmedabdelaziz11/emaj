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
        $.ajax({
            url: "{{ route('invoice-product-details') }}",
            type: "POST",
            data: {
                invoice_product_id: invoice_product_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(data){
                $("#product_details").html(data);
            }
        });
    })
</script>
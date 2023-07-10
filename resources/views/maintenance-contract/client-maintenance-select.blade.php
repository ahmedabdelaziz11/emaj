<label for="">منتجات عقود الصيانة</label>
<select name="invoice_product_id" class="select2 form-control" id="invoice_product_id">
    <option disabled selected>اختر منتج</option>
    @foreach ($maintenanceProducts as $maintenanceProduct)
        <option value="{{ $maintenanceProducts->product->id }}">{{ $maintenanceProducts->product->name }}</option>
    @endforeach
</select>

<script>
    $(document).ready(function(){
        $('.select2').select2();
    });
</script>
<table class="table table-bordered mg-b-0 text-md-nowrap">
    <thead>
        <tr class="text-center">
            <th>اسم المنتج</th>
            <th>الفاتورة</th>
            <th>داخل الضمان<br>(نعم / لا)</th>
            <th>تاريخ البدء</th>
            <th>تاريخ الانتهاء</th>
            <th>الحد الاقصى</th>
            <th style="width: 20%;">العنوان</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoiceProducts as $x)
            <tr class="text-center">
                <td>{{ $x->product->name }}</td>
                <td>{{ $x->invoice->id }} <input type="hidden" name="invoice_product_id[]" value="{{$x->id}}"> </td>                     
                <td>
                    <input type="checkbox" class="form-control form-control-sm is_in_isurance">
                    <input type="hidden" name="is_in_isurance[]" value="0">
                </td>        
                <td><input type="date" name="start_date[]" value="{{$x->invoice->date}}" class="form-control"></td>        
                <td><input type="date" name="end_date[]" value="{{date('Y-m-d', strtotime($x->invoice->date. ' + 1 years'))}}" class="form-control"></td>        
                <td><input type="number" step=".01" name="compensation[]" value="{{$x->product_selling_price * .01}}" class="form-control"></td>        
                <td style="width: 20%;">
                    <select class="form-control select2 address" name="address_id">
                        <option value=" ">اختر العنوان</option>

                    </select>
                </td>        
            </tr>
        @endforeach
    </tbody>
</table> 

<script>
    $('input[type=checkbox]').on("change",function(){
        var target = $(this).parent().find('input[type=hidden]').val();
        if(target == 0)
        {
            target = 1;
        }
        else
        {
            target = 0;
        }
        $(this).parent().find('input[type=hidden]').val(target);
    });

    $(document).ready(function(){
        $('.address').select2({
            placeholder: 'Enter a parent address',
            ajax: {
                dataType: 'json',
                url: function(params) {
                    return '/get-addresses-select2/' + params.term;
                },
                processResults: function (data, page) {
                    return {
                    results: data || ' '
                    };
                },
            }
        });
    });
</script>
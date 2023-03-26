@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <!--Internal  Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />


@endsection
@section('title')
    اضافة قيد
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='days') }}">القيود اليومية</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                        اضافه قيد </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

<input type="hidden" id="del" value="{{ Session::get('del')}}">   

@if (session()->has('del'))
<script>
    window.onload = function() {
        var del = document.getElementById("del").value;
        console.log(del);
        notif({
        msg: del,
        type: "error"
        })
    }
</script>
@endif

<div class="row row-sm">

    <div class="col-xl-12">
        <div class="card mg-b-20" id="tabs-style2">
            <div class="card-body">
                    <form  action="{!! route('days.store') !!}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <label>تاريخ القيد</label>
                                <input class="form-control fc-datepicker" name="date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-8">
                                <label>البيان</label>
                                <input class="form-control" name="day_details" type="text" value="." required>
                            </div>
                        </div>
                        <br>


                        <div class="form-group">
                            <table class="table table-bordered table-hover mb-0 text-nowrap">
                                <thead id="product_header" style="display:none;">
                                <th style=" font-size: 15px;">الحساب</th>
                                <th style=" font-size: 15px;" class="text-center">مدين</th>
                                <th style=" font-size: 15px;" class="text-center">دائن</th>
                                <th style=" font-size: 15px;" class="text-center">البيان</th>
                                <th style=" font-size: 15px;" class="text-center">مركز التكلفة</th>
                                <th style=" font-size: 15px;" class="text-center">x</th>
                                </thead>
                                <tbody id="product_container">
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="form-group col-3">
                                <button type="button" id="add_day" class="btn btn-primary w-100 ">اضافة قيد</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label>مجموع المدين</label>
                                <input class="form-control" type="number" value="0" id="total_debit" name="total_debit"  onchange='updateSub();' readonly>
                            </div>
                            <div class="form-group col-4">
                                <label>مجموع الدائن</label>
                                <input class="form-control" type="number" value="0" id="total_credit" name="total_credit" onchange='updateSub();' readonly>
                            </div>
                            <div class="form-group col-4">
                                <label>الفرق</label>
                                <input class="form-control" type="number" id="total_sub"  readonly>
                            </div>
                        </div>
                        <button type="submit" id="submit" class="btn btn-primary w-100"  disabled>اضافة</button>

                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

<script>
    function updateTotal() {
        var total = 0;//
        var list = document.getElementsByName("debit[]");
        console.log(list);
        var values = [];
        for(var i = 0; i < list.length; ++i) {
            values.push(parseFloat(list[i].value));
        }
        total = values.reduce(function(previousValue, currentValue, index, array){
            return previousValue + currentValue;
        });
        document.getElementById("total_debit").value = parseFloat(total) ;   
        var list2 = parseFloat(document.getElementById("total_credit").value);
        console.log(list2);
        var sub = total - parseFloat(list2);
        document.getElementById("total_sub").value = sub;    

        if(sub == 0 && list2 > 0)
        {
            document.getElementById("submit").disabled = false;
        }else{
            document.getElementById("submit").disabled = true;
        }

        check();


    }
</script>


<script>
    function check() {
        var debit = document.getElementsByName("debit[]");
        var credit = document.getElementsByName("credit[]");

        for(var i = 0; i < debit.length; ++i) {
            if(debit[i].value != 0 && credit[i].value != 0)
            {
                document.getElementById("submit").disabled = true;
            }
        }
    }
</script>

<script>
function updateTotal2() {
    var total = 0;//
    var list = document.getElementsByName("credit[]");
    console.log(list);
    var values = [];
    for(var i = 0; i < list.length; ++i) {
        values.push(parseFloat(list[i].value));
    }
    total = values.reduce(function(previousValue, currentValue, index, array){
        return previousValue + currentValue;
    });
    document.getElementById("total_credit").value = parseFloat(total); 
       
    var list1 = parseFloat(document.getElementById("total_debit").value);
    var sub = list1 - parseFloat(total);
    document.getElementById("total_sub").value = sub;    

    if(sub == 0 && list1 > 0)
    {
        document.getElementById("submit").disabled = false;
    }else{
        document.getElementById("submit").disabled = true;
    }
    check();
}
</script>

<script>
    $(document).ready(function(){
        var items = 0;
        var id = 0;
        $("#add_day").on('click',function(){
            items++;
            id++;
            console.log(`ITEM AFTER ++ `+items);
            $("#product_header").show();
            if(!$("#row"+id).length){
            $("#product_container").append(`
                <tr id="row`+id+`">
                <td style="width:280px">
                    <div style="width:280px" class="form-group">
                        <select  style="width:280px" class="form-control custom-select select2" name="account_id[]" required="required">
                        <option value="اختر" disabled selected>اختر الحساب </option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}"> {{ $account->name }} - {{$account->code}} </option>
                        @endforeach
                        </select>
                    </div>
                </td>
                <td style="width:250px;"><input type="number" step=".01" style="font-size:17px;font-weight:bold" name="debit[]"  value="0" onchange='updateTotal();' class=" form-control text-center"></td>
                <td style="width:250px"><input type="number" step=".01" style="font-size:17px;font-weight:bold" name="credit[]" value="0" onchange='updateTotal2();' class=" form-control text-center"></td>
                <td style="width:400px"><input type="text" name="details[]"  style="font-size:17px;font-weight:bold" class=" form-control text-right"></td>
                <td style="width:150px">
                    <div style="width:150px" class="form-group">
                        <select  style="width:150px" class="form-control custom-select select2" name="cost_id[]" required="required">
                        @foreach ($costs as $cost)
                            <option value="{{ $cost->id }}"> {{ $cost->name }} </option>
                        @endforeach
                        </select>
                    </div>
                </td>
                <td style="width:10px"><button type="button" name="delete1" class="btn btn-sm btn-danger float-none" id="remove_product`+id+`" value="`+id+`" style="width:100%"><i class="fas fa-times" style="width:100%" class="float-none"></i></button></td>
                </tr>
                `);
            }
            $('.custom-select').select2();


            $("#remove_product"+id).on('click',function(){
            items--;
            console.log(items);
            var id = $(this).val(); 
            $("#row"+id).remove();
            if(items == 0){
                $("#product_header").hide();
                document.getElementById("total_sub").value = 0; 
                document.getElementById("total_debit").value = 0;  
                document.getElementById("total_credit").value = 0;    
                document.getElementById("submit").disabled = true;


            }else{
                var total = 0;//
                var list = document.getElementsByName("debit[]");
                console.log(list);
                var values = [];
                for(var i = 0; i < list.length; ++i) {
                    values.push(parseFloat(list[i].value));
                }
                total = values.reduce(function(previousValue, currentValue, index, array){
                    return previousValue + currentValue;
                });
                document.getElementById("total_debit").value = parseFloat(total);   
                var list2 = parseFloat(document.getElementById("total_credit").value);
                console.log(list2);
                var sub = total - parseFloat(list2);
                document.getElementById("total_sub").value = sub;  

                var total = 0;//
                var list = document.getElementsByName("credit[]");
                console.log(list);
                var values = [];
                for(var i = 0; i < list.length; ++i) {
                    values.push(parseFloat(list[i].value));
                }
                total = values.reduce(function(previousValue, currentValue, index, array){
                    return previousValue + currentValue;
                });
                document.getElementById("total_credit").value = parseFloat(total);    
                var list1 = parseFloat(document.getElementById("total_debit").value);
                var sub = list1 - parseFloat(total);
                document.getElementById("total_sub").value = sub;
                if(sub == 0 && list1 > 0)
                {
                    document.getElementById("submit").disabled = false;
                }else{
                    document.getElementById("submit").disabled = true;
                } 
                check();
            }

            });
        });
    });
</script>
<script>
$('button').click(function(){
    console.log("asasa");
});
</script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

<script>
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();
</script>



@endsection

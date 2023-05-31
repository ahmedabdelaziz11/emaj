@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    اضافة فاتوره
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='invoices') }}">  فواتير المبيعات </a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                           اضافه فاتوره </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (Session::has('message'))
            <li class="alert alert-success message " role="alert" id="message" style="text-align: center;list-style: none;width:auto;margin-bottom:5px" >{{Session::get('message')}}</li>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">

      <div class="col-xl-12">
          <!-- div -->
          <div class="card mg-b-20" id="tabs-style2">
              <div class="card-body">
                    <form  action="{!! route('invoices.store') !!}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <input type="hidden" id="address_id" name="adress_id">
                        <input type="hidden" id="ticket_id" name="ticket_id">
                        <div class="d-flex justify-content-center">
                          <h1> </h1>
                        </div><br>

                        <div class="row">

                            <div class="col">
                                <label>تاريخ الفاتوره</label>
                                <input class="form-control fc-datepicker" name="date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="form-group col">
                              <label>العميل</label>
                              <select class="form-control select2 " name="client_id" required="required">
                                <option selected disabled>اختر العميل </option>
                                @foreach ($clients as $client)
                                  <option value="{{ $client->id }}">{{ $client->name }}</option>
                                  @if($client->accounts->count() > 0)
                                    @foreach ($client->accounts as $account1)
                                      <option value="{{ $account1->id }}" >{{ $account1->name }}</option>
                                    @endforeach
                                  @endif
                                @endforeach
                              </select>
                            </div>

                            <div class="col">
                                <label>حساب النقدية</label>
                                <select class="form-control select2" name="account_id" id="account_id"  required="required">
                                  <option value="0" selected disabled>اختر الحساب </option>
                                  <option value="0">اجل</option>
                                  @foreach ($accounts as $account)
                                    @if($account->id == 58)
                                      <option value="{{ $account->id }}" disabled >{{ $account->name }}</option>
                                    @else
                                      <option value="{{ $account->id }}" >{{ $account->name }}</option>
                                    @endif
                                    @if($account->accounts->count() > 0)
                                      @foreach ($account->accounts as $account1)
                                        <option value="{{ $account1->id }}" >{{ $account1->name }}</option>
                                      @endforeach
                                    @endif
                                  @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label>مركز التكلفة</label>
                                <select class="form-control select2" name="cost_id" id="cost_id"  required="required">
                                  <option value="0" selected disabled>اختر المركز</option>
                                  @foreach ($costs as $cost)
                                    <option value="{{ $cost->id }}" >{{ $cost->name }}</option>
                                  @endforeach
                                </select>
                            </div>
                            
                        </div><br>
                        
                        <div class="row">
                          <div class="form-group col">
                            <label>المخزن</label>
                            <select class="form-control select2" name="stock_id" id="stock_id" required="required">
                              <option value="0" selected disabled>اختر المخزن</option>
                              @foreach ($stocks as $stock)
                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col">
                            <label>رقم العرض</label>
                            <select class="form-control select2" name="offer_id" required="required">
                              <option value="">اختر العرض </option>
                        
                            </select>
                          </div>

                          <div class="col">
                            <label for="inputName"  class="control-label">نسبة الخصم</label>
                            <input style="font-size:17px;font-weight:bold" type="text" step=".01" class="form-control" id="discount" name="discount" readonly>
                          </div>
                          <input type="hidden" class="form-control" id="profit" name="profit">
                          <input type="hidden" class="form-control" id="c_sales" name="c_sales">
                          <div class="col">
                              <label for="inputName" class="control-label">اجمالى الخدمات</label>
                              <input style="font-size:17px;font-weight:bold" type="text" step=".01" class="form-control" id="t_service" name="t_service" readonly>
                          </div>
                        </div><br>

                        <div class="row">
                        <div class="col">
                              <label for="inputName" class="control-label">اجمالى المنتجات</label>
                              <input style="font-size:17px;font-weight:bold" type="text" step=".01" class="form-control" id="total" name="total" readonly>
                          </div>
                          <div class="col">
                                <label>الفاتورة شاملة القيمة المضافة؟</label>
                                <select style="font-size:17px;font-weight:bold" class="form-control" name="value_add" id="value_add" onchange='updateTotal1();' required="required">
                                  <option value="1">نعم</option>
                                  <option value="0">لا</option>
                                </select>
                          </div>
                          <div class="col">
                                <label>نوع الفاتورة</label>
                                <select style="font-size:17px;font-weight:bold" class="form-control" name="dman" id="dman" onchange='updateTotal();' required="required">
                                  <option value="0">خارج الضمان</option>
                                  <option value="1">داخل الضمان</option>
                                </select>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="form-group col">
                              <label>الصافى</label>
                              <input style="font-size:17px;font-weight:bold" class="form-control" step=".01" type="text" name="f_total" id="f_total" value="0" min="0" disabled>
                          </div>
                          <div class="form-group col">
                              <label>المبلغ المدفوع</label>
                              <input style="font-size:17px;font-weight:bold" class="form-control" step=".01" type="number" name="amount_paid" id="amount_paid" value="0" min="0">
                          </div>
                        </div>                 
                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                data-height="70" />
                        </div><br>

                        <br>
                        <button type="submit" class="btn btn-primary w-100 ">اضافة الفاتوره</button>
                      </form>
              </div>
          </div>
                    <!-- row closed -->
                    </div>
                    <!-- Container closed -->
                    </div>
                    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
<script>
  $(document).ready(function(){
    document.getElementById("account_id").onchange = function(){
      if(parseFloat(document.getElementById("account_id").value) == 0)
      {
        document.getElementById("amount_paid").readOnly   = true;
      }else{
        if(parseFloat(document.getElementById("dman").value) == 1)
        {
          document.getElementById("amount_paid").readOnly   = true;
        }else
        {
          document.getElementById("amount_paid").readOnly   = false;
        }
      } 
    };
    document.getElementById("dman").onchange = function(){
      if(parseFloat(document.getElementById("dman").value) == 1)
      {
        document.getElementById("amount_paid").readOnly   = true;
      }else{
        if(parseFloat(document.getElementById("account_id").value) == 0)
        {
          document.getElementById("amount_paid").readOnly   = true;
        }else
        {
          document.getElementById("amount_paid").readOnly   = false;
        }
      }
    };
  });
</script>
<script>
  function updateTotal1() {
    var sub_total = parseFloat( document.getElementById("total").value); 
    var t_service = parseFloat( document.getElementById("t_service").value); 
    var discount  =  parseFloat(document.getElementById("discount").value);
    var value_add = parseFloat(document.getElementById("value_add").value);
    var total = 0;
    total = sub_total ;
    total = total - (total * (discount/100));
    if(value_add == 1)
    {
      total = total + (total * 0.14 );
    }
    total = total + t_service;
    total = new Intl.NumberFormat().format(total);
    document.getElementById("f_total").value = total ;    
  }      
</script>

<script>
  $(document).ready(function() {

      $('select[name="offer_id"]').on('change', function() {
          var OfferId = $(this).val();
          if (OfferId) {
              $.ajax({
                  url: "{{ URL::to('offer_data') }}/" + OfferId,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                    document.getElementById("discount").value = data['discount'];
                    document.getElementById("t_service").value = data['t_service'];
                    document.getElementById("total").value  = data['total'];
                    document.getElementById("profit").value = data['profit'];
                    document.getElementById("c_sales").value = data['c_sales'];
                    document.getElementById("address_id").value = data['address_id'];
                    document.getElementById("ticket_id").value = data['ticket_id'];
                    updateTotal1();
                  },
              });
          } else {
              console.log('AJAX load did not work');
          }
      });

      $('select[name="stock_id"]').on('change', function() {
          $("#ticketDev").css('display','none');
          var stock_id = $(this).val();
          $.ajax({
              url: "{{ URL::to('get-offer') }}/" + stock_id,
              type: "GET",
              dataType: "json",
              success: function(data) {
                $('select[name="offer_id"]').empty();
                  $('select[name="offer_id"]').append('<option disabled selected>'+ "اختر العرض" + '</option>');
                  $.each(data, function(key, value) {
                    $('select[name="offer_id"]').append('<option value="' +value + '">' + value + '</option>');
                  });
              },
          });
          updateTotal1();
      });
  });
</script>






@endsection

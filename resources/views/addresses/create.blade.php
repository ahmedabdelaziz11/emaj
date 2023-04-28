@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

@endsection

@section('title')
    اضافة عنوان
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='product-spare') }}">عملاء الضمان</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                اضافة عنوان </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

@if(session()->has('failed') || count($errors) > 0)
  @if(count($errors) > 0)
      @foreach ($errors->all() as $error)
          <input type="hidden" id="failed[]" name="errors[]" value="{{ $error }}">
      @endforeach
  @endif
  <input type="hidden" id="failed[]" value="{{ Session::get('failed')}}">

  <script>

      var errors = document.getElementById("failed[]").value;
        window.onload = function() {
            notif({
              msg: errors,
              type: "error"
            })
        }
  </script>
@endif
@if (session()->has('success'))
  <input type="hidden" id="success" value="{{ Session::get('success')}}">
  <script>
      window.onload = function() {
          var success = document.getElementById("success").value;
          notif({    
              msg: success ,
              type: "success"
          })
      }
  </script>
@endif
    <!-- row opened -->
    <div class="row row-sm">

      <div class="col-xl-12">
          <!-- div -->
          <div class="card mg-b-20" id="tabs-style2">
              <div class="card-body">

                  <form  action="{{ route('addresses.store') }}" method="post" autocomplete="off">
                      @csrf
                      <div class="d-flex justify-content-center">
                        <h1>اضافة عنوان</h1>
                      </div>
                      <br>
                      <div class="row">

                        <div class="form-group col-6">
                          <label>الاسم</label>
                          <input class="form-control" type="text" name="name">
                        </div>

                        <div class="form-group col-6">
                          <label>المنطقة التابعة لها</label>
                          <select class="form-control select2 " id="parent_id" name="parent_id">
                            <option value=" ">اختر المنطقة</option>

                          </select>
                        </div>
                  
                      </div>

                      <button type="submit" class="btn btn-primary w-100">اضافة العنوان</button>
                    </form>
              </div>
          </div>
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
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>

  <script>
    $(document).ready(function(){
        $('.select2').select2({
          placeholder: 'Enter a parent addresse',
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
    
  <script>$(".select2").select2({placeholder:"Choose product",theme: "classic"});</script>
  <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
  <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection

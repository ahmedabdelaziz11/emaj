@extends('layouts.master')
@section('css')
@endsection
@section('title')
    الموظفين 
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الموظفين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                معلومات موظف</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{ session()->get('edit') }}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif
				<!-- row -->

					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<div class="tabs-menu ">
									<!-- Tabs -->
									<ul class="nav nav-tabs profile navtab-custom panel-tabs">
										<li class="active">
											<a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span style="font-size: 15px;font-weight: bold" class="hidden-xs"> عن الموظف</span> </a>
										</li>
										<li class="">
											<a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-cog tx-16 mr-1"></i></span> <span style="font-size: 15px;font-weight: bold" class="hidden-xs">تعديل</span> </a>
										</li>
									</ul>
								</div>
								<div class="tab-content border-left border-bottom border-right border-top-0 p-4">
									<div class="tab-pane active" id="home">
										<div class="m-t-30">
											<div class="">
												<div class="main-profile-overview">
													<div class="main-img-user profile-user">
														<img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}"><a class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
													</div>
													<div class="row">
														<div class="col">
															<div class="d-flex justify-content-between mg-b-20">
																<div>
																	<h5 style="font-weight: bold" class="main-profile-name">الاسم</h5>
																	<p  style="font-weight: bold" >{{$employee->name}}</p>
																</div>
															</div>
														</div>
														<div class="col">
															<div class="d-flex justify-content-between mg-b-20">
																<div>
																	<h5 style="font-weight: bold" class="main-profile-name">المهنة</h5>
																	<p  style="font-weight: bold" >{{$employee->role}}</p>
																</div>
															</div>
														</div>
													</div>
													<br>
													<div class="row">
															<div class="col">
														<h5 style="font-weight: bold">العنوان</h5>
														<p style="font-weight: bold">
															{{$employee->address}} 
														</p><!-- main-profile-bio -->
															</div>
															<div class="col">
														<h5 style="font-weight: bold">الرقم القومي</h5>
														<p style="font-weight: bold">
															{{$employee->national_id}} 
														</p><!-- main-profile-bio -->
															</div>
													</div>
													<div class="row">
														<div class="col">
															<div class="d-flex justify-content-between mg-b-20">
																<div>
																	<h5 style="font-weight: bold" class="main-profile-name">المرتب</h5>
																	<p  style="font-weight: bold">{{$employee->Salary}}</p>
																</div>
															</div>
														</div>
													</div>
													<hr class="mg-y-30">
													<label class="main-content-label tx-13 mg-b-20">Social</label>
													<div class="main-profile-social-list">
														<div class="media">
															<div class="media-icon bg-danger-transparent text-danger">
																<i class="ion-md-phone-portrait"></i>
															</div>
															<div class="media-body">
																<span>Phone</span> <a href="">{{$employee->phone}}</a>
															</div>
														</div>
														<div class="media">
															<div class="media-icon bg-danger-transparent text-danger">
																<i class="icon ion-md-link"></i>
															</div>
															<div class="media-body">
																<span>Emial</span> <a href="">{{$employee->email}}</a>
															</div>
														</div>
													</div>
													<hr class="mg-y-30">
													<h6>Dates</h6>
													<div class="skill-bar mb-4 clearfix mt-3">
														<span style="font-weight: bold">تاريخ الميلاد</span>
														<div style="font-size:14px " class="progress mt-2">
															{{$employee->date_of_birth}}
														</div>
													</div>
													<div class="skill-bar mb-4 clearfix mt-3">
														<span style="font-weight: bold">تاريخ بدأ العمل</span>
														<div style="font-size:14px " class="progress mt-2">
															{{$employee->start_date}}
														</div>
													</div>			
													<div class="skill-bar mb-4 clearfix mt-3">
														<span style="font-weight: bold">تاريخ انهاء العمل</span>
														<div style="font-size:14px " class="progress mt-2">
															{{$employee->end_date}}
														</div>
													</div>
												</div><!-- main-profile-overview -->
											</div>
										</div>
									</div>
									<div class="tab-pane" id="settings">
										<form action="{{route('employees.update', $employee->id)}}" method="post" autocomplete="off">
											{{ method_field('patch') }}
											{{ csrf_field() }}
												<input type="hidden" name="id" value="{{$employee->id}}">

												<div class="row">

													<div class="form-group col">
														<label for="exampleInputEmail1">اسم الموظف</label>
														<input type="text" class="form-control" value="{{$employee->name}}" id="name" name="name" required>
													</div>

													
													<div class="form-group col">
														<label for="exampleInputEmail1">الرقم القومى</label>
														<input type="number" class="form-control" value="{{$employee->national_id}}" id="national_id" name="national_id" required>
													</div>

													<div class="form-group col">
														<label>تاريخ الميلاد</label>
														<input class="form-control" name="date_of_birth" id="date_of_birth" 
														type="date" value="{{$employee->date_of_birth}}"  required>
													</div>
													
												</div>
											
						
												<div class="form-group">
													<label for="exampleFormControlTextarea1">العنوان</label>
													<textarea class="form-control" value="{{$employee->address}}" id="address" name="address" rows="1" required>{{$employee->address}}</textarea>
												</div>

												<div class="row">
													<div class="form-group col">
														<label for="exampleInputEmail1">الهاتف</label>
														<input class="form-control" value="{{$employee->phone}}"  type="number" id="phone" name="phone" required >
													</div>
							
							
													<div class="form-group col">
														<label for="exampleInputEmail1">الايميل</label>
														<input type="text" class="form-control" value="{{$employee->email}}"  id="email" name="email" required>
													</div>
												</div>

												<div class="row">
													<div class="form-group col">
														<label for="exampleInputEmail1">المهنة</label>
														<input type="text" class="form-control" value="{{$employee->role}}"  id="role" name="role" required>
													</div>
													<div class="form-group col">
														<label>المرتب</label>
														<input type="number" class="form-control" value="{{$employee->Salary}}"  id="Salary" name="Salary" required>
													</div>
												</div>
						
												<div class="row">
													<div class="form-group col">
														<label>تاريخ بدأ العمل</label>
														<input class="form-control" name="start_date"value="{{$employee->start_date}}"  id="start_date" placeholder="YYYY-MM-DD"
														type="date" value="" required>
													</div>
							
													<div class="form-group col">
														<label>تاريخ انهاء العمل</label>
														<input class="form-control fc-datepicker" value="{{$employee->end_date}}"  name="end_date" id="end_date" placeholder="YYYY-MM-DD"
														type="date" value="">
													</div>
												</div>
						
										<button type="submit" class="btn btn-primary">تاكيد</button>
									</form>
									</div>									
								</div>
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
@endsection
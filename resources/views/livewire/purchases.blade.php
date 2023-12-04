<div class="card-body">
	<div class="text-wrap">
		<div class="example">
			<div class="panel panel-primary tabs-style-2">
				<div class=" tab-menu-heading">
					<div class="tabs-menu1">
						<!-- Tabs -->
						<ul class="nav panel-tabs main-nav-line">
							<li><a href="#tab4" class="nav-link @if($page_num == null) active @endif" data-toggle="tab">طلبات الشراء</a></li>
							<li><a href="#tab5" class="nav-link" data-toggle="tab">الفواتير</a></li>
						</ul>
					</div>
				</div>
				<div class="panel-body tabs-menu-body main-content-body-right border">
					<div class="tab-content">
						<div class="tab-pane @if($page_num == null) active @endif" id="tab4">
							<div class="card-body">
								<div class="row">
									<div class="col-md-3">
										<label for="recipient-name" style="font-size: 20px;font-weight: bold;margin-right: 35px;" class="col-form-label"> البحث بالرقم او البيان </label>
									</div>
									<div class="col-md-9">
										<input class="form-control" type="text" wire:model="orderSearch" />
									</div>
								</div>
								<br>
								<div class="table-responsive">
									<table class="table table-bordered mg-b-0 text-md-nowrap">
										<thead>
											<tr class="text-center">
												<th style="font-size: 26px ;">رقم الطلب</th>
												<th style="font-size: 26px ;"> التاريخ </th>
												<th style="font-size: 26px ;">البيان</th>
												<th style="font-size: 26px ;">المنشئ</th>
												<th style="font-size: 26px ;">العمليات</th>
											</tr>
										</thead>

										<tbody>
											@foreach ($orders as $x)
											<tr style="font-size: 26px ;" class="text-center">
												<td><a href="{{ url('orders') }}/{{ $x->id }}">{{ $x->id }}</a></td>
												<td>{{ $x->date }}</td>
												<td>{{ $x->details }}</td>
												<td>{{ $x->created_by }}</td>

												<td>
													<div class="dropdown">
														<button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary btn-sm" data-toggle="dropdown" type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
														<div class="dropdown-menu tx-13">
															<button type="button" class="dropdown-item " data-toggle="modal" data-target="#delete{{ $x->id }}" title="حذف"><i class="btn btn-sm btn-danger fa fa-edit "></i> حذف</button>
														</div>
													</div>
												</td>
											</tr>
											<div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
																حذف فاتورة رقم {{$x->id}}
															</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<form action="orders/destroy" method="post">
																{{ method_field('delete') }}
																{{ csrf_field() }}
																<div class="modal-body">
																	<input type="hidden" name="id" value="{{ $x->id }}">
																	<p class="text-danger">هل انت متاكد من عملية الحذف ؟</p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
																	<button type="submit" class="btn btn-danger">تاكيد</button>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
											@endforeach
										</tbody>
									</table>
								</div>
								<br>
								<div class="row d-felx justify-content-center">
									{{ $orders->links('pagination-links') }}
								</div>
							</div>
						</div>
						<div class="tab-pane @if($page_num == 5) active @endif " id="tab5">
							<div class="card-body">
								<form action="purchases-excel" method="post">
									@csrf
									<div class="row">
										<div class="col-3">
											<label for="recipient-name" style="font-size: 20px;font-weight: bold;margin-right: 50px;" class="col-form-label">البحث بالرقم </label>
										</div>
										<div class="col-3">
											<input class="form-control" name="invoSearch" type="text" wire:model="invoSearch" />
										</div>
										<div class="col-3">
											<label for="recipient-name" style="font-size: 20px;font-weight: bold;margin-right: 50px;" class="col-form-label">البحث بطلب الشراء </label>
										</div>
										<div class="col-3">
											<input class="form-control" name="order_id" type="text" wire:model="order_id" />
										</div>
										<div class="col-md-4 mt-2">
											<button type="submit" class="btn btn-sm btn-success">اصدار شيت اكسيل</button>
										</div>
									</div>
								</form>
								<br>
								<br>
								<div class="table-responsive">
									<table class="table table-bordered mg-b-0 text-md-nowrap">
										<thead>
											<tr class="text-center">
												<th style="font-size: 26px ;">رقم الفاتورة</th>
												<th style="font-size: 26px ;">رقم اذن الاضافة</th>
												<th style="font-size: 26px ;"> التاريخ </th>
												<th style="font-size: 26px ;">الحالة</th>
												<th style="font-size: 26px ;">الاجمالى</th>
												<th style="font-size: 26px ;">العمليات</th>
											</tr>
										</thead>

										<tbody>
											@foreach ($receipts as $x)
											<tr style="font-size: 26px ;" class="text-center">
												<td><a href="{{ url('ReceiptDetails') }}/{{ $x->id }}">{{ $x->id }}</a></td>
												<td><a type="button" style="font-size: 18px;" class="dropdown-item " data-toggle="modal" data-target="#edite{{ $x->id }}" title="تعديل الرقم">{{ $x->p_num }}</a></td>
												<td>{{ $x->date }}</td>
												<td>{!! $x->type ? '<span class="text-success">مؤكدة </span>' : '<span class="text-danger">غير مؤكدة </span>'!!}</td>
												<td>{{ Number_Format($x->total,2) }}</td>
												<td>
													<div class="dropdown">
														<button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary btn-sm" data-toggle="dropdown" type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
														<div class="dropdown-menu tx-13">
															<button type="button" class="dropdown-item " data-toggle="modal" data-target="#delete{{ $x->id }}" title="حذف"><i class="btn btn-sm btn-danger fa fa-edit "></i> حذف</button>
														</div>
													</div>
												</td>
											</tr>
											<div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
																حذف فاتورة رقم {{$x->id}}
															</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<form action="receipts/destroy" method="post">
																{{ method_field('delete') }}
																{{ csrf_field() }}
																<div class="modal-body">
																	<input type="hidden" name="id" value="{{ $x->id }}">
																	<p class="text-danger">هل انت متاكد من عملية الحذف ؟</p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
																	<button type="submit" class="btn btn-danger">تاكيد</button>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>

											<div class="modal fade" id="edite{{ $x->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
																تعديل رقم اذن فاتورة رقم {{$x->id}}
															</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
														<form action="{{url('/receipts/update')}}" id="{{$x->id}}" method="post">
																{{ method_field('patch') }}
																{{ csrf_field() }}
																<div class="modal-body">
																	<input type="hidden" name="receipt_id" value="{{ $x->id }}">
																	<div class="form-group">
																		<label>رقم الاذن</label>
																		<input class="form-control" name="p_num" type="number" value="{{$x->p_num}}" required>
																	</div>
																</div>

																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
																	<button type="submit" form="{{$x->id}}" class="btn btn-danger">تاكيد</button>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
											@endforeach
										</tbody>
									</table>
								</div>
								<br>
								<div class="row d-felx justify-content-center">
									{{ $receipts->links('pagination-links') }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
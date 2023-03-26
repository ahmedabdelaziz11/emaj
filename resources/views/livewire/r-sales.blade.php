<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="card-header pb-0">
                    <div class="justify-content-between">
                        <a href="{{route('returned_invoices.create')}}" class="modal-effect btn btn-sm btn-danger" style="width: 100%;color:white;font-size: 20px;"><i class="fas fa-undo-alt"></i>&nbsp;اضافة فاتورة مرتجع</a>
                    </div>
				</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;"> البحث</label>            
                        <input  class="form-control" type="text" wire:model="search"/>
                    </div>

                    <div class="col-md-4">
                        <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;">البحث بالمخزن</label>            
                        <select wire:model="selectedStock" class="form-control">
                            <option value="" selected>اختر المخزن</option>
                            @foreach($stocks as $stock)
                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <br>
                <div class="table-responsive">
                    <table  class="table table-bordered mg-b-0 text-md-nowrap" style="text-align: center">
                        <thead>
                            <tr>
                                <th style="font-size: 16px;">رقم الفاتوره</th>
                                <th style="font-size: 16px;"> تاريخ الفاتوره</th>
                                <th style="font-size: 16px;">اصل الفاتورة</th>
                                <th style="font-size: 16px;">النوع</th>
                                <th style="font-size: 16px;">اسم العميل</th>
                                <th style="font-size: 16px;">الاجمالى</th>
                                <th style="font-size: 16px;">المخزن</th>
                                <th style="font-size: 16px;">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $x)
                            <tr style="font-size: 16px;">
                                <td><a href="{{ url('returned_invoices') }}/{{ $x->id }}">{{ $x->id }}</a></td>
                                <td>{{ $x->date }}</td>
                                <td><a href="{{ url('InvoiceDetails') }}/{{ $x->invoice_id }}">{{ $x->invoice_id }}</a></td>
                                <td><span style="font-weight: bold" @if($x->Value_Status == 0) class="text-success" @else class="text-danger" @endif >{{$x->Status}}</span></td>
                                
                                <td>{{ $x->client->name }}
                                </td>
                                <td>{{ number_format($x->total,2) }}</td>
                                <td>{{ $x->stock->name}}</td>

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
                                            <form action="returned_invoices/destroy" method="post">
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
                    <br>
                    <div class="row d-felx justify-content-center">
                        {{ $invoices->links('pagination-links') }} 
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
<!-- delete -->
<div class="modal" tabindex="-1" id="modaldemo9">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">حذف الفاتوره</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="invoices/destroy" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>هل انت متاكد من عملية الحذف ؟</p><br>
                    <input type="hidden" name="id" id="id" value="">
                    <input class="form-control" name="name" id="name" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
        </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="card-header pb-0">
                    <div class="d-flex">
                        @can('اضافة فاتورة بيع')
                        <a href="{{route('invoices.create')}}" class="modal-effect btn btn-sm btn-primary" style="color:white;font-size: 20px;width: 20%; margin-left: 15px;"><i class="fas fa-cart-plus"></i>&nbsp; اضافة فاتورة </a>
                        @endcan

                        @can('اذن صرف')
                        <a href="{{route('make-payment')}}" class="modal-effect btn btn-sm btn-success" style="color:white;font-size: 20px;width: 20%; margin-left: 15px;"><i class="fas fa-plus"></i>&nbsp;اذن صرف</a>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <form action="invoices-excel" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;"> البحث</label>
                            <input class="form-control" type="text" name="search" wire:model="search" />
                        </div>

                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;"> البحث برقم العرض</label>
                            <input class="form-control" type="text" name="offer_id" wire:model="offer_id" />
                        </div>

                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;">البحث بالمخزن</label>
                            <select wire:model="selectedStock" name="stock_id" class="form-control">
                                <option value="" selected>اختر المخزن</option>
                                @foreach($stocks as $stock)
                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-2">
                            <button type="submit" class="btn btn-sm btn-success">اصدار شيت اكسيل</button>
                        </div>
                    </div>
                </form>
                <br>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered mg-b-0 text-md-nowrap" style="text-align: center">
                        <thead>
                            <tr>
                                <th style="font-size: 16px;">رقم الفاتوره</th>
                                <th style="font-size: 16px;">رقم الاذن الصرف</th>
                                <th style="font-size: 16px;"> تاريخ الفاتوره</th>
                                <th style="font-size: 16px;">الحالة</th>
                                <th style="font-size: 16px;">النوع</th>
                                <th style="font-size: 16px;">اسم العميل</th>
                                <th style="font-size: 16px;">الاجمالى</th>
                                <th style="font-size: 16px;">المخزن</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $x)
                            <tr style="font-size: 16px;">
                                <td><a href="{{ url('InvoiceDetails') }}/{{ $x->id }}">{{ $x->id }}</a>
                                </td>
                                <td><a type="button" style="font-size: 18px;" class="dropdown-item " data-toggle="modal" data-target="#edit{{ $x->id }}" title="تعديل الرقم">{{ $x->p_num }}</a></td>
                                <td>{{ $x->date }}</td>
                                @if ($x->type == 0)
                                <td><span style="font-weight: bold" class="text-danger">غير مؤكدة</span></td>
                                @else
                                <td><span style="font-weight: bold" class="text-success">مؤكدة</span></td>
                                @endif
                                <td><span style="font-weight: bold" @if($x->Value_Status == 0) class="text-success" @else class="text-danger" @endif >{{$x->Status}}</span></td>

                                <td>{{ $x->client->name }}
                                </td>
                                <td>{{ number_format($x->total,2) }}</td>
                                <td>{{ $x->stock->name}}</td>
                            </tr>


                            <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <form action="{{ route('invoices.update',$x->id) }}" method="post" autocomplete="off">
                                                @csrf
                                                {{ method_field('patch') }}
                                                <div class="modal-body">
                                                    <input type="hidden" name="invoice_id" value="{{ $x->id }}">
                                                    <div class="form-group">
                                                        <label>رقم الاذن</label>
                                                        <input class="form-control" name="p_num" type="number" value="{{$x->p_num}}" required>
                                                    </div>
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
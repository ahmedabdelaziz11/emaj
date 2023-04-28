<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                    <a  class="modal-effect btn btn-outline-primary btn-block"
                        href="product-spare/create" style="font-size: 17px;font-weight: bold;">اضافة ضمان</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label">البحث بالاسم</label>            
                    <input  class="form-control" type="text" wire:model="search"/>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th>المنتج</th>
                            <th>العميل</th>
                            <th>الفاتورة</th>
                            <th>تاريخ البدء</th>
                            <th>تاريخ الانتهاء</th>
                            <th>الحد الاقصى</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($insurances as $x)
                            <tr class="text-center">
                                <td><a href="{{ url('insurances') }}/{{ $x->id }}">{{ $x->InvoiceProduct->product->name }}</a></td>
                                <td>   {{ $x->client->client_name }} </td>                     
                                <td><a href="{{ url('InvoiceDetails') }}/{{ $x->InvoiceProduct->invoice->id }}">{{ $x->InvoiceProduct->invoice->id }} </td>                     
                                <td>   {{ $x->start_date }} </td>        
                                <td>   {{ $x->end_date }} </td>        
                                <td>   {{ $x->compensation }} </td>        
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
                <div class="row d-felx justify-content-center">
                    {{ $insurances->links('pagination-links') }} 
                </div>                       
            </div>
        </div>
    </div>
</div>
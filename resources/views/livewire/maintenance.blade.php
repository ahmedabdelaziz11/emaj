<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                    <a  class="modal-effect btn btn-outline-primary btn-block"
                        href="maintenance-contracts/create" style="font-size: 17px;font-weight: bold;">اضافة عقد صيانة</a>
            </div>
        </div>
        <div class="card-body">
        <form name="maintenanceContractsForm" action="maintenance-excel" method="post">
            @csrf
        
            <div class="row">
                {{-- <div class="col-md-4">
                    <label for="recipient-name" class="col-form-label">المنتج</label>            
                    <input  class="form-control form-control-sm" name="product_name" type="text" wire:model="product_name"/>
                </div> --}}
                <div class="col-md-4">
                    <label for="recipient-name" class="col-form-label">العميل</label>            
                    <input  class="form-control form-control-sm" name="client_name" type="text" wire:model="client_name"/>
                </div>
                <div class="col-md-4">
                    <label for="recipient-name" class="col-form-label">تاريخ البدأ (من)</label>            
                    <input  class="form-control form-control-sm" name="start_date" type="date" wire:model="start_date"/>
                </div>
                <div class="col-md-4">
                    <label for="recipient-name" class="col-form-label">تاريخ النهاية (الى)</label>            
                    <input  class="form-control form-control-sm" name="end_date" type="date" wire:model="end_date"/>
                </div>
            </div><br><br>
            
            <div class="row">
                <div class="col-md-4">
                    <div style="position: absolute;bottom: 0px;">
                        <button type="submit" class="btn btn-sm btn-success">اصدار شيت اكسيل</button>
                        <button type="button" id="printTable" class="btn btn-sm btn-danger">طباعة الجدول</button>
                    </div>
                </div>
            </div>
        </form>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th>العميل</th>
                            <th>تاريخ البدء</th>
                            <th>تاريخ الانتهاء</th>
                            <th>قمية العقد</th>
                            <th>عدد الزيارات الدورية</th>
                            <th>عدد الزيارات الطارئة</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($maintenance_contracts as $x)
                            <tr class="text-center">
                                <td><a href="{{ url('maintenance-contracts') }}/{{ $x->id }}">{{$x->client->name}}</a></td>
                                <td>{{ $x->start_date }}</td>        
                                <td>{{ $x->end_date }}</td>        
                                <td>{{ number_format($x->contract_amount) }}</td>        
                                <td>{{ number_format($x->periodic_visits_count) }}</td>        
                                <td>{{ number_format($x->emergency_visits_count) }}</td>        
                                <td>
                                    <a class="modal-effect btn btn-sm btn-warning" 
                                        href="/maintenance-contracts/{{$x->id}}" title="مشاهدة"> <i class="las la-eye"></i> 
                                    </a>
                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-id="{{ $x->id }}" data-name="{{ $x->client->name }}"
                                        data-toggle="modal" href="#modaldemo9" title="حذف"><i class="las la-trash"></i>
                                    </a>
                                </td>        
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
                <div class="row d-felx justify-content-center">
                    {{ $maintenance_contracts->links('pagination-links') }} 
                </div>                       
            </div>
        </div>
    </div>
</div>
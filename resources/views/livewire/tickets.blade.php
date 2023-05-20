<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                    <a  class="modal-effect btn btn-outline-primary btn-block"
                        href="tickets/create" style="font-size: 17px;font-weight: bold;">اضافة شكوى</a>
            </div>
        </div>
        <div class="card-body">
        <form name="ticketForm" action="insurances-excel" method="post">
            @csrf
        
            <div class="row">
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label">العميل</label>            
                    <select wire:model="client_id" name="client_id" class="form-control">
                        <option value="" selected>اختر العميل</option>
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
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label">من تاريخ</label>            
                    <input  class="form-control" name="from_date" type="date" wire:model="from_date"/>
                </div>
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label">الى تاريخ</label>            
                    <input  class="form-control" name="to_date" type="date" wire:model="to_date"/>
                </div>
                <div class="col-md-3">
                    <div style="position: absolute;bottom: 0px;">
                        <button type="submit" class="btn btn-success">اصدار شيت اكسيل</button>
                        <button type="button" id="printTable" class="btn btn-danger">طباعة الجدول</button>
                    </div>
                </div>
            </div>
        </form>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th>رقم الشكوى</th>
                            <th>التاريخ</th>
                            <th>العميل</th>
                            <th>المنشئ</th>
                            <th>الحالة</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $x)
                            <tr class="text-center">
                                <td><a href="{{ url('tickets') }}/{{ $x->id }}">{{ $x->id }}</a></td>
                                <td>{{ $x->date }}</td>                     
                                <td>{{ $x->client->name}}</td>                     
                                <td>{{ $x->reporter->name }}</td>        
                                <td>{{ $x->state }}</td>             
                                <td>
                                    <a class="modal-effect btn btn-sm btn-warning" 
                                        href="{{route('tickets.show', $x)}}" title="مشاهدة"> <i class="las la-eye"></i> 
                                    </a>
                                    <a class="modal-effect btn btn-sm btn-primary" data-effect="effect-scale"
                                    data-id="{{ $x->id }}" data-name="{{ $x->id }}"
                                    data-toggle="modal" href="#modaldemo1" title="عرض أسعار"><i class="las la-dollar-sign"></i>
                                </a>
                                <a class="modal-effect btn btn-sm btn-secondary" data-effect="effect-scale"
                                data-id="{{ $x->id }}" data-name="{{ $x->id }}"
                                data-toggle="modal" href="#modaldemo3" title="أمر شغل"><i class="las la-briefcase"></i>
                                </a>
                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                    data-id="{{ $x->id }}" data-name="{{ $x->id }}"
                                    data-toggle="modal" href="#modaldemo2" title="إنهاء الشكوى"><i class="las la-check"></i>
                                </a>
                                </td>        
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
                <div class="row d-felx justify-content-center">
                    {{ $tickets->links('pagination-links') }} 
                </div>                       
            </div>
        </div>
    </div>
</div>
<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;">التاريخ</label>            
                    <input  class="form-control" type="date" wire:model="date"/>
                </div>

                <div class="col-md-8">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;">البيان</label>            
                    <input  class="form-control" type="text" wire:model="note"/>
                </div>

            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;">من تاريخ</label>            
                    <input  class="form-control" type="date" wire:model="from_date"/>
                </div>

                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;">الى تاريخ</label>            
                    <input  class="form-control" type="date" wire:model="to_date"/>
                </div>

                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;">مشترك به حساب (مدين)</label>            
                    <select wire:model="debt_account" class="form-control">
                        <option value="" selected>اختر الحساب</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;">مشترك به حساب (دائن)</label>            
                    <select wire:model="credit_account" class="form-control">
                        <option value="" selected>اختر الحساب</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        <br>
        <br>
            <div class="table-responsive">
                <table  class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th style="font-size: 16px;">رقم القيد</th>
                            <th style="font-size: 16px;">التاريخ</th>
                            <th style="font-size: 16px;">البيان</th>
                            <th style="font-size: 16px;">مشاهدة</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 16px;">
                        @foreach ($days as $x)
                            <tr>
                                <td class="text-center"><a href="{{ url('days') }}/{{ $x->id }}">{{ $x->id }}</a></td>
                                <td class="text-center">{{ $x->date }}</td>
                                <td class="text-center">{{ $x->note }}</td>
                                <td class="text-center">
                                    <a class="modal-effect btn btn-sm btn-success" data-effect="effect-scale"
                                        data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                        data-toggle="modal" data-target="#show{{ $x->id }}" title="مشاهدة">مشاهدة  <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade bd-example-modal-xl" id="show{{ $x->id }}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="myExtraLargeModalLabel">
                                                <a href="{{ url('days') }}/{{ $x->id }}">{{ $x->id }} قيد رقم </a>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div class="row" style="min-height: 80px;">
                                                <div style="font-size: 28px;font-weight: 100;border: 1px solid rgb(177, 170, 170);" class="col-3">اسم الحساب</div>
                                                <div style="font-size: 28px;font-weight: 100;border: 1px solid rgb(177, 170, 170);" class="col-3">مدين</div>
                                                <div style="font-size: 28px;font-weight: 100;border: 1px solid rgb(177, 170, 170);" class="col-3">دائن</div>
                                                <div style="font-size: 28px;font-weight: 100;border: 1px solid rgb(177, 170, 170);" class="col-3">بيان</div>
                                            </div>
                                            @foreach($x->day2 as $x)
                                                <div class="row" style="min-height: 80px;">
                                                    <div style="font-size: 24px;font-weight: 100;border: 1px solid rgb(177, 170, 170);" class="col-3">{{$x->account->name }}</div>
                                                    <div style="font-size: 24px;font-weight: 100;border: 1px solid rgb(177, 170, 170);" class="col-3">{{number_format($x->debit,2)}}</div>
                                                    <div style="font-size: 24px;font-weight: 100;border: 1px solid rgb(177, 170, 170);" class="col-3">{{number_format($x->credit,2)}}</div>
                                                    <div style="font-size: 24px;font-weight: 100;border: 1px solid rgb(177, 170, 170);" class="col-3">{{$x->note}}</div>
                                                    
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>                    
            </div>
        </div>
    </div>
</div>

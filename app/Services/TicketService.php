<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\CompensationType;
use App\Models\InsuranceSerial;
use App\Models\MaintenanceContract;
use App\Models\products;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class TicketService
{
    public function store($formData)
    {
        // dd($formData);
        $ticket = DB::transaction(function () use ($formData) {

            $ticket = Ticket::query()->create([
                'client_id' => $formData['client_id'],
                'reporter_id' => auth()->id(),
                'reporter_type' => 'user',
                'state' => 'pending',
                'date' => $formData['date'],
                'ticket_type' => $formData['ticket_type'],
                'address' => $formData['address'],
            ]);
            $ticketProductPivot = [];
            switch ($formData['ticket_type']) {
                case 'warranty':
                    foreach ($formData['invoice_product_ids'] as $key => $value) {
                        $product = InsuranceSerial::find($value)->insurance->invoiceProduct->product;
                        $ticketProductPivot[] = [
                            'product_id' => $product->id,
                            'details' => (isset($formData['descriptions'][$key])) ? $formData['descriptions'][$key] : null,
                        ];
                    }
                    break;
                case 'other':
                    foreach ($formData['invoice_product_ids'] as $key => $value) {
                        $product = MaintenanceContract::find($value)->product;
                        $ticketProductPivot[] = [
                            'product_id' => $product->id,
                            'details' => (isset($formData['descriptions'][$key])) ? $formData['descriptions'][$key] : null,
                        ];
                    }
                    break;
                default:
                    foreach ($formData['invoice_product_ids'] as $key => $value) {
                        $product = products::find($value);
                        $ticketProductPivot[] = [
                            'product_id' => $product->id,
                            'details' => (isset($formData['descriptions'][$key])) ? $formData['descriptions'][$key] : null,
                        ];
                    }
                    break;
            }

            $ticket->ticketProduct()->createMany($ticketProductPivot);
            if (array_key_exists('parent_id', $formData) && !empty($formData['parent_id'])) {
                $ticket->parent_id = $formData['parent_id'];
                $ticket->save();
            } else {
                $ticket->saveAsRoot();
            }
            return $ticket;
        });
        return $ticket;
    }

    public function update(Ticket $ticket, $formData)
    {
        // dd($formData);
        $ticket->update([
            'date' => $formData['date'],
            'address' => $formData['address'],
        ]);
        if (array_key_exists('compensation_type', $formData) && !empty($formData['compensation_type'])) {
            $this->createTicketCompensation($ticket, $formData);
        }
        if (array_key_exists('details', $formData) && !empty($formData['details'])) {
            $this->createTicketDetails($ticket, $formData);
        }
        return $ticket;
    }

    public function createTicketLog(Ticket $ticket, $state = 'created', $action = null)
    {
        return $ticket->logs()->create([
            'state' => $state,
            'actor_type' => 'user',
            'actor_id' => auth()->id(),
            'action' => $action,
        ]);
    }

    public function createTicketDetails(Ticket $ticket, $formData)
    {
        if ($formData['details'] && !empty($formData['details'])) {
            $ticket->details()->create([
                'details' => $formData['details']
            ]);
        }
    }

    public function createTicketCompensation(Ticket $ticket, $formData)
    {
        if (!array_key_exists('compensation_type', $formData) || empty($formData['compensation_type'])) {
            return;
        }
        $compensations = [];
        foreach ($formData['compensation_type'] as $key => $value) {
            $compensations[] = [
                'ticket_id' => $ticket->id,
                'compensation_type_id' => $value,
                'amount' => $formData['value'][$key]
            ];
        }
        $this->createTicketLog($ticket, 'updated', 'تم إضافة تكاليف للطلب');
        $ticket->compensationPivot()->delete();
        $ticket->compensationPivot()->createMany($compensations);
    }
    public function closeTicket(Ticket $ticket, $formData)
    {
        if (array_key_exists('compensation_type', $formData) && !empty($formData['compensation_type'])) {
            $this->createTicketCompensation($ticket, $formData);
        }
        if ($formData['feedback'] && $formData['feedback'] != '') {
            switch ($formData['feedback']) {
                case '1':
                    $this->finishTicket($ticket, 'تم خل المشكلة');
                    break;
                case '2':
                    $this->finishTicket($ticket, 'لم يتم حل المشكلة');
                    break;
            }
        }
        if ($formData['closing_note'] && $formData['closing_note'] != '') {
            $ticket->update([
                'closing_note' => $formData['closing_note'],
            ]);
        }
    }
    public function finishTicket(Ticket $ticket, $feedback)
    {
        $ticket->update([
            'state' => 'closed',
            'feedback' => $feedback,
        ]);
        $this->createTicketLog($ticket, 'updated', 'تم إغلاق الطلب');
    }

    public function assignTicketEmployees(Ticket $ticket, $formData)
    {
        $this->createTicketEmployee($ticket, $formData);
    }
    public function createTicketEmployee(Ticket $ticket, $formData)
    {
        if (!array_key_exists('employees', $formData) || empty($formData['employees'])) {
            return;
        }
        $employees = [];
        foreach ($formData['employees'] as $value) {
            $employees[] = [
                'ticket_id' => $ticket->id,
                'employee_id' => $value,
                'date' => now()
            ];
        }
        $ticket->employeePivot()->createMany($employees);
        if ($ticket->getRawOriginal('state') == 'pending') {
            $this->createTicketLog($ticket, 'updated', 'تم تعديل موظفين الطلب');
            $ticket->update([
                'state' => 'in_progress',
            ]);
            return;
        }
        // dd($ticket->getRawOriginal('state'));
        $this->createTicketLog($ticket, 'updated', 'تم تعيين موظفين للطلب');
        
    }

    public function getAllTickets($client_id = null, $from_date = null, $to_date = null, $state = null)
    {
        return Ticket::when($client_id,function($q,$client_id){
            $q->where('client_id',$client_id);
        })
        ->when($from_date,function($q,$from_date){
            $q->where('date','<=',$from_date);
        })
        ->when($to_date,function($q,$to_date){
            $q->where('date','>=',$to_date);
        })
            ->when($state, function ($q, $state) {
                $q->where('state', $state);
            })
        ->orderBy('id','desc')->paginate(15);
    }

    function getTicketReports($formData)
    {
        $tickets = Ticket::query();
        // dd($formData);
        if (array_key_exists('client_id', $formData) && !empty($formData['client_id'])) {
            $tickets->where('client_id', $formData['client_id']);
        }
        if (array_key_exists('from_date', $formData) && !empty($formData['from_date'])) {
            $tickets->where('date', '>=', $formData['from_date']);
        }
        if (array_key_exists('to_date', $formData) && !empty($formData['to_date'])) {
            $tickets->where('date', '<=', $formData['to_date']);
        }
        if (array_key_exists('state', $formData) && !empty($formData['state'])) {
            $tickets->where('state', $formData['state']);
        }
        if (array_key_exists('ticket_type', $formData) && !empty($formData['ticket_type'])) {
            $tickets->where('ticket_type', $formData['ticket_type']);
        }
        if (array_key_exists('product', $formData) && !empty($formData['product'])) {
            $tickets->where('invoice_product_id', $formData['product']);
        }
        if (array_key_exists('employees', $formData) && !empty($formData['employees'][0])) {
            // dd($formData['employees']);
            $joins = Ticket::query()
                ->join('employee_ticket', 'tickets.id', '=', 'employee_ticket.ticket_id')
                ->whereIn('employee_ticket.employee_id', $formData['employees'])
                ->select('tickets.id')
                ->get()
                ->toArray();
            $tickets->whereIn('id', $joins);
            // dd($tickets->toSql());
        }

        return $tickets->get();
    }

    public function getCompensationTypes()
    {
        return CompensationType::all();
    }

    public function getTicketSpareProduct(Ticket $ticket,Stock $stock)
    {
        if($ticket->ticket_type == 'warranty')
        {
            return InsuranceSerial::find($ticket->invoice_product_id)->insurance->invoiceProduct->product->spares;
        }
        return products::query()
            ->select('name','id','selling_price')
            ->whereHas('stock',function($q)use($stock){
                $q->where('stock_id',$stock->id);
        })->get();
    }

    function getProductSpareProducts($productId)
    {
        return products::find($productId)->spares;
    }
}

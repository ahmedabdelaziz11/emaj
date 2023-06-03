<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Events\TicketCreated;
use App\Http\Requests\StoreTicket;
use App\Http\Requests\UpdateTicket;
use App\Models\AllAccount;
use App\Models\Employee;
use App\Services\TicketService;
use App\Events\TicketUpdated;
use App\Models\Stock;

class TicketController extends Controller
{
    protected $ticketService;
    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::select('id', 'name')
        ->pluck('name', 'id')
            ->toArray();
        
        $compensationTypes = $this->ticketService->getCompensationTypes();
        return view('ticket.index', compact('compensationTypes', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\ResponsegetAllTickets
     */
    public function create()
    {
        $clients = AllAccount::select('id', 'name')
            ->clients()
            ->with('accounts')
        ->get();
        return view('ticket.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicket $request)
    {
        $ticket = $this->ticketService->store($request->all());
        event(new TicketCreated($ticket, $request->all()));
        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Ticket created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $ticketCollection = collect();
        $ticket->load('details', 'logs', 'compensationPivot', 'employeePivot', 'reporter', 'client', 'invoiceProduct', 'compensationType', 'invoice.prodcuts');
        $ticketCollection->push($ticket->details, $ticket->logs, $ticket->compensationPivot, $ticket->employeePivot);
        $ticketCollection = $ticketCollection->flatten()->sortBy('created_at', SORT_REGULAR, false);
        return view('ticket.show', compact('ticket', 'ticketCollection'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        return view('ticket.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicket $request, Ticket $ticket)
    {
        $this->ticketService->update($ticket, $request->all());
        event(new TicketUpdated($ticket, $request->all()));
        return redirect()->route('tickets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function createCompensation(Ticket $ticket)
    {
        return view('ticket.compensation', compact('ticket'));
    }

    public function closeTicket(Ticket $ticket, Request $request)
    {
        $this->ticketService->closeTicket($ticket, $request->all());
        return redirect()->route('tickets.index');
    }

    public function assignTicketEmployees(Ticket $ticket, Request $request)
    {
        $this->ticketService->assignTicketEmployees($ticket, $request->all());
        return redirect()->route('tickets.index');
    }

    public function ticketSpareProducts(Ticket $ticket,Stock $stock)
    {
        $products = $this->ticketService->getTicketSpareProduct($ticket,$stock);
        return json_encode($products);
    }

}

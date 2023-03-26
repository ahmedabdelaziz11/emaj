<?php

namespace App\Http\Controllers;

use App\Models\AllAccount;
use App\Models\Asset;
use App\Models\day;
use App\Models\DayDetails;
use App\Models\MokhssElahlak;
use DateTime;
use Illuminate\Http\Request;

class AssetManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // MokhssElahlak::where('year','!=',null)->delete();
        $accounts = AllAccount::assets()->get();
        $all_accounts = AllAccount::all();
        return view('assets.index',compact('accounts','all_accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asset = Asset::create([
            'price' => $request->price,
            'date' => $request->date,
            'mokhss_elahlak' => $request->mokhss_elahlak,
            'quantity' => $request->quantity,
            'account_id' => $request->account_id,
        ]);

        $day = day::create([
            'date' => $request->date,
            'note' => "اصل ثابت",
            'type' => 9,
            'type_name' => 'اصل ثابت',
            'type_id' => $asset->id,
            'total' => $request->price * $request->quantity,
            'cost_id' => null ,
        ]);

        $asset->update([
            'start_day' => $day->id,
        ]);

        DayDetails::create([
            'date' => $request->date,
            'day_id' => $day->id,
            'account_id' => $request->account_id,
            'debit' => $request->price * $request->quantity,
            'credit' => 0,
            'note' => $request->note,
            'cost_id' =>null ,
        ]);

        DayDetails::create([
            'date' => $request->date,
            'day_id' => $day->id,
            'account_id' => $request->all_account_id,
            'debit' => 0,
            'credit' => $request->price  * $request->quantity,
            'note' => $request->note,
            'cost_id' =>null ,
        ]);

        return redirect('/asset-management')->with('mss','تم اضافة القيد بنجاح'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $asset =  Asset::find($request->id);
        if($asset->start_day != null)
        {
            DayDetails::where('day_id',$asset->start_day)->delete();
            Day::find($asset->start_day)->delete();
        }
        $asset->delete();
        session()->flash('delete','تم الحذف بنجاح');
        return back();
    }

    public function mokhss_elahlak()
    {
        $assets = Asset::all();
        $total = 0;
        foreach($assets as $asset)
        {
            $duration = 12;

            $diff = abs(strtotime('2022-12-31') - strtotime($asset->date));
            $years = floor($diff / (365*60*60*24));
            if( $years == 0)
            {
                $duration = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            }
            $price = $asset->price;
            $elmokhssat = MokhssElahlak::where('asset_id',$asset->id)->get();
            foreach($elmokhssat as $x)
            {
                $price -= $x->value ;
            }
            $elnsba = ( $asset->mokhss_elahlak / 100 ) * ($duration / 12) * $price;
            MokhssElahlak::create([
                'asset_id' => $asset->id,
                'year' => '2022',
                'value' => $elnsba,
            ]);
            $total += $elnsba;            
        }
        return $total;
    }

    public function show_mokhss_elahlak()
    {
        return view('assets.mokhss-elahlak');
    }

    public function create_mokhss_elahlak(Request $request)
    {
        $year = $request->year;
        $mokhss = MokhssElahlak::where('year',$year)->get();
        return view('assets.mokhss-elahlak',compact('year','mokhss'));
    }
}

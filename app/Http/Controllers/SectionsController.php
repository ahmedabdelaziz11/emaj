<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use App\Models\Stock;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::all();
        $sections = sections::all();
        return view('sections.sections',compact('sections','stocks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(['name' => 'required|unique:sections|max:255',],['name.required' =>'يرجي ادخال اسم القسم','name.unique' =>'اسم القسم مسجل مسبقا',]);
        
        sections::create($request->all());

        session()->flash('mss', 'تم اضافة القسم بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock = Stock::find($id);
        return json_encode($stock->products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, ['name' => 'required|max:255|unique:sections,name,'.$request->id,],['name.required' =>'يرجي ادخال اسم القسم','name.unique' =>'اسم القسم مسجل مسبقا',]);

        sections::find($request->id)->update($request->all());
        session()->flash('mss','تم تعديل القسم بنجاج');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        session()->flash('del','لا يمكن حذف القسم ');
        if(products::where('section_id',$request->id)->count() == 0)
        {
            $section = sections::find($request->id);
            $section->delete();
            session()->flash('del','تم حذف القسم بنجاح');
        }
        return back();
    }
}

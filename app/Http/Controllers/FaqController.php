<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Faq;
use Exception;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['faqs'] = Faq::latest()->paginate(10);
        return view('admin.faq.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['faq'] = new Faq();
        return view('admin.faq.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
        ]);

        try {
            
            $input = $request->all();
            $faq = Faq::updateOrCreate([
                'id' => Helper::decodeId($request->faq_id)
            ], $input);

            return redirect()->route('faq.edit', Helper::encodeId($faq->id))->with('success', $request->has('faq_id') ? 'Faq Updated Successfully' : 'Faq Created Successfully'); 

        } catch (Exception $ex) {
            Helper::throwExeception($ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data['faq'] = Faq::find(Helper::decodeId($request->faq));
        return view('admin.faq.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Faq::where('id', Helper::decodeId($request->faq))->delete();
        return redirect()->back()->with('success', 'Faq Deleted Successfully');
    }
}

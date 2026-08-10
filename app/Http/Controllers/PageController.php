<?php

namespace App\Http\Controllers;

use App\Channels\SmsChannel;
use App\Helpers\Helper;
use App\Models\Order;
use App\Models\Page;
use App\Models\User;
use App\Notifications\NewAdminOrder;
use App\Notifications\NewCustomerOrder;
use App\Notifications\ReferralEarning;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use RobinCSamuel\LaravelMsg91\Facades\LaravelMsg91;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pages'] = Page::latest()->paginate(10);
        return view('admin.page.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page'] = new Page();
        return view('admin.page.create', $data);
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
            'content' => 'required',
        ]);

        try {
            
            $input = $request->all();
            $input['user_id'] = auth()->user()->id;

            if($request->has('featured_image')){
                $fname = Str::random(10).'_'.$request->featured_image->getClientOriginalName();
                $request->featured_image->storeAs('public/page', $fname);
                $input['featured_image'] = 'page/'.$fname;
            }

            $input['slug'] = Helper::createSlug($request->slug=='' ? $request->title : $request->slug);
            $page = Page::updateOrCreate([
                'id' => Helper::decodeId($request->page_id)
            ], $input);

            return redirect()->route('page.edit', Helper::encodeId($page->id))->with('success', $request->has('page_id') ? 'Page Updated Successfully' : 'Page Created Successfully'); 

        } catch (Exception $ex) {
            Helper::throwExeception($ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data['page'] = Page::where('slug', $slug)->first();
        if(empty($data['page'])) abort(404);
        return view('pages.page_layout', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data['page'] = Page::find(Helper::decodeId($request->page));
        return view('admin.page.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Page::where('id', Helper::decodeId($request->page))->delete();
        return redirect()->back()->with('success', 'Page Deleted Successfully');
    }
}

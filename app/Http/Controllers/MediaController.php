<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class MediaController extends Controller
{
    public function destroy($id)
    {
        Media::find(Helper::decodeId($id))->delete();
        return Redirect::to(URL::previous() . "#images-tab")->with('success', 'File Deleted Successfully!');
    }
}

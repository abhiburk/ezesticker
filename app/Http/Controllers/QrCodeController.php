<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Product;
use App\Models\QrCode;
use Exception;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode as FacadesQrCode;
use ZipArchive;

class QrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
         
        $query = QrCode::with('qr_detail');

        if($request->sort == 'new') $query->latest();
        if($request->sort == 'old') $query->orderBy('id', 'desc');
        if($request->sort == 'verified') $query->where('qr_verified_at', '!=', '');
        
        $data['qr_codes'] = $query->paginate(10);
        $data['products'] = Product::all();
        return view('admin.qr-code.index', $data);
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
        $this->validate($request, [
            'no_of_qrcode' => 'required|numeric',
            'type' => 'required'
        ]);

        try {
            set_time_limit(0);
            $ids = [];
            for ($i=1; $i <= ($request->no_of_qrcode); $i++) {
                $qr = new QrCode();
                $qr->type = $request->type;
                $qr->save();
                $ids[] = $qr->id; 
            }
            $url = empty($request->url) ? env('APP_URL') : $request->url;
            if(GENERATE_QR_ZIP){
                if($request->type == 'smart-vehicle-sticker')
                    $this->archive($ids, 'Sticker-Mockup-1.jpeg',$request->type, 1000, 650, 650, $url);
                if($request->type == 'smart-mini-sticker')
                    $this->archive($ids, 'Sticker-Mockup-2.jpeg',$request->type, 600, 125, 300, $url);
            }
            
            return redirect()->back()->with('success', 'QR Code Generated Successfully'); 

        } catch (Exception $ex) {
            Helper::throwExeception($ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QrCode  $qrCode
     * @return \Illuminate\Http\Response
     */
    public function show(QrCode $qrCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QrCode  $qrCode
     * @return \Illuminate\Http\Response
     */
    public function edit(QrCode $qrCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QrCode  $qrCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QrCode $qrCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QrCode  $qrCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        QrCode::where('id', Helper::decodeIdForQr($request->qrcode))->delete();
        return redirect()->back()->with('success', 'QR Code Deleted Successfully');
    }

    private function archive($ids, $mockup, $type, $size, $x, $y, $url){

        $files = [];

        // prepare zip name 
        $zip_name = $ids[0].'-'.$ids[count($ids)-1].'-'.$type.'-'.parse_url($url)['host'].'-'.time();
        $folder = "storage/qrcode/".$zip_name;

        // iterate through ids
        foreach ($ids as $key => $value) {
            // $url = route('qr.show_details', Helper::encodeIdForQr($value));
            $url = $url.'/qr/'.Helper::encodeIdForQr($value);
            $wh = $size.'x'.$size;
            // $path = "https://api.qrserver.com/v1/create-qr-code/?size=$wh&data=$url";

            if(!File::exists('storage/qrcode/qr-list')) {
                File::makeDirectory('storage/qrcode/qr-list');
            }

            // generate QR code in qr-list folder.
            $path = 'storage/qrcode/qr-list/'.Helper::encodeIdForQr($value).'.png';
            FacadesQrCode::format('png')->size($size)
            ->generate($url, 'storage/qrcode/qr-list/'.Helper::encodeIdForQr($value).'.png');
            
            // place qr code on the Mockup Design image.
            $dest = imagecreatefromjpeg( ('frontend/img/'.$mockup) );
            $src = imagecreatefrompng($path);
            imagealphablending($dest, false);
            imagesavealpha($dest, true);

            // Copy and merge image
            imagecopymerge($dest, $src, $x, $y, 0, 0, $size, $size, 100);
            if(!File::exists($folder)) {
                File::makeDirectory($folder);
            }
            // save combine image to qrcode directory
            imagejpeg($dest, $folder.'/'.$value.".jpeg",90);
            $files[] = $folder.'/'.$value.".jpeg";
        }

        // make a zip for combined images.
        $this->downloadZip($files, $zip_name);

        // delete combine image folder and qrlist folder
        File::deleteDirectory($folder);
        File::deleteDirectory('storage/qrcode/qr-list');

    }

    private function downloadZip($files, $zip_name) {
        $zip = new \ZipArchive();
        $fileName = 'storage/qrcode/'.$zip_name.'.zip';
        if(!File::exists($fileName)) {
            touch($fileName);
        }
        if ($zip->open($fileName, \ZipArchive::CREATE)== TRUE){
            foreach ($files as $key => $value){
                $download_file = file_get_contents($value);
                $zip->addFromString(basename($value), $download_file);
            }
            $zip->close();
        }

        return response()->download($fileName);
    }
}

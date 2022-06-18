<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\History;
class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $all_history = History::where('user_id', Auth::id())->get();

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil menampilkan history!',
                    'data' => $all_history
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal register! Error : ' . $e->getMessage(),
                ]);
        }
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
        try {
            $user = User::where('id', Auth::id())->first();
            $fcm_token = $user->fcm_token;
            $url_gmap = 'google.com/maps/?q='.$request->latitude.','.$request->longitude;
            $sekarang = Carbon::parse(Carbon::now())->format('H:i:s'); 
            $url = 'https://fcm.googleapis.com/fcm/send';
            
            $FcmKey = 'AAAA3-X7Fv4:APA91bGSFy43ClzXNtmZdak-P48lSx4vrVf-Mx2jwV-QYwjNxSkSGpER5zvCuoTkj2yEIe24OMhPNjMASKIqF7gQkFhgodQqYG60XIXf3_5mWQUjX48hUqjasjtOtXJHU2nfNIHkSTWL';
    
            $data = [
                "registration_ids" => [$fcm_token],
                "notification" => [
                    "title" => $title,
                    "body" => $text,
                ],
                "data" => [
                    "msgId" => "msg_12342"
                ]
            ];
    
            $RESPONSE = json_encode($data);
    
            $headers = [
                'Authorization:key=' . $FcmKey,
                'Content-Type: application/json',
            ];
    
            // CURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $RESPONSE);
    
            $output = curl_exec($ch);
            if ($output === FALSE) {
                die('Curl error: ' . curl_error($ch));
            }
            curl_close($ch);
    
            $history = History::create([
                'title' => Auth::user()->name.' terjatuh pada '.$sekarang,
                'description' => 'Lokasi jatuh : '.$url_gmap,
                'happened_time' => Carbon::now(),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'user_id' => Auth::id(),
            ]);

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil menambahkan history!',
                    'data' => $history
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal register! Error : ' . $e->getMessage(),
                ]);
        }
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
    public function destroy($id)
    {
        //
    }
}

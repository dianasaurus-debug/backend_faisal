<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\History;
use App\User;
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
            
            $FcmKey = 'AAAAXA3M_OI:APA91bG5hvQfoDbq5GPgM2AY47lF0RiLYw996FpPggh8p9IE12ueebV2Uw1XgTjb10oM0UO6sAFUq67J2FFp2lf6q4_Fk471DOtcFuyONxu6ZZ-zNZEUjb6bxRFSW1L3-57j9aFvT-VH';
            $title = 'Anda terjatuh!!!!';
            $text = 'Bantuan akan dikirim ke kontak melalui Whatsapp';
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

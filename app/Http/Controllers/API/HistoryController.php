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
            $url_gmap = 'google.com/maps/?q='.$request->latitude.','.$request->longitude;
            $sekarang = Carbon::parse(Carbon::now())->format('H:i:s'); 
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

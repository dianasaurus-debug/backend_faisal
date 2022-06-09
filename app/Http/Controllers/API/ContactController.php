<?php

namespace App\Http\Controllers\API;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $all_contact = Contact::where('user_id', Auth::id())->get();

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil menampilkan kontak!',
                    'data' => $all_contact
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
            $contact = Contact::create([
                'name' => $request->name,
                'role' => $request->role,
                'phone' => $request->phone,
                'user_id' => Auth::id(),
            ]);

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil menambahkan kontak!',
                    'data' => $contact
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

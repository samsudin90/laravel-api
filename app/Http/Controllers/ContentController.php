<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\content;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = content::orderBy('created_at', 'DESC')->get();

        return response()->json([
            'mesage' => 'list content',
            'data' => $data
        ],200);
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
        $validator = Validator::make($request->all(), [
            'judul' => ['required'],
            'link' =>['required']
        ]);

        // cek validasi
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $content = content::create($request->all());
            return response()->json([
                'mesage' => 'content created',
                'data' => $content
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'mesage' => 'Failed ' .$e->errorInfo()
            ], 203);
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
        $content = content::findOrFail($id);

        return response()->json([
            'mesage' => 'content by id',
            'data' => $content
        ],200);
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
        $content = content::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'judul' => ['required'],
            'link' =>['required']
        ]);

        // cek validasi
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $content->update($request->all());
            return response()->json([
                'mesage' => 'content updated',
                'data' => $content
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'mesage' => 'Failed ' .$e->errorInfo()
            ], 203);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content = content::findOrFail($id);

        try {
            $content->delete();
            return response()->json([
                'mesage' => 'content deleted'
            ],200);
        } catch (QueryException $e) {
            return response()->json([
                'mesage' => 'Failed ' .$e->errorInfo
            ]);
        }


    }
}

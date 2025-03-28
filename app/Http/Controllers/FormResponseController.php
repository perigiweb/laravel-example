<?php

namespace App\Http\Controllers;

use App\Models\FormResponse;
use Illuminate\Http\Request;

class FormResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $formResponses = FormResponse::where('user_id', $request->user()->id)->paginate(20);
        return view('form.response-list', compact('formResponses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FormResponse $formResponse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormResponse $formResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormResponse $formResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormResponse $formResponse)
    {
        //
    }
}

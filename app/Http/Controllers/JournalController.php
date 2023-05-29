<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorejournalRequest;
use App\Http\Requests\UpdatejournalRequest;
use App\Models\journal;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorejournalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(journal $journal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatejournalRequest $request, journal $journal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(journal $journal)
    {
        //
    }
}

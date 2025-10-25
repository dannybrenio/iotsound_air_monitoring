<?php

namespace App\Http\Controllers;

use App\Models\History_status;
use Illuminate\Http\Request;

class HistoryStatusController extends Controller
{
   
    public function index()
    {
        $history_status = History_status::all();
        return view('admin.status.history_status', compact('history_status'));
    }

 
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

  
    public function show(History_status $history_status)
    {
        //
    }

   
    public function edit(History_status $history_status)
    {
        //
    }

   
    public function update(Request $request, History_status $history_status)
    {
        //
    }

    public function destroy(History_status $history_status)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Categories;
use App\Models\History;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    public function index()
    {

        $categories = Categories::get();
        return view('pages.tickets.index', compact('categories'));
    }

    public function store(Request $request)
    {

        dd($request->all());
        
        try {
            $request->validate([
                'date' => 'required',
                'category_id' => 'required',
            ]);

            $ticket = new Tickets();
            $ticket->user_id = Auth::user()->id;
            //  $ticket->no jadikan 10 karakter, IT tahun bulan TGL 3 no urut dari data Tickets jadinya IT25092001
            // $ticket->no = ;
            $ticket->date = $request->date;
            $ticket->category_id = $request->category_id;
            $ticket->desc = $request->desc;

            $ticket->save();

            $history = new History();
            $history->ticket_id = $ticket->id;
            $history->date = $request->date;
            $history->status_id = 1;
            $history->user_id = Auth::user()->id;

            $attachments = new Attachments();
            $attachments->ticket_id = $ticket->id;
            $attachments->request_id = Auth::user()->id;
            // $attachments->path jadikan upload file, generate path 20 karakter IT25092001_generate 11 angka
            // $attachments->path = ;
            $attachments->save();

            return redirect()->back()->with('success', 'Successfully.');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

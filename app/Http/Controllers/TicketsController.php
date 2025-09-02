<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Categories;
use App\Models\History;
use App\Models\Tickets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{

    public function index()
    {
        $ticket = Tickets::with([
            'category:id,name',
            'user:id,name',
            'latestHistory'
        ])
            ->orderBy('created_at', 'desc')
            ->get();
        $categories = Categories::get();
        return view('pages.tickets.index', compact('categories', 'ticket'));
    }

    public function store(Request $request)
    {

        try {

            $request->validate([
                'date' => 'required|date',
                'category_id' => 'required',
                'attachments.*' => 'file|mimes:pdf,docx,png,jpg,jpeg,xlsx,csv,zip|max:20480' // 20MB
            ]);

            // ====== Generate Ticket Number ======
            $today = Carbon::now()->format('ym');
            $prefix = "IT" . $today;

            $countToday = Tickets::whereDate('created_at', now()->toDateString())->count() + 1;
            $seq = str_pad($countToday, 3, '0', STR_PAD_LEFT);

            $ticketNo = $prefix . $seq;
            // ====== Save Ticket ======
            $ticket = new Tickets();
            $ticket->user_id = Auth::user()->id;
            $ticket->no = $ticketNo;
            $ticket->date = $request->date;
            $ticket->category_id = $request->category_id;
            $ticket->desc = $request->desc;
            $ticket->save();

            // ====== Save History ======
            $history = new History();
            $history->ticket_id = $ticket->id;
            $history->date = $request->date;
            $history->status_id = 1;
            $history->user_id = Auth::user()->id;

            $history->save();

            // ====== Handle Attachments ======
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $attachments = new Attachments();
                    $attachments->ticket_id = $ticket->id;
                    $attachments->request_id = Auth::user()->id;

                    $randNum = str_pad(mt_rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
                    $fileName = $ticketNo . '_' . $randNum . '.' . $file->getClientOriginalExtension();

                    $path = $file->storeAs('tickets', $fileName, 'public');

                    $attachments->path = $path;
                    $attachments->save();
                }
            }

            return redirect()->back()->with('success', 'Ticket created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to create ticket: ' . $th->getMessage());
        }
    }
}

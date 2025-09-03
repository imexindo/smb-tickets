<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Categories;
use App\Models\History;
use App\Models\Status;
use App\Models\Tickets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

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
                'attachments.*' => 'file|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,application/x-rar-compressed,image/png,image/jpeg,text/csv,application/octet-stream|max:51200'
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
            Log::error('Ticket creation failed', [
                'error_message' => $th->getMessage(),
                'error_file' => $th->getFile(),
                'error_line' => $th->getLine(),
                'stack_trace' => $th->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Failed to create ticket. Please check logs.' . $th->getMessage());
        }
    }


    public function edit($id)
    {

        $decryptedId = Crypt::decrypt($id);

        try {

            $ticket = Tickets::with([
                'category:id,name',
                'user:id,name',
                'user.groupuser.department',
                'latestHistory.status:id,name,name_by_req,name_by_recv,bg_color,next_action',
                'attachments'
            ])
                ->orderBy('created_at', 'desc')
                ->find($decryptedId);

            $status = Status::get();

            return response()->json([
                'data' => $ticket,
                'message' => 'Successfully'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'message' => $th->getMessage()
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);

            $request->validate([
                'date' => 'required|date',
                'category_id' => 'required',
                'status_id' => 'required|integer',
                'remark' => 'nullable|string',
                'attachments.*' => 'file|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,application/x-rar-compressed,image/png,image/jpeg,text/csv,application/octet-stream|max:51200'
            ]);

            // === Update Ticket ===
            $ticket = Tickets::findOrFail($decryptedId);
            $ticket->category_id = $request->category_id;
            $ticket->desc        = $request->desc;
            $ticket->save();

            // === Tambah History Baru ===
            $history = new History();
            $history->ticket_id = $ticket->id;
            $history->date      = $request->date;
            $history->status_id = $request->status_id;
            $history->remark    = $request->remark;
            $history->user_id   = Auth::id();
            $history->save();

            // === Handle Attachments IT ===
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $attachments = new Attachments();
                    $attachments->ticket_id  = $ticket->id;
                    $attachments->approve_id = Auth::id();

                    $randNum  = str_pad(mt_rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
                    $fileName = $ticket->no . '_' . $randNum . '.' . $file->getClientOriginalExtension();

                    $path = $file->storeAs('tickets', $fileName, 'public');
                    $attachments->path = $path;
                    $attachments->save();
                }
            }

            return response()->json([
                'message' => 'Ticket updated successfully.',
                'data' => $ticket
            ]);
        } catch (\Throwable $th) {
            Log::error('Ticket update failed', [
                'error_message' => $th->getMessage(),
                'error_file' => $th->getFile(),
                'error_line' => $th->getLine(),
                'stack_trace' => $th->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'message' => 'Failed to update ticket.',
                'error' => $th->getMessage()
            ], 500);
        }
    }


    public function getData($id)
    {

        $decryptedId = Crypt::decrypt($id);
        try {
            $ticket = Tickets::with([
                'category:id,name',
                'user:id,name',
                'history.status:id,name,name_by_req,name_by_recv,bg_color',
                'attachments'
            ])
                ->orderBy('created_at', 'desc')
                ->find($decryptedId);

            return response()->json([
                'data' => $ticket,
                'message' => 'Successfully'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'message' => $th->getMessage()
            ]);
        }
    }
}

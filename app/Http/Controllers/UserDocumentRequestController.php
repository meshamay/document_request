<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDocumentRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $requests = DocumentRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingCount = $requests->where('status', 'Pending')->count();
        $inProgressCount = $requests->where('status', 'In Progress')->count();
        $completedCount = $requests->where('status', 'Completed')->count();

        return view('user.document-requests', compact(
            'requests',
            'pendingCount',
            'inProgressCount',
            'completedCount'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'length_of_residency' => 'required|string',
            'valid_id_number' => 'required|string',
            'registered_voter' => 'required|string',
            'purpose' => 'required|string',
        ]);

        $user = Auth::user();
        $documentType = 'Barangay Certificate';

        DocumentRequest::create([
            'transaction_id' => DocumentRequest::generateTransactionId($documentType),
            'user_id' => $user->id,
            'last_name' => $user->name,
            'first_name' => $user->name,
            'middle_name' => $user->middle_name,
            'document_type' => $documentType,
            'purpose' => $validated['purpose'],
            'length_of_residency' => $validated['length_of_residency'],
            'valid_id_number' => $validated['valid_id_number'],
            'registered_voter' => $validated['registered_voter'],
            'status' => 'Pending',
        ]);

        return redirect()->route('user.document-requests.index')
            ->with('success', 'Document request submitted successfully!');
    }
}

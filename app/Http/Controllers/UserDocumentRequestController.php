<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserDocumentRequestController extends Controller
{
    public function index()
    {
        // For demo purposes, show all requests (no authentication)
        $requests = DocumentRequest::orderBy('created_at', 'desc')->get();

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

        // For demo purposes, use first user or create a demo user
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]);
        }

        $documentType = 'Barangay Certificate';

        DocumentRequest::create([
            'transaction_id' => DocumentRequest::generateTransactionId($documentType),
            'user_id' => $user->id,
            'last_name' => 'Demo',
            'first_name' => 'User',
            'middle_name' => null,
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
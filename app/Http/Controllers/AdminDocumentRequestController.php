<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use Illuminate\Http\Request;

class AdminDocumentRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = DocumentRequest::query()->with('user');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('document_type', 'LIKE', "%{$search}%")
                  ->orWhere('purpose', 'LIKE', "%{$search}%");
            });
        }

        // Document type filter
        if ($request->has('document_type') && $request->document_type != '') {
            $query->where('document_type', $request->document_type);
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate counts
        $totalRequests = DocumentRequest::count();
        $pendingCount = DocumentRequest::where('status', 'Pending')->count();
        $inProgressCount = DocumentRequest::where('status', 'In Progress')->count();
        $completedCount = DocumentRequest::where('status', 'Completed')->count();

        return view('admin.document-requests', compact(
            'requests',
            'totalRequests',
            'pendingCount',
            'inProgressCount',
            'completedCount'
        ));
    }

    public function show($id)
    {
        $request = DocumentRequest::with('user')->findOrFail($id);
        return view('admin.document-request-view', compact('request'));
    }

    public function update(Request $request, $id)
    {
        $documentRequest = DocumentRequest::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $documentRequest->update($validated);

        return redirect()->route('admin.document-requests.index')
            ->with('success', 'Document request updated successfully!');
    }

    public function destroy($id)
    {
        $documentRequest = DocumentRequest::findOrFail($id);
        $documentRequest->delete();

        return redirect()->route('admin.document-requests.index')
            ->with('success', 'Document request deleted successfully!');
    }
}

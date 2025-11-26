@extends('layouts.app')

@section('title', 'Admin - Document Requests')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('admin.partials.sidebar')
    
    <div class="flex-1">
        <!-- Header -->
        <div class="bg-[#4A7BA7] text-white px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <div class="w-8 h-8 bg-[#4A7BA7] rounded-full"></div>
                </div>
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <div class="w-8 h-8 bg-[#4A7BA7] rounded-full"></div>
                </div>
                <div>
                    <div class="font-semibold">Barangay Dasang Bakal</div>
                    <div class="text-sm">Maubaniyang City</div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm underline">Logout</button>
                </form>
            </div>
        </div>

        <div class="p-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <h1 class="text-3xl mb-6">DOCUMENT REQUEST</h1>

            <!-- Status Cards -->
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="bg-[#B3D4E5] rounded-lg p-6 text-center">
                    <div class="text-3xl mb-2">{{ $totalRequests }}</div>
                    <div class="uppercase tracking-wide">Total Request</div>
                </div>
                <div class="bg-[#B3D4E5] rounded-lg p-6 text-center">
                    <div class="text-3xl mb-2">{{ $pendingCount }}</div>
                    <div class="uppercase tracking-wide">Pending</div>
                </div>
                <div class="bg-[#B3D4E5] rounded-lg p-6 text-center">
                    <div class="text-3xl mb-2">{{ $inProgressCount }}</div>
                    <div class="uppercase tracking-wide">In Progress</div>
                </div>
                <div class="bg-[#B3D4E5] rounded-lg p-6 text-center">
                    <div class="text-3xl mb-2">{{ $completedCount }}</div>
                    <div class="uppercase tracking-wide">Completed</div>
                </div>
            </div>

            <!-- Filters -->
            <form method="GET" action="{{ route('admin.document-requests.index') }}" class="flex gap-4 mb-6">
                <div class="flex-1 relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <select name="document_type" class="px-4 py-2 border border-gray-300 rounded bg-white" onchange="this.form.submit()">
                    <option value="">DOCUMENT TYPE</option>
                    <option value="Resident Certificate" {{ request('document_type') == 'Resident Certificate' ? 'selected' : '' }}>Resident Certificate</option>
                    <option value="Barangay Certificate" {{ request('document_type') == 'Barangay Certificate' ? 'selected' : '' }}>Barangay Certificate</option>
                    <option value="Barangay Clearance" {{ request('document_type') == 'Barangay Clearance' ? 'selected' : '' }}>Barangay Clearance</option>
                </select>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded bg-white" onchange="this.form.submit()">
                    <option value="">STATUS</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
                <button type="submit" class="bg-[#4A7BA7] text-white px-6 py-2 rounded hover:bg-[#3A6B97]">Search</button>
            </form>

            <!-- Table -->
            <div class="bg-white rounded-lg overflow-hidden shadow">
                <table class="w-full">
                    <thead>
                        <tr class="bg-[#4A7BA7] text-white">
                            <th class="px-4 py-3 text-left uppercase text-sm">Transaction ID</th>
                            <th class="px-4 py-3 text-left uppercase text-sm">Last Name</th>
                            <th class="px-4 py-3 text-left uppercase text-sm">First Name</th>
                            <th class="px-4 py-3 text-left uppercase text-sm">Doc Type</th>
                            <th class="px-4 py-3 text-left uppercase text-sm">Purpose</th>
                            <th class="px-4 py-3 text-left uppercase text-sm">Date Requested</th>
                            <th class="px-4 py-3 text-left uppercase text-sm">Status</th>
                            <th class="px-4 py-3 text-left uppercase text-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $index => $request)
                        <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                            <td class="px-4 py-3 border-b">{{ $request->transaction_id }}</td>
                            <td class="px-4 py-3 border-b">{{ $request->last_name }}</td>
                            <td class="px-4 py-3 border-b">{{ $request->first_name }}</td>
                            <td class="px-4 py-3 border-b">{{ $request->document_type }}</td>
                            <td class="px-4 py-3 border-b">{{ $request->purpose }}</td>
                            <td class="px-4 py-3 border-b">{{ $request->created_at->format('m/d/Y') }}</td>
                            <td class="px-4 py-3 border-b">{{ $request->status }}</td>
                            <td class="px-4 py-3 border-b">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.document-requests.show', $request->id) }}" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <button onclick="editStatus({{ $request->id }}, '{{ $request->status }}')" class="text-green-600 hover:text-green-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form method="POST" action="{{ route('admin.document-requests.destroy', $request->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this request?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">No document requests found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center gap-4 mt-6">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Edit Status Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl mb-4">Update Status</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <select name="status" id="statusSelect" class="w-full border border-gray-300 rounded px-3 py-2 mb-4">
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">Cancel</button>
                <button type="submit" class="bg-[#4A7BA7] text-white px-6 py-2 rounded hover:bg-[#3A6B97]">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function editStatus(id, currentStatus) {
    document.getElementById('editForm').action = `/admin/document-requests/${id}`;
    document.getElementById('statusSelect').value = currentStatus;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endsection

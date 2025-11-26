@extends('layouts.app')

@section('title', 'Document Requests')

@section('content')
<div class="min-h-screen bg-white">
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
                <div class="font-semibold">Barangay Dasag Bakal</div>
                <div class="text-sm">Maubanying City</div>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm underline">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto p-6">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Status Cards -->
        <div class="grid grid-cols-3 gap-4 mb-8">
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

        <!-- Document Request List -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl">List of Document Request</h2>
            <button onclick="openModal()" class="bg-[#B388D4] text-white px-6 py-2 rounded hover:bg-[#9F6FC4]">
                Document Request
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#4A7BA7] text-white">
                        <th class="px-4 py-3 text-left uppercase text-sm">Transaction ID</th>
                        <th class="px-4 py-3 text-left uppercase text-sm">Last Name</th>
                        <th class="px-4 py-3 text-left uppercase text-sm">First Name</th>
                        <th class="px-4 py-3 text-left uppercase text-sm">Document Type</th>
                        <th class="px-4 py-3 text-left uppercase text-sm">Purpose</th>
                        <th class="px-4 py-3 text-left uppercase text-sm">Date Requested</th>
                        <th class="px-4 py-3 text-left uppercase text-sm">Status</th>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">No document requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="requestModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
            <!-- Modal Header -->
            <div class="bg-[#4A7BA7] text-white px-6 py-4 rounded-t-lg flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <div class="w-8 h-8 bg-[#4A7BA7] rounded-full"></div>
                    </div>
                    <div>
                        <div class="font-semibold">Barangay Dasag Bakal</div>
                    </div>
                </div>
                <button onclick="closeModal()" class="hover:bg-[#3A6B97] rounded p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Status Tabs -->
            <div class="grid grid-cols-3 gap-4 px-6 pt-6">
                <div class="bg-[#B3D4E5] rounded-lg p-4 text-center">
                    <div class="text-2xl mb-1">{{ $pendingCount }}</div>
                    <div class="text-sm uppercase">Pending</div>
                </div>
                <div class="bg-gray-200 rounded-lg p-4 text-center text-gray-400">
                    <div class="text-2xl mb-1">{{ $inProgressCount }}</div>
                    <div class="text-sm uppercase">In Progress</div>
                </div>
                <div class="bg-gray-200 rounded-lg p-4 text-center text-gray-400">
                    <div class="text-2xl mb-1">{{ $completedCount }}</div>
                    <div class="text-sm uppercase">Completed</div>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('user.document-requests.store') }}" class="p-6">
                @csrf
                <h2 class="text-center text-xl mb-6">APPLICATION FORM FOR BARANGAY CERTIFICATE</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block mb-2">
                            Length of Residency <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="length_of_residency" required 
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block mb-2">
                            Valid ID Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="valid_id_number" required 
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block mb-2">
                            Registered Voter <span class="text-red-500">*</span>
                        </label>
                        <select name="registered_voter" required 
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-white">
                            <option value="">Select...</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2">
                            Purpose of Request <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="purpose" required 
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>
                </div>

                <p class="text-sm text-gray-600 mt-4 mb-6">
                    <input type="checkbox" required class="mr-2">
                    I certify that the above information provided is accurate and complete to the best of my knowledge.
                </p>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal()" 
                        class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">
                        CANCEL
                    </button>
                    <button type="submit" 
                        class="bg-[#5CB85C] text-white px-6 py-2 rounded hover:bg-[#4CAF50]">
                        SUBMIT
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('requestModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('requestModal').classList.add('hidden');
}
</script>
@endsection

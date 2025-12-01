@extends('layouts.app')

@section('title', 'Reports & Analytics')

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
                <span>Admin Dashboard</span>
            </div>
        </div>

        <div class="p-6">
            <h1 class="text-3xl mb-6">REPORTS & ANALYTICS</h1>

            <!-- User Statistics Cards -->
            <div class="grid grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-gray-600">Total Users</div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl mb-2">{{ $totalUsers ?? 0 }}</div>
                    <div class="text-sm text-green-600">+12% from last month</div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-gray-600">Registered Residents</div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl mb-2">{{ $totalRegisteredResidents ?? 0 }}</div>
                    <div class="text-sm text-green-600">+5% from last month</div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-gray-600">Registered Staffs</div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl mb-2">{{ $totalRegisteredStaffs ?? 0 }}</div>
                    <div class="text-sm text-gray-500">No change</div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-gray-600">Archived Accounts</div>
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl mb-2">{{ $archivedAccounts ?? 0 }}</div>
                    <div class="text-sm text-red-600">-3 from last month</div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Document Requests Chart -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Document Requests Overview</h3>
                    <div class="h-64 flex items-center justify-center">
                        <canvas id="documentChart"></canvas>
                    </div>
                </div>

                <!-- Monthly Activity Chart -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Monthly Activity</h3>
                    <div class="h-64 flex items-center justify-center">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">Recent Activity</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Juan Dela Cruz</td>
                                <td class="px-6 py-4 whitespace-nowrap">Submitted Barangay Certificate</td>
                                <td class="px-6 py-4 whitespace-nowrap">Dec 1, 2025</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Maria Santos</td>
                                <td class="px-6 py-4 whitespace-nowrap">Completed Clearance Request</td>
                                <td class="px-6 py-4 whitespace-nowrap">Nov 30, 2025</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Pedro Reyes</td>
                                <td class="px-6 py-4 whitespace-nowrap">Updated Profile Information</td>
                                <td class="px-6 py-4 whitespace-nowrap">Nov 29, 2025</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        In Progress
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Document Requests Chart
const docCtx = document.getElementById('documentChart').getContext('2d');
new Chart(docCtx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'In Progress', 'Completed'],
        datasets: [{
            data: [30, 45, 125],
            backgroundColor: ['#FCD34D', '#60A5FA', '#34D399']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Activity Chart
const actCtx = document.getElementById('activityChart').getContext('2d');
new Chart(actCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Document Requests',
            data: [12, 19, 15, 25, 22, 30],
            borderColor: '#4A7BA7',
            backgroundColor: 'rgba(74, 123, 167, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection
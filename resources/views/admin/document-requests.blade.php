<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Document Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<div class="flex min-h-screen bg-gray-50">

    <!-- SIDEBAR -->
    <?php include 'admin/partials/sidebar.php'; ?>

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

            <!-- SUCCESS MESSAGE -->
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= $_SESSION['success']; ?>
                </div>
            <?php endif; ?>

            <h1 class="text-3xl mb-6">DOCUMENT REQUEST</h1>

            <!-- Status Cards -->
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="bg-[#B3D4E5] rounded-lg p-6 text-center">
                    <div class="text-3xl mb-2"><?= $totalRequests ?></div>
                    <div class="uppercase tracking-wide">Total Request</div>
                </div>
                <div class="bg-[#B3D4E5] rounded-lg p-6 text-center">
                    <div class="text-3xl mb-2"><?= $pendingCount ?></div>
                    <div class="uppercase tracking-wide">Pending</div>
                </div>
                <div class="bg-[#B3D4E5] rounded-lg p-6 text-center">
                    <div class="text-3xl mb-2"><?= $inProgressCount ?></div>
                    <div class="uppercase tracking-wide">In Progress</div>
                </div>
                <div class="bg-[#B3D4E5] rounded-lg p-6 text-center">
                    <div class="text-3xl mb-2"><?= $completedCount ?></div>
                    <div class="uppercase tracking-wide">Completed</div>
                </div>
            </div>

            <!-- Filters -->
            <form method="GET" class="flex gap-4 mb-6">
                <div class="flex-1 relative">
                    <input type="text" name="search" value="<?= $_GET['search'] ?? '' ?>"
                        placeholder="Search..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded">
                </div>

                <select name="document_type" class="px-4 py-2 border border-gray-300 rounded bg-white" onchange="this.form.submit()">
                    <option value="">DOCUMENT TYPE</option>
                    <option value="Resident Certificate">Resident Certificate</option>
                    <option value="Barangay Certificate">Barangay Certificate</option>
                    <option value="Barangay Clearance">Barangay Clearance</option>
                </select>

                <select name="status" class="px-4 py-2 border border-gray-300 rounded bg-white" onchange="this.form.submit()">
                    <option value="">STATUS</option>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>

                <button type="submit" class="bg-[#4A7BA7] text-white px-6 py-2 rounded hover:bg-[#3A6B97]">Search</button>
            </form>

            <!-- Table -->
            <div class="bg-white rounded-lg overflow-hidden shadow">
                <table class="w-full">
                    <thead>
                        <tr class="bg-[#4A7BA7] text-white">
                            <th class="px-4 py-3 text-left uppercase">Transaction ID</th>
                            <th class="px-4 py-3 text-left uppercase">Last Name</th>
                            <th class="px-4 py-3 text-left uppercase">First Name</th>
                            <th class="px-4 py-3 text-left uppercase">Doc Type</th>
                            <th class="px-4 py-3 text-left uppercase">Purpose</th>
                            <th class="px-4 py-3 text-left uppercase">Date Requested</th>
                            <th class="px-4 py-3 text-left uppercase">Status</th>
                            <th class="px-4 py-3 text-left uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($requests)): ?>
                        <?php foreach ($requests as $index => $request): ?>
                            <tr class="<?= $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' ?>">
                                <td class="px-4 py-3 border-b"><?= $request['transaction_id'] ?></td>
                                <td class="px-4 py-3 border-b"><?= $request['last_name'] ?></td>
                                <td class="px-4 py-3 border-b"><?= $request['first_name'] ?></td>
                                <td class="px-4 py-3 border-b"><?= $request['document_type'] ?></td>
                                <td class="px-4 py-3 border-b"><?= $request['purpose'] ?></td>
                                <td class="px-4 py-3 border-b"><?= date('m/d/Y', strtotime($request['created_at'])) ?></td>
                                <td class="px-4 py-3 border-b"><?= $request['status'] ?></td>
                                <td class="px-4 py-3 border-b">

                                    <div class="flex gap-2">

                                        <!-- View -->
                                        <a href="show.php?id=<?= $request['id'] ?>" class="text-blue-600 hover:text-blue-800">View</a>

                                        <!-- Edit -->
                                        <button onclick="editStatus(<?= $request['id'] ?>, '<?= $request['status'] ?>')" class="text-green-600 hover:text-green-800">Edit</button>

                                        <!-- Delete -->
                                        <form method="POST" action="delete.php" onsubmit="return confirm('Delete this request?')" class="inline">
                                            <input type="hidden" name="id" value="<?= $request['id'] ?>">
                                            <button class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>

                                    </div>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">No document requests found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg max-w-md w-full">
        <h3 class="text-xl mb-4">Update Status</h3>
        <form id="editForm" method="POST" action="update.php">
            <input type="hidden" name="id" id="modal_id">
            <select name="status" id="statusSelect" class="border w-full px-3 py-2 mb-4">
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 text-white px-6 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-[#4A7BA7] text-white px-6 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function editStatus(id, status) {
    document.getElementById('modal_id').value = id;
    document.getElementById('statusSelect').value = status;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>

</body>
</html>

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentRequest;
use App\Models\User;

class DocumentRequestSeeder extends Seeder
{
    public function run()
    {
        // Create test users
        $user1 = User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        $user3 = User::create([
            'name' => 'Pedro Reyes',
            'email' => 'pedro@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Create document requests from different users
        DocumentRequest::create([
            'transaction_id' => 'DOC-RC-17591',
            'user_id' => $user1->id,
            'last_name' => 'Dela Cruz',
            'first_name' => 'Juan',
            'document_type' => 'Resident Certificate',
            'purpose' => 'Employment',
            'length_of_residency' => '5 years',
            'valid_id_number' => 'ID-123456',
            'registered_voter' => 'Yes',
            'status' => 'Pending',
        ]);

        DocumentRequest::create([
            'transaction_id' => 'DOC-BCI-A3357',
            'user_id' => $user2->id,
            'last_name' => 'Santos',
            'first_name' => 'Maria',
            'document_type' => 'Barangay Certificate',
            'purpose' => 'Good Moral Character',
            'length_of_residency' => '10 years',
            'valid_id_number' => 'ID-789012',
            'registered_voter' => 'Yes',
            'status' => 'In Progress',
        ]);

        DocumentRequest::create([
            'transaction_id' => 'DOC-BCI-M4810',
            'user_id' => $user3->id,
            'last_name' => 'Reyes',
            'first_name' => 'Pedro',
            'document_type' => 'Barangay Clearance',
            'purpose' => 'Loan Application',
            'length_of_residency' => '3 years',
            'valid_id_number' => 'ID-345678',
            'registered_voter' => 'No',
            'status' => 'Completed',
        ]);

        DocumentRequest::create([
            'transaction_id' => 'DOC-RC-B9234',
            'user_id' => $user1->id,
            'last_name' => 'Dela Cruz',
            'first_name' => 'Juan',
            'document_type' => 'Resident Certificate',
            'purpose' => 'Travel Documents',
            'length_of_residency' => '5 years',
            'valid_id_number' => 'ID-123456',
            'registered_voter' => 'Yes',
            'status' => 'Pending',
        ]);

        DocumentRequest::create([
            'transaction_id' => 'DOC-BCL-C7821',
            'user_id' => $user2->id,
            'last_name' => 'Santos',
            'first_name' => 'Maria',
            'document_type' => 'Barangay Clearance',
            'purpose' => 'Business Permit',
            'length_of_residency' => '10 years',
            'valid_id_number' => 'ID-789012',
            'registered_voter' => 'Yes',
            'status' => 'Completed',
        ]);

        echo "✓ Created 5 document requests from 3 different users\n";
        echo "✓ All requests will appear in the admin table\n";
        echo "✓ Admin can search by name, transaction ID, document type, or purpose\n";
    }
}

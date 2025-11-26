<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->after('name');
            $table->string('suffix')->nullable()->after('middle_name');
            $table->integer('age')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('civil_status')->nullable();
            $table->string('citizenship')->default('Filipino');
            $table->string('contact_number')->nullable();
            $table->string('house_street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city_municipality')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('valid_id_front')->nullable();
            $table->string('valid_id_back')->nullable();
            $table->enum('role', ['user', 'admin'])->default('user');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'middle_name', 'suffix', 'age', 'date_of_birth', 'place_of_birth',
                'gender', 'civil_status', 'citizenship', 'contact_number',
                'house_street', 'barangay', 'city_municipality',
                'profile_picture', 'valid_id_front', 'valid_id_back', 'role'
            ]);
        });
    }
};

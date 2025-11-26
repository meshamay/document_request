<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'last_name',
        'first_name',
        'middle_name',
        'document_type',
        'purpose',
        'length_of_residency',
        'valid_id_number',
        'registered_voter',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get all requests for a specific user (for user dashboard)
    public static function getByUser($userId)
    {
        return self::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
    }

    // Get all requests (for admin dashboard - shows ALL users' requests)
    public static function getAllRequests()
    {
        return self::with('user')->orderBy('created_at', 'desc')->get();
    }

    public static function generateTransactionId($documentType)
    {
        $prefix = 'DOC-';
        $code = strtoupper(substr(str_replace(' ', '', $documentType), 0, 3));
        $random = strtoupper(substr(md5(uniqid()), 0, 5));
        return $prefix . $code . '-' . $random;
    }
}
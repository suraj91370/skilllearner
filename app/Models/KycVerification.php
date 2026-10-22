<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KycVerification extends Model
{
    protected $fillable = [
        'user_id',
        'aadhar_number',
        'pan_number',
        'bank_name',
        'account_number',
        'ifsc_code',
        'upi_id',
        'document_file',
        'status',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

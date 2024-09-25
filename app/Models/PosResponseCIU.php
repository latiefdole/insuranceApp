<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosResponseCIU extends Model
{
    protected $table = 'posResponseCIU';
    protected $primaryKey = 'nomor_resi'; // Set the primary key
    public $incrementing = false; // Disable auto-incrementing if the key is not numeric
    protected $fillable = [
        'nomor_resi', 'nomor_sertifikat', 'InsuranceDate', 'Status', 'remark'
    ];

    public $timestamps = false; // if the table doesn't have created_at and updated_at columns
}

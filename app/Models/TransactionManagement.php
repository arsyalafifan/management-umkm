<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionManagement extends Model
{
    use HasFactory;

    protected $table = 'tbtransactionmanagement';
    protected $primaryKey = 'transactionid';
    const CREATED_AT = 'tgladd';
    const UPDATED_AT = 'tgledit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transactionid',
        'stockid',
        'tgltransaksi',
        'jumlah',
        'total',
        'keterangan',
        'status',
        'opadd',
        'pcadd',
        'tgladd',
        'opedit',
        'pcedit',
        'tgledit',
        'dlt'
    ];

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'opadd',
        'pcadd',
        'opedit',
        'pcedit',
        'dlt',
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'tgladd' => 'datetime',
        'tgledit' => 'datetime',
    ];
}

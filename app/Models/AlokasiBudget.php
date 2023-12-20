<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlokasiBudget extends Model
{
    use HasFactory;

    protected $table = 'tbalokasibudget';
    protected $primaryKey = 'alokasibudgetid';
    const CREATED_AT = 'tgladd';
    const UPDATED_AT = 'tgledit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alokasibudgetid',
        'budgetid',
        'judul',
        'tglalokasibudget',
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

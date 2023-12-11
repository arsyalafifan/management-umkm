<?php

namespace App\Models;

use App\Models\master\Akses;
use App\enumVar as enum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbuser';
    protected $primaryKey = 'userid';
    const CREATED_AT = 'tgladd';
    const UPDATED_AT = 'tgledit';

    public function getAuthPassword() {
        return $this->password;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userid',
        'grup',
        'pegawaiid',
        'nama',
        'login',
        'password',
        'isaktif',
        'email',
        'aksesid',
        'changepasswordafterlogin',
        'emailfromrequestsandi',
        'opadd', 'pcadd', 'opedit', 'pcedit', 'dlt'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'tokenremember',
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

    public function isSuperadmin() {
        $akses = Akses::where('tbmakses.aksesid','=', $this->aksesid)->where('dlt','0')->first();
        if($akses == null || $akses->grup != enum::USER_SUPERADMIN) {
            return false;
        }

        return true;
    }

    public function isSekolah() {
        $akses = Akses::where('tbmakses.aksesid', '=', $this->aksesid)->where('dlt', '0')->first();
        if($akses == null || $akses->grup != enum::USER_SEKOLAH)
        {
            return false;
        }
        return true;
    }

    public function isPerusahaan() {
        $akses = Akses::where('tbmakses.aksesid', '=', $this->aksesid)->where('dlt', '0')->first();
        if($akses == null || $akses->grup != enum::USER_PERUSAHAAN)
        {
            return false;
        }
        return true;
    }

    public function isDisdik() {
        $akses = Akses::where('tbmakses.aksesid', '=', $this->aksesid)->where('dlt', '0')->first();
        if($akses == null || $akses->grup != enum::USER_ADMIN_DISDIK)
        {
            return false;
        }
        return true;
    }

    public function akses()
    {
        return $this->belongsTo(Akses::class,'aksesid');
    }
}

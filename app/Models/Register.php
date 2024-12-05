<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Register extends Model
{
    use HasFactory;

    protected $table = 'register_pasien';
    protected $guarded = ['id'];

    public function pasien(): HasOne
    {
        return $this->hasOne(Pasien::class, 'no_rkm_medis', 'no_rkm_medis');
    }

    public function dokter(): HasOne
    {
        return $this->hasOne(Dokter::class, 'id', 'dokter_id');
    }
}

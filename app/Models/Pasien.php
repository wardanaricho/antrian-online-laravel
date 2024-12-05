<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    protected $primaryKey = 'no_rkm_medis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        "no_rkm_medis",
        "nik",
        "nama_pasien",
        "email",
        "jenis_kelamin",
        "tempat_lahir",
        "tanggal_lahir",
        "tanggal_daftar",
        "jam_daftar",
        "agama",
        "pekerjaan",
        "nomor_tlp",
        "status_pernikahan",
        "alamat",
    ];

    public function register(): BelongsTo
    {
        return $this->belongsTo(Register::class, 'no_rkm_medis', 'no_rkm_medis');
    }
}

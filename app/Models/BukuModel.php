<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table      = 'buku';
    protected $allowedFields = ['kode_buku','judul_buku','isbn','kode_penerbit','kode_rak','kode_jenis','halaman','deskripsi_buku','sampul'];
    protected $useTimestamps = false;
    protected $validationRules      = [];
}
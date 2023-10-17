<?php

namespace App\Models;

use CodeIgniter\Model;

class SekolahModel extends Model
{
    protected $table      = 'sekolah';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_sekolah','kepsek','ketua','nipkepsek','nipketua','background','slogan_sekolah','email_sekolah','alamat_sekolah','logo'];
    protected $useTimestamps = false;
}
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PerpusModel;

class Perpustakaan extends BaseController
{
    protected $perpusModel;

    function __construct()
    {
        $this->perpusModel = new PerpusModel();    
    }

    public function index(): string
    {
        session();
        $perpus = $this->perpusModel->first();
        $data = [
            'title' => 'Profil Perpustakaan',
            'perpus' => $perpus
        ];
        return view('admin/perpustakaan/index', $data);
    }

    function save()
    {
        $perpus = $this->request->getVar();
        if ($this->perpusModel->where('id',1)->set([
            'nama_perpus'   => $perpus['nama_perpus'],
            'slogan_perpus' => $perpus['slogan_perpus'],
            'peraturan_perpus'  => $perpus['peraturan_perpus']
        ])->update() == true
        ) {
            session()->setFlashdata('session',[
                'status'    => 'success',
                'message'   => 'Data Perpustakaan Berhasil Di Ubah'
            ]);
            return redirect()->to(base_url('pustakawan/perpustakaan'));
        }else{
            session()->setFlashdata('session',[
                'status'    => 'error',
                'message'   => 'Data Perpustakaan Gagal Di Ubah'
            ]);
            return redirect()->to(base_url('pustakawan/perpustakaan'))->withInput();
        }
    }
}
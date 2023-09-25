<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettransaksiModel;

class Transaksi extends BaseController
{
    protected $settransModel;

    function __construct()
    {
        $this->settransModel = new SettransaksiModel();    
    }

    public function index(): string
    {
        session();
        $set = $this->settransModel->first();
        $data = [
            'title' => 'Pengaturan Transaksi',
            'set' => $set
        ];
        return view('admin/transaksi/index', $data);
    }

    function update()
    {
        $set = $this->request->getVar();
        // dd($set);
        if ($this->settransModel->where('id',1)->set([
            'terlambat'   => $set['terlambat'],
            'denda' => $set['denda']
        ])->update() == true
        ) {
            session()->setFlashdata('session',[
                'status'    => 'success',
                'message'   => 'Data Berhasil Di Ubah'
            ]);
            return redirect()->to(base_url('pustakawan/transaksi'));
        }else{
            session()->setFlashdata('session',[
                'status'    => 'error',
                'message'   => 'Data Gagal Di Ubah'
            ]);
            return redirect()->to(base_url('pustakawan/transaksi'))->withInput();
        }
    }
}
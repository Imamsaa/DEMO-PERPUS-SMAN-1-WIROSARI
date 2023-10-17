<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettransaksiModel;
use App\Models\BukuModel;
use App\Models\TransaksiModel;
use App\Models\KelasModel;

class Transaksi extends BaseController
{
    protected $settransModel;
    protected $bukuModel;
    protected $trans;
    protected $kelasModel;

    function __construct()
    {
        $this->trans = new TransaksiModel();
        $this->kelasModel = new KelasModel();
        $this->settransModel = new SettransaksiModel();
        $this->bukuModel = new BukuModel();    
    }

    public function index()
    {
        session();

        if (session()->get('login') == null) {
            return redirect()->to(base_url('login'));
        }

        $set = $this->settransModel->first();
        $data = [
            'title' => 'Pengaturan Transaksi',
            'set' => $set,
            'sekolah' => $this->sekolah,
            'perpus' => $this->perpus,
            'aku' => $this->aku
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
            session()->setFlashdata('kotaktime',[
                'status'    => 'success',
                'title' => 'Berhasil',
                'message'   => 'Data Berhasil Di Ubah'
            ]);
            return redirect()->to(base_url('pustakawan/transaksi'));
        }else{
            session()->setFlashdata('pojokatas',[
                'status'    => 'error',
                'message'   => 'Data Gagal Di Ubah'
            ]);
            return redirect()->to(base_url('pustakawan/transaksi'))->withInput();
        }
    }

    public function pdf()
    {
        session();

        if (session()->get('login') == null) {
            return redirect()->to(base_url('login'));
        }

        $where = $this->request->getvar();
        // dd($where);
        if ($where['where'] == "") {
            $lap = $this->trans
            ->join('siswa', 'siswa.nis = transaksi.nis')
            ->join('kelas','siswa.kode_kelas = kelas.kode_kelas')
            ->join('buku','buku.kode_buku = transaksi.kode_buku')
            ->join('tahun_ajaran', 'siswa.kode_tahun = tahun_ajaran.kode_tahun')
            ->join('penerbit', 'buku.kode_penerbit = penerbit.kode_penerbit')
            ->join('rak', 'rak.kode_rak = buku.kode_rak')
            ->join('jenis_buku','jenis_buku.kode_jenis = buku.kode_jenis')
            ->findAll();
        }else if($where['where'] != ""){
            $setwhere = explode(',',$where['where']);
            // dd($setwhere);
            $hasil = 0;
            while ($hasil < count($setwhere)) {
                $rewhere[$setwhere[$hasil]] = $setwhere[++$hasil];
                $hasil++;
            }
            // dd($rewhere);
            $lap = $this->trans
            ->where($rewhere)
            ->join('siswa', 'siswa.nis = transaksi.nis')
            ->join('kelas','siswa.kode_kelas = kelas.kode_kelas')
            ->join('buku','buku.kode_buku = transaksi.kode_buku')
            ->join('tahun_ajaran', 'siswa.kode_tahun = tahun_ajaran.kode_tahun')
            ->join('penerbit', 'buku.kode_penerbit = penerbit.kode_penerbit')
            ->join('rak', 'rak.kode_rak = buku.kode_rak')
            ->join('jenis_buku','jenis_buku.kode_jenis = buku.kode_jenis')
            ->findAll();
        }

        $set = $this->settransModel->first();
        $data = [
            'title' => 'Cetak Laporan PDF',
            'set' => $set,
            'sekolah' => $this->sekolah,
            'perpus' => $this->perpus,
            'aku' => $this->aku,
            'lap' => $lap
        ];
        return view('admin/transaksi/pdf', $data);
    }
}

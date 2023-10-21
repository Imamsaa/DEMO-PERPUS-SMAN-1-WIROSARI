<?php

namespace App\Controllers\Admin;
require 'public/vendor/autoload.php';

use App\Controllers\BaseController;
use App\Models\SettransaksiModel;
use App\Models\BukuModel;
use App\Models\TransaksiModel;
use App\Models\PerpusModel;
use App\Models\KelasModel;

class Transaksi extends BaseController
{
    protected $settransModel;
    protected $bukuModel;
    protected $trans;
    protected $kelasModel;
    protected $perpusModel;

    function __construct()
    {
        $this->perpusModel = new PerpusModel();
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

            $grafik = $this->trans->select("DATE_FORMAT(pinjam, '%M') AS bulan, DATE_FORMAT(pinjam, '%Y') AS tahun, COUNT(pinjam) AS pinjam, COUNT(kembali) AS kembali")
            ->groupBy("DATE_FORMAT(pinjam, '%Y-%m')")
            ->orderBy("DATE_FORMAT(pinjam, '%Y-%m')")
            ->findAll();

            $regrap = [];
            foreach ($grafik as $kk) {
                $regrap['bulan'][] = "'".$kk['bulan']." ".$kk['tahun']."'";
                $regrap['pinjam'][] = $kk['pinjam'];
                $regrap['kembali'][] = $kk['kembali'];
            }

        }else if($where['where'] != ""){
            $setwhere = explode(',',$where['where']);
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

            $grafik = $this->trans->select("DATE_FORMAT(pinjam, '%M') AS bulan, DATE_FORMAT(pinjam, '%Y') AS tahun, COUNT(pinjam) AS pinjam, COUNT(kembali) AS kembali")
            ->where($rewhere)
            ->join('siswa', 'transaksi.nis = siswa.nis')
            ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
            ->groupBy("DATE_FORMAT(pinjam, '%Y-%m')")
            ->orderBy("DATE_FORMAT(pinjam, '%Y-%m')")
            ->findAll();
            
            $regrap = [];
            foreach ($grafik as $kk) {
                $regrap['bulan'][] = "'".$kk['bulan']." ".$kk['tahun']."'";
                $regrap['pinjam'][] = $kk['pinjam'];
                $regrap['kembali'][] = $kk['kembali'];
            }
        }

        $set = $this->settransModel->first();
        $data = [
            'title' => 'Cetak Laporan PDF',
            'set' => $set,
            'sekolah' => $this->sekolah,
            'perpus' => $this->perpus,
            'aku' => $this->aku,
            'lap' => $lap,
            'bulan' => $regrap['bulan'],
            'pinjam' => $regrap['pinjam'],
            'kembali' => $regrap['kembali']
        ];
        return view('admin/transaksi/pdf', $data);
    }

    public function excel()
    {
        session();

        $user = $this->aku;

        if (session()->get('login') == null) {
            return redirect()->to(base_url('login'));
        }

        $where = $this->request->getvar();
        
        if ($where['where'] == '') {
            $lap = $this->trans
            ->join('siswa', 'siswa.nis = transaksi.nis')
            ->join('kelas','siswa.kode_kelas = kelas.kode_kelas')
            ->join('buku','buku.kode_buku = transaksi.kode_buku')
            ->join('tahun_ajaran', 'siswa.kode_tahun = tahun_ajaran.kode_tahun')
            ->join('penerbit', 'buku.kode_penerbit = penerbit.kode_penerbit')
            ->join('rak', 'rak.kode_rak = buku.kode_rak')
            ->join('jenis_buku','jenis_buku.kode_jenis = buku.kode_jenis')
            ->findAll();
            // redirect()->to(base_url('pustakawan/pengunjung'));
        }else{
            $setwhere = explode(',',$where['where']);
            $hasil = 0;
            while ($hasil < count($setwhere)) {
                $rewhere[$setwhere[$hasil]] = $setwhere[++$hasil];
                $hasil++;
            }
    
            if ($where['nama'] != '') {
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
        }
        
        // Load library PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        
        // Buat objek worksheet
        $worksheet = $spreadsheet->getActiveSheet();
        
        $sekolah = $this->sekolah;
        $perpus = $this->perpusModel->first();
        // Tambahkan baris pertama dan gabungkan 6 kolom untuk judul
        $worksheet->mergeCells('A1:M1');
        $titleCell1 = $worksheet->getCell('A1');
        $date = $user['nama_user'].'/'.DATE('d/m/Y');
        $titleCell1->setValue("$date");

        $worksheet->mergeCells('A2:M2');
        $titleCell = $worksheet->getCell('A2');
        $titleCell->setValue('PERPUSTAKAAN '.$perpus['nama_perpus']);
        
        // Mengatur properti font pada judul
        $titleCell->getStyle()->getFont()->setBold(true);
        $titleCell->getStyle()->getFont()->setSize(12); // Sesuaikan ukuran font sesuai kebutuhan
        
        // Mengatur tinggi baris agar sesuai dengan konten judul
        $worksheet->getRowDimension(1)->setRowHeight(20); 
        
        $worksheet->mergeCells('A3:M3');
        $titleCell2 = $worksheet->getCell('A3');
        $titleCell2->setValue($sekolah['nama_sekolah']);

        // Mengatur properti font pada judul
        $titleCell2->getStyle()->getFont()->setBold(true);
        $titleCell2->getStyle()->getFont()->setSize(12); // Sesuaikan ukuran font sesuai kebutuhan
        
        // Mengatur tinggi baris agar sesuai dengan konten judul
        $worksheet->getRowDimension(2)->setRowHeight(20);
        // Sesuaikan tinggi sesuai kebutuhan
        $worksheet->mergeCells('A4:M4');
        // Header tabel
        $header = ['NO', 'NIS', 'NAMA SISWA', 'KELAS', 'KODE','JUDUL BUKU','RAK','PENERBIT','STATUS BUKU','TANGGAL PINJAM','TANGGAK KEMBALI','KETERLAMBATAN','DENDA'];
        $worksheet->fromArray($header, null, 'A5');
        
        // Mengatur data yang ingin ditampilkan
        $dataToDisplay = [];
        $no = 1;
        foreach ($lap as $item) {
            $dataToDisplay[] = [$no, $item['nis'], $item['nama_siswa'], $item['nama_kelas'], $item['kode_buku'], $item['judul_buku'], $item['nama_rak'], $item['nama_penerbit'], $item['status'], $item['pinjam'], $item['kembali'], $item['terlambat'], $item['denda']];
            $no++;
        }
        
        // Memasukkan data yang sudah diatur ke dalam worksheet
        $row = 6; // Dimulai dari baris kedua setelah header
        foreach ($dataToDisplay as $rowData) {
            $worksheet->fromArray($rowData, null, 'A' . $row);
            $row++;
        }
        
        // Mengatur lebar kolom agar sesuai dengan A4
        $worksheet->getColumnDimension('A')->setWidth(10); // Sesuaikan lebar sesuai kebutuhan
        $worksheet->getColumnDimension('B')->setWidth(15); // Sesuaikan lebar sesuai kebutuhan
        $worksheet->getColumnDimension('C')->setWidth(20); // Sesuaikan lebar sesuai kebutuhan
        $worksheet->getColumnDimension('D')->setWidth(30); // Sesuaikan lebar sesuai kebutuhan
        $worksheet->getColumnDimension('E')->setWidth(15); // Sesuaikan lebar sesuai kebutuhan
        $worksheet->getColumnDimension('F')->setWidth(15); // Sesuaikan lebar sesuai kebutuhan
        $worksheet->getColumnDimension('G')->setWidth(15);
        $worksheet->getColumnDimension('H')->setWidth(15);
        $worksheet->getColumnDimension('I')->setWidth(15);
        $worksheet->getColumnDimension('J')->setWidth(15);
        $worksheet->getColumnDimension('K')->setWidth(15);
        $worksheet->getColumnDimension('L')->setWidth(15);
        $worksheet->getColumnDimension('M')->setWidth(15);

        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $cellRange = 'A5:' . $highestColumn . $highestRow;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $worksheet->getStyle($cellRange)->applyFromArray($styleArray);

        $headerRange = 'A5:' . $highestColumn . '5';
        $worksheet->getStyle($headerRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $noRange = 'A2:A' . $highestRow;
        $worksheet->getStyle($noRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // Konfigurasi atau styling spreadsheet, seperti judul, dll.
        // Anda bisa menyesuaikan ini sesuai kebutuhan Anda
        // Tambahkan dua baris kosong
        // Tambahkan dua baris kosong
        // Tanda tangan Kepala Sekolah

        $row += 1;
        $worksheet->mergeCells('G' . $row . ':M' . $row);
        $worksheet->setCellValue('G' . $row, $sekolah['kecamatan'].", ".DATE('d-m-Y'));
        $worksheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row += 1;
        $worksheet->mergeCells('A' . $row . ':F' . $row);
        $worksheet->setCellValue('A' . $row, 'Mengetahui');
        $worksheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        // Tanda tangan Ketua Perpustakaan
        $worksheet->mergeCells('G' . $row . ':M' . $row);
        $worksheet->setCellValue('G' . $row, 'Kepala Perpustakaan');
        $worksheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row += 1;
        $worksheet->mergeCells('A' . $row . ':F' . $row);
        $worksheet->setCellValue('A' . $row, 'Kepala Sekolah');
        $worksheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row += 5;
        $worksheet->mergeCells('A' . $row . ':F' . $row);
        $worksheet->setCellValue('A' . $row, $sekolah['kepsek']);
        $worksheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        // Tanda tangan Ketua Perpustakaan
        $worksheet->mergeCells('G' . $row . ':M' . $row);
        $worksheet->setCellValue('G' . $row, $sekolah['ketua']);
        $worksheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row += 1;
        $worksheet->mergeCells('A' . $row . ':F' . $row);
        $worksheet->setCellValue('A' . $row, "NIP : ".$sekolah['nipkepsek']);
        $worksheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        // Tanda tangan Ketua Perpustakaan
        $worksheet->mergeCells('G' . $row . ':M' . $row);
        $worksheet->setCellValue('G' . $row, "NIP : ".$sekolah['nipketua']);
        $worksheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Outputkan file Excel ke browser
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'exported_data.xlsx'; // Nama file Excel yang akan dihasilkan
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit; // Penting untuk menghentikan eksekusi script setelah output file Excel

    }
}

<?php

namespace App\Controllers\Admin;
require 'public/vendor/autoload.php';
use App\Controllers\BaseController;
use App\Models\PerpusModel;
use App\Models\TransaksiModel;
use App\Models\KelasModel;
use App\Models\PengunjungModel;

class Pengunjung extends BaseController
{
    protected $trans;
    protected $kelasModel;
    protected $pen;
    protected $perpusModel;

    public function __construct() {
        $this->trans = new TransaksiModel();
        $this->kelasModel = new KelasModel();
        $this->pen = new PengunjungModel();
        $this->perpusModel = new PerpusModel();
    }

    public function index() 
    {
        session();
        
        if (session()->get('login') == null) {
            return redirect()->to(base_url('login'));
        }

        $where = [];
        $req = $this->request->getPost();
        if ($this->request->getPost()) {
        //     // dd($req);

        //     if ($req['status'] == 'pinjam') {
        //         if ($req['awal'] != '') {
        //             // $where = "pinjam >= '".$req['awal']."' AND kembali <= '".$req['akhir']."'";
        //             $where['pinjam >='] = $req['awal'];
        //         }
        //     }else{
        //         if ($req['awal'] != '' AND $req['akhir'] != '') {
        //             // $where = "pinjam >= '".$req['awal']."' AND kembali <= '".$req['akhir']."'";
        //             $where['pinjam >='] = $req['awal'];
        //             $where['kembali <='] =  $req['akhir'];
        //         }
        //     }
        if ($req['awal'] != '' AND $req['akhir'] != '') {
            // $where = "pinjam >= '".$req['awal']."' AND kembali <= '".$req['akhir']."'";
            $where['waktu >='] = $req['awal'];
            $where['waktu <='] =  $req['akhir'];
        }elseif ($req['awal'] != '' AND $req['akhir'] == '') {
            $where['waktu >='] = $req['awal'];
        }elseif ($req['awal'] == '' AND $req['akhir'] != '') {
            $where['waktu <='] =  $req['akhir'];
        }



        if ($req['nis'] != '') {
            $where['pengunjung.nis ='] = $req['nis'];
        }

        if ($req['kelas'] != '') {
            $where['siswa.kode_kelas ='] = $req['kelas'];
        }

        //     $where['status ='] = $req['status'];

        if (empty($where)) {
            redirect()->to(base_url('pustakawan/pengunjung'));
        }

            if ($req['nama'] != '') {
                $lap = $this->pen
                ->where($where)
                // ->where($where)
                ->like('siswa.nama_siswa',$req['nama'])
                ->join('siswa', 'siswa.nis = pengunjung.nis')
                ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
                ->findAll();
                // $lap = $this->trans
                // ->where($where)
                // ->like('siswa.nama_siswa',$req['nama'])
                // ->join('siswa', 'siswa.nis = transaksi.nis')
                // ->join('kelas','siswa.kode_kelas = kelas.kode_kelas')
                // ->join('buku','buku.kode_buku = transaksi.kode_buku')
                // ->join('tahun_ajaran', 'siswa.kode_tahun = tahun_ajaran.kode_tahun')
                // ->join('penerbit', 'buku.kode_penerbit = penerbit.kode_penerbit')
                // ->join('rak', 'rak.kode_rak = buku.kode_rak')
                // ->join('jenis_buku','jenis_buku.kode_jenis = buku.kode_jenis')
                // ->findAll();
            }else{
                // dd($where);
                $lap = $this->pen
                ->where($where)
                ->join('siswa', 'siswa.nis = pengunjung.nis')
                ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
                ->findAll();
                // $lap = $this->trans
                // ->where($where)
                // ->join('siswa', 'siswa.nis = transaksi.nis')
                // ->join('kelas','siswa.kode_kelas = kelas.kode_kelas')
                // ->join('buku','buku.kode_buku = transaksi.kode_buku')
                // ->join('tahun_ajaran', 'siswa.kode_tahun = tahun_ajaran.kode_tahun')
                // ->join('penerbit', 'buku.kode_penerbit = penerbit.kode_penerbit')
                // ->join('rak', 'rak.kode_rak = buku.kode_rak')
                // ->join('jenis_buku','jenis_buku.kode_jenis = buku.kode_jenis')
                // ->findAll();
            }
        }else{
            $lap = $this->pen
            ->join('siswa', 'siswa.nis = pengunjung.nis')
            ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
            ->findAll();
        }


        // $set = $this->trans->first();
        // $hasillab = [];
        // $now  = date_create();
        // foreach ($lap as $l) {
        //     if ($l['status'] == 'kembali') {
        //         $hasillab[] = $l;
        //     }else{
        //         $ambil = date_diff(date_create($l['pinjam']),$now);
        //         $terlambat = $ambil->days - $set['terlambat'];
        //         if ($terlambat < 1) {
        //             $hasil = 0;
        //         }elseif($set['terlambat'] == 0){
        //             $hasil = 0;
        //         }else{
        //             $hasil = $terlambat;
        //         }
        //         $l['terlambat'] = $terlambat;
        //         $l['denda'] = $hasil;
        //         $hasillab[] = $l;
        //     }
        // }

        // $lap = $this->pen
        // ->join('siswa', 'siswa.nis = pengunjung.nis')
        // ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
        // ->findAll();

        $kelas = $this->kelasModel->findAll();

        if (isset($req['nama'])) {
            $nama = $req['nama'];
        }else{
            $nama = '';
        }

        $data = [
            'title' => 'Laporan Pengunjung',
            'lap' => $lap,
            'sekolah' => $this->sekolah,
            'perpus' => $this->perpus,
            'aku' => $this->aku,
            'kelas' => $kelas,
            'where' => $where,
            'nama' => $nama
        ];
        return view('admin/pengunjung/index', $data);
    }

    public function pdf()
    {
        session();

        if (session()->get('login') == null) {
            return redirect()->to(base_url('login'));
        }

        $where = $this->request->getvar();
        
        if ($where['where'] == '') {
            $lap = $this->pen
            ->join('siswa', 'siswa.nis = pengunjung.nis')
            ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
            ->findAll();
            
            $grafik = $this->pen->select("DATE_FORMAT(waktu, '%M') AS bulan, DATE_FORMAT(waktu, '%Y') AS tahun, COUNT(*) AS kunjungan")
            ->groupBy("DATE_FORMAT(waktu, '%Y-%m')")
            ->orderBy("DATE_FORMAT(waktu, '%Y-%m')")
            ->findAll();

            $regrap = [];
            foreach ($grafik as $kk) {
                $regrap['bulan'][] = "'".$kk['bulan']." ".$kk['tahun']."'";
                $regrap['kunjungan'][] = $kk['kunjungan'];
            }
            // redirect()->to(base_url('pustakawan/pengunjung'));
        }else{
            $setwhere = explode(',',$where['where']);
            $hasil = 0;
            while ($hasil < count($setwhere)) {
                $rewhere[$setwhere[$hasil]] = $setwhere[++$hasil];
                $hasil++;
            }
    
            if ($where['nama'] != '') {
                $lap = $this->pen
                ->where($rewhere)
                ->like('siswa.nama_siswa',$req['nama'])
                ->join('siswa', 'siswa.nis = pengunjung.nis')
                ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
                ->findAll();

                $grafik = $this->pen->select("DATE_FORMAT(waktu, '%M') AS bulan, DATE_FORMAT(waktu, '%Y') AS tahun, COUNT(*) AS kunjungan")
                ->where($rewhere)
                ->like('siswa.nama_siswa',$req['nama'])
                ->join('siswa', 'siswa.nis = pengunjung.nis')
                ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
                ->groupBy("DATE_FORMAT(pinjam, '%Y-%m')")
                ->orderBy("DATE_FORMAT(pinjam, '%Y-%m')")
                ->findAll();
                
                $regrap = [];
                foreach ($grafik as $kk) {
                    $regrap['bulan'][] = "'".$kk['bulan']." ".$kk['tahun']."'";
                    $regrap['kunjungan'][] = $kk['kunjungan'];
                }

            }else{
                $lap = $this->pen
                ->where($rewhere)
                ->join('siswa', 'siswa.nis = pengunjung.nis')
                ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
                ->findAll();

                $grafik = $this->pen->select("DATE_FORMAT(waktu, '%M') AS bulan, DATE_FORMAT(waktu, '%Y') AS tahun, COUNT(*) AS kunjungan")
                ->where($rewhere)
                ->join('siswa', 'siswa.nis = pengunjung.nis')
                ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
                ->groupBy("DATE_FORMAT(pinjam, '%Y-%m')")
                ->orderBy("DATE_FORMAT(pinjam, '%Y-%m')")
                ->findAll();
                
                $regrap = [];
                foreach ($grafik as $kk) {
                    $regrap['bulan'][] = "'".$kk['bulan']." ".$kk['tahun']."'";
                    $regrap['kunjungan'][] = $kk['kunjungan'];
                }
            }
        }

        $data = [
            'title' => 'Cetak Laporan PDF',
            'sekolah' => $this->sekolah,
            'perpus' => $this->perpus,
            'aku' => $this->aku,
            'lap' => $lap,
            'bulan' => $regrap['bulan'],
            'kunjungan' => $regrap['kunjungan'],
        ];
        return view('admin/pengunjung/pdf', $data);
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
            $lap = $this->pen
            ->join('siswa', 'siswa.nis = pengunjung.nis')
            ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
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
                $lap = $this->pen
                ->where($rewhere)
                ->like('siswa.nama_siswa',$req['nama'])
                ->join('siswa', 'siswa.nis = pengunjung.nis')
                ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
                ->findAll();
            }else{
                $lap = $this->pen
                ->where($rewhere)
                ->join('siswa', 'siswa.nis = pengunjung.nis')
                ->join('kelas', 'kelas.kode_kelas = siswa.kode_kelas')
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
        $worksheet->mergeCells('A1:F1');
        $titleCell1 = $worksheet->getCell('A1');
        $date = $user['nama_user'].'/'.DATE('d/m/Y');
        $titleCell1->setValue("$date");

        $worksheet->mergeCells('A2:F2');
        $titleCell = $worksheet->getCell('A2');
        $titleCell->setValue('PERPUSTAKAAN '.$perpus['nama_perpus']);
        
        // Mengatur properti font pada judul
        $titleCell->getStyle()->getFont()->setBold(true);
        $titleCell->getStyle()->getFont()->setSize(12); // Sesuaikan ukuran font sesuai kebutuhan
        
        // Mengatur tinggi baris agar sesuai dengan konten judul
        $worksheet->getRowDimension(1)->setRowHeight(20); 
        
        $worksheet->mergeCells('A3:F3');
        $titleCell2 = $worksheet->getCell('A3');
        $titleCell2->setValue($sekolah['nama_sekolah']);

        // Mengatur properti font pada judul
        $titleCell2->getStyle()->getFont()->setBold(true);
        $titleCell2->getStyle()->getFont()->setSize(12); // Sesuaikan ukuran font sesuai kebutuhan
        
        // Mengatur tinggi baris agar sesuai dengan konten judul
        $worksheet->getRowDimension(2)->setRowHeight(20);
        // Sesuaikan tinggi sesuai kebutuhan
        $worksheet->mergeCells('A4:F4');
        // Header tabel
        $header = ['NO', 'NIS', 'NISN', 'NAMA SISWA', 'KELAS', 'WAKTU'];
        $worksheet->fromArray($header, null, 'A5');
        
        // Mengatur data yang ingin ditampilkan
        $dataToDisplay = [];
        $no = 1;
        foreach ($lap as $item) {
            $dataToDisplay[] = [$no, $item['nis'], $item['nisn'], $item['nama_siswa'], $item['nama_kelas'], $item['waktu']];
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
        $worksheet->mergeCells('D' . $row . ':F' . $row);
        $worksheet->setCellValue('D' . $row, $sekolah['kecamatan'].", ".DATE('d-m-Y'));
        $worksheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row += 1;
        $worksheet->mergeCells('A' . $row . ':C' . $row);
        $worksheet->setCellValue('A' . $row, 'Mengetahui');
        $worksheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        // Tanda tangan Ketua Perpustakaan
        $worksheet->mergeCells('D' . $row . ':F' . $row);
        $worksheet->setCellValue('D' . $row, 'Kepala Perpustakaan');
        $worksheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row += 1;
        $worksheet->mergeCells('A' . $row . ':C' . $row);
        $worksheet->setCellValue('A' . $row, 'Kepala Sekolah');
        $worksheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row += 5;
        $worksheet->mergeCells('A' . $row . ':C' . $row);
        $worksheet->setCellValue('A' . $row, $sekolah['kepsek']);
        $worksheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        // Tanda tangan Ketua Perpustakaan
        $worksheet->mergeCells('D' . $row . ':F' . $row);
        $worksheet->setCellValue('D' . $row, $sekolah['ketua']);
        $worksheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row += 1;
        $worksheet->mergeCells('A' . $row . ':C' . $row);
        $worksheet->setCellValue('A' . $row, "NIP : ".$sekolah['nipkepsek']);
        $worksheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        // Tanda tangan Ketua Perpustakaan
        $worksheet->mergeCells('D' . $row . ':F' . $row);
        $worksheet->setCellValue('D' . $row, "NIP : ".$sekolah['nipketua']);
        $worksheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

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

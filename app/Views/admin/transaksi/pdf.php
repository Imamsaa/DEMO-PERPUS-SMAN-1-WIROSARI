<?php 
date_default_timezone_set('Asia/Jakarta');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('public/dist/bootstrap5/css/bootstrap.min.css'); ?>">
    <link rel="shortcut icon" href="<?= base_url('public/admin/img/'.$sekolah['logo']); ?>" type="image/x-icon">
    <!-- Google Font: Source Sans Pro -->
    <style>
    body{
      font-size: 12px;
    }
    #example1 td,#example1 th, #example1 tr{
      border : 1px solid black;
    }
    th{
      text-align: center;
    }
    tr{
      break-inside : avoid;
    }
    .logo{
      width:100px;
    }
    .kop td{
      padding : 10px 30px;
      margin : auto;
    }
    </style>
</head>
<body>
  <section class="mx-4">
    <p><?= $aku['nama_user'].'/'.DATE('d/m/Y/H:s:i'); ?></p>
    <center>
      <table class="kop my-2">
        <tr>
            <td><img class="img-thumbnail logo" src="<?= base_url('public/admin/img/'.$sekolah['logo']); ?>" alt="Logo Sekolah"></td>
            <td>
                <h3 class="my-0 text-center">PERPUSTAKAAN <?= $perpus['nama_perpus']; ?></h3>
                <h3 class="sekolah my-0 text-center"><?= $sekolah['nama_sekolah']; ?></h3>
                <p class="text-center"><i><?= $sekolah['alamat_sekolah']; ?></i></p>
            </td>
        </tr>
    </table>
    <h5>LAPORAN TRANSAKSI PERPUSTAKAAN</h5>
    </center>
      <table id="example1" class="my-0 table table-bordered table-hover">
        <thead>
          <tr>
            <th>NO</th>
            <th>NIS</th>
            <th>NAMA</th>
            <th>KELAS</th>
            <th>KODE</th>
            <th>JUDUL BUKU</th>
            <th>JENIS BUKU</th>
            <th>RAK</th>
            <th>PENERBIT</th>
            <th>STATUS BUKU</th>
            <th>TANGGAL PINJAM</th>
            <th>TANGGAL KEMBALI</th>
            <th>HARI KETERLAMBATAN</th>
            <th>DENDA</th>
          </tr>
          </thead>
          <tbody>
          <?php $no = 1; foreach($lap as $l) :  ?>
          <tr>
            <td><?= $no; ?></td>
            <td><?= $l['nis']; ?></td>
            <td><?= $l['nama_siswa']; ?></td>
            <td><?= $l['nama_kelas']; ?></td>
            <td><?= $l['kode_buku']; ?></td>
            <td><?= $l['judul_buku']; ?></td>
            <td><?= $l['nama_jenis']; ?></td>
            <td><?= $l['nama_rak']; ?></td>
            <td><?= $l['nama_penerbit']; ?></td>
            <td><?= $l['status']; ?></td>
            <td><?= $l['pinjam']; ?></td>
            <td><?= $l['kembali']; ?></td>
            <td><?= $l['terlambat'].' HARI'; ?></td>
            <td><?= $l['denda']; ?></td>
          </tr>
          <?php $no++; endforeach; ?>
        </tbody>
      </table>
      <table class="table my-4 table-borderless">
          <tr>
              <td>
                <br>
                  <p class="text-center">Mengetahui,<br>Kepala Sekolah</p>
                  <br><br><br>
                  <p class="my-0 text-center"><b><?= $sekolah['kepsek']; ?></b><br>
                  NIP : <span><?= $sekolah['nipkepsek']; ?></span></p>
              </td>
              <td>
                  <p class="text-center"><?= $sekolah['kecamatan']; ?>, <?= DATE('d-m-Y'); ?><br>
                  Ketua Perpustakaan</p>
                  <br><br><br><br>
                  <p class="my-0 text-center"><b><?= $sekolah['ketua']; ?></b><br>
                  NIP : <span><?= $sekolah['nipketua']; ?></span></p>
              </td>
          </tr>
      </table>
    </section>
</body>
</html>
<script>
    // setTimeout(function () { window.print(); }, 500);
    // window.onfocus = function () { setTimeout(function () { window.close(); }, 500); }
</script>
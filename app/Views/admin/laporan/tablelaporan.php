<?= $this->extend('admin/template/template'); ?>
 <!-- Content Wrapper. Contains page content -->
 <?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<?php 
function mapped_implode($glue, $array, $symbol = ',') {
  return implode($glue, array_map(
          function($k, $v) use($symbol) { 
              return $k.$symbol.$v;
          }, 
          array_keys($array), 
          array_values($array)
          )
      );
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('pustakawan'); ?>">Pustakawan</a></li>
              <li class="breadcrumb-item">Laporan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-lg-12">
            <div class="card border-success my-3" style="">
              <div class="card-body">
                <h3>Laporan Berdasarkan</h3>
                <form action="<?= base_url('pustakawan/laporan'); ?>" method="post" class="form-inline">
                    <select name="status" class="form-control my-1 mx-2" id="status" placeholder="KELAS">
                      <option value="" selected hidden>STATUS</option>
                      <option></option>
                      <option value="kembali">DIKEMBALIKAN</option>
                      <option value="pinjam">DIPINJAM</option>
                    </select>
                  <label for="awal">Dari :</label>
                  <input type="date" id="awal" class="form-control my-1 mx-2" name="awal" id="awal">
                  <label id="labelakhir" for="awal">Sampai :</label>
                  <input type="date" class="form-control my-1 mx-2" name="akhir" id="akhir">
                  <input type="text" name="nis" class="form-control my-1 mx-2" id="nis" placeholder="NIS SISWA">
                  <input type="text" name="nama" id="nama" class="form-control my-1 mx-2" placeholder="NAMA SISWA">
                  <!-- <label for="awal">Kelas :</label> -->
                  <select name="kelas" class="form-control my-1 mx-2" id="kelas" placeholder="KELAS">
                    <option value="" selected hidden>KELAS</option>
                    <option value=""></option>
                    <?php foreach($kelas as $k) : ?>
                      <option value="<?= $k['kode_kelas']; ?>"><?= $k['nama_kelas']; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <button type="submit" value="lapor" name="lapor" class="btn btn-success my-1 mx-2"><i class="fas fa-solid fa-search"></i> CARI</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="card-title">
                    <h3>Laporan Transaksi</h3>
                    <form target="_blank" action="<?= base_url('pustakawan/transaksi/pdf'); ?>" method="post" class="d-inline">
                      <input type="hidden" name="where" value="<?= mapped_implode(',',$where); ?>">
                      <button type="submit" class="btn btn-primary my-1">LAPORAN PDF</button>
                    </form>
                    <!-- <button type="button" class="btn btn-success my-1"><i class="fas fa-solid fa-arrow-down"></i> UNDUH EXCEL</button>
                    <button type="button" class="btn btn-success my-1"><i class="fas fa-solid fa-arrow-up"></i> IMPORT DATA DENDA</button> -->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                <table id="example1" class="table table-bordered table-hover">
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
                  <tfoot>
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
                  </tfoot>
                </table>
                  </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?= $this->endSection(); ?>
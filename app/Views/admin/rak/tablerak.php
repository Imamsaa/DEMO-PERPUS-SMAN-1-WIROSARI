<?= $this->extend('admin/template/template'); ?>
 <!-- Content Wrapper. Contains page content -->
 <?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Rak Buku</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('pustakawan'); ?>">Pustakawan</a></li>
              <li class="breadcrumb-item">Rak Buku</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="card-title">
                    <h3>DAFTAR RAK BUKU</h3>
                    <a href="<?= base_url('pustakawan/rak/tambah'); ?>" class="btn btn-primary my-1"><i class="fas fa-solid fa-plus"></i> TAMBAHKAN RAK BUKU</a>
                    <button type="button" class="btn btn-success my-1"><i class="fas fa-solid fa-arrow-down"></i> UNDUH EXCEL</button>
                    <button type="button" class="btn btn-success my-1"><i class="fas fa-solid fa-arrow-up"></i> IMPORT DATA RAK BUKU</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>NO</th>
                    <th>KODE RAK BUKU</th>
                    <th>NAMA RAK BUKU</th>
                    <th>ACTION</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>1</td>
                    <td>R12</td>
                    <td>Kisah</td>
                    <td>
                        <a href="<?= base_url('pustakawan/rak/ubah'); ?>" class="btn btn-primary mb-1" ><i class="fas fa-solid fa-pen"></i></a>
                        <button type="button" class="btn btn-danger mb-1" ><i class="fas fa-solid fa-trash"></i></button>
                    </td>
                  </tr>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>NO</th>
                    <th>KODE RAK BUKU</th>
                    <th>NAMA RAK BUKU</th>
                    <th>ACTION</th>
                  </tr>
                  </tfoot>
                </table>
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
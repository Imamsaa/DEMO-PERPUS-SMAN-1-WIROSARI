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
            <h1 class="m-0">Ubah Profil</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('pustakawan'); ?>">Pustakawan</a></li>
              <li class="breadcrumb-item">Profil</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- ROW -->
        <div class="row">
            <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <div class="card-title">
                    <h3>Ubah Profil Pustakawan</h3>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="row mb-2">
                    <div class="col-md-3 my-2 col-sm-12">
                      <img src="<?= base_url('admin/img/siswa_default.jpg'); ?>" alt="Foto Siswa" class="img-thumbnail">
                    </div>
                    <div class="col-md-9 col-sm-12">
                      <div class="form-group">
                        <label for="foto">Unggah Foto Pustakawan</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input name="foto" type="file" class="custom-file-input" id="foto">
                            <label class="custom-file-label" for="foto">Pilih file gambar</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="form-group">
                      <label for="nis">NIS Siswa</label>
                      <input type="text" name="nis" class="form-control" id="nis" placeholder="" readonly>
                  </div>
                  <div class="form-group">
                    <label for="nisn">NISN Siswa</label>
                    <input type="text" name="nisn" class="form-control" id="nisn" placeholder="">
                  </div> -->
                  <div class="form-group">
                    <label for="nama">Nama Pustakawan</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="">
                  </div>
                  <!-- <div class="form-group">
                      <label for="kelas">Pilih Kelas</label>
                      <select id="kelas" name="kelas" class="form-control">
                        <option>option 1</option>
                        <option>option 2</option>
                        <option>option 3</option>
                        <option>option 4</option>
                        <option>option 5</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="tahun">Pilih Tahun Ajaran</label>
                      <select id="tahun" name="tahun" class="form-control">
                        <option>option 1</option>
                        <option>option 2</option>
                        <option>option 3</option>
                        <option>option 4</option>
                        <option>option 5</option>
                      </select>
                    </div> -->
                  <div class="form-group">
                    <label for="nomorwa">Nomor WhastApp</label>
                    <input type="text" name="nomorwa" class="form-control" id="nomorwa" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="email">Email Pustakawan</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat Pustakawan</label>
                    <textarea name="alamat" class="form-control" id="alamat" rows="3"></textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary my-1"><i class="fas fa-solid fa-pen"></i> Ubah Profil</button>
                  <a href="<?= base_url('pustakawan/profil'); ?>" class="btn btn-danger my-1"><i class="fas fa-solid fa-ban"></i> Batal</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?= $this->endSection(); ?>
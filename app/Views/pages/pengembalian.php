<?= $this->extend('template'); ?>
<?= $this->section('tampilan'); ?>
<div class="col-md-7 mt-5 d-none d-md-flex">
    <div class="col-md-6 text-white text-center text-md-left mt-xl-5 mb-3 mx-auto" >
        <div class="text-center mt-5">
            <img class="mx-auto d-block" src="admin/img/<?= $sekolah['logo']; ?>" width="140px"> 
        </div>    
        <h1 class="h1-responsive text-center font-weight-bold mt-sm-2">SELAMAT DATANG DI<br><?= $perpus['nama_perpus']; ?><br><?= $sekolah['nama_sekolah']; ?></h1>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('form'); ?>
<div class="col-md-5 bg-login">
    <div class="login d-flex align-items-center py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 mx-auto">              
                    <h1 class="h1-responsive text-center text-white font-weight-bold">FORM</h1><h2 class="h1-responsive text-center text-white font-weight-bold mb-4">PENGEMBALIAN</h2> 
                    <form>
                        <div class="form-group mb-3">
                            <input id="inputEmail" type="text" placeholder="NIS SISWA" required="" autofocus="" class="form-control rounded-pill border-0 shadow-sm px-4">
                        </div>
                        <div class="form-group mb-3">
                            <input id="inputPassword" type="text" placeholder="KODE BUKU" required="" class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">PINJAM</button>       
                    </form>
                </div>
            </div>
        </div><!-- End -->
    </div>
</div>
<?= $this->endSection(); ?>
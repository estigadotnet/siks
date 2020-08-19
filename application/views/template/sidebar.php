<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo site_url(); ?>" class="brand-link">
    <img src="<?php echo base_url(); ?>assets/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">SIKS v1.0</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <!-- <img src="<?php //echo base_url(); ?>assets/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
      </div>
      <div class="info">
        <!-- <a href="#" class="d-block"><?php //echo $namasekolah; ?>X</a> -->
        <div class="row">
          <a href="#" class="d-block"><?php echo $this->session->userdata("namasekolah"); ?></a>
        </div>
        <div class="row">
          <a href="#" class="d-block"><?php echo $this->session->userdata("tahunajaran"); ?></a>
        </div>
        <!-- <p><?php //echo $this->session->flashdata("tahunajaran"); ?></p> -->
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-child-indent nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <!-- dashboard -->
        <!-- <li class="nav-item has-treeview menu-open"> -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard (Demo)
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>assets/adminlte/index.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard v1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>assets/adminlte/index2.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard v2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>assets/adminlte/index3.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard v3</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- home-->
        <li class="nav-item">
          <a href="<?php echo site_url(); ?>" class="nav-link">
            <i class="fa fa-home nav-icon"></i>
            <p>Home</p>
          </a>
        </li>

        <!-- setup -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-database"></i>
            <p>Setup<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t000_sekolah" class="nav-link">
                <i class="fas fa-school nav-icon"></i>
                <p>Sekolah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t001_tahunajaran" class="nav-link">
                <i class="far fa-calendar-alt nav-icon"></i>
                <p>Tahun Ajaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t002_guru" class="nav-link">
                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                <p>Wali Kelas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t003_kelas" class="nav-link">
                <i class="fas fa-door-open nav-icon"></i>
                <p>Kelas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t004_siswa" class="nav-link">
                <i class="fas fa-users nav-icon"></i>
                <p>Siswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t005_nonrutin" class="nav-link">
                <i class="fas fa-donate nav-icon"></i>
                <p>Pembayaran Non-Rutin</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- transaksi -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-calculator"></i>
            <p>Transaksi<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t101_spp" class="nav-link">
                <i class="fas fa-file-invoice nav-icon"></i>
                <p>Pembayaran SPP</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?php //echo site_url(); ?>t101_spp/ubah_spp" class="nav-link">
                <i class="fas fa-edit nav-icon"></i>
                <p>Ubah SPP</p>
              </a>
            </li> -->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-edit nav-icon"></i>
                <p>Ubah SPP<i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo site_url(); ?>t101_spp/ubah_spp_siswa" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>per Siswa</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo site_url(); ?>t101_spp/ubah_spp2" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>per Kelas</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t103_nonrutin" class="nav-link">
                <i class="fas fa-file-invoice nav-icon"></i>
                <p>Pembayaran Non-Rutin</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t102_pengeluaran" class="nav-link">
                <i class="fas fa-shopping-cart nav-icon"></i>
                <p>Belanja Sekolah</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- laporan -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>Laporan<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t101_spp/laporan" class="nav-link">
                <i class="fas fa-list-alt nav-icon"></i>
                <p>Pembayaran SPP</p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-exclamation nav-icon"></i>
                <p>Tunggakan SPP<i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo site_url(); ?>t101_spp/tunggakan_tgl" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>per Tanggal</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo site_url(); ?>t101_spp/tunggakan_nis" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>per Siswa</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo site_url(); ?>t101_spp/tunggak_kelas" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>per Kelas</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t103_nonrutin/laporan" class="nav-link">
                <i class="fas fa-list-alt nav-icon"></i>
                <p>Pembayaran Non-Rutin</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>t102_pengeluaran/laporan" class="nav-link">
                <i class="fas fa-cash-register nav-icon"></i>
                <p>Belanja Sekolah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url(); ?>mutasi/laporan" class="nav-link">
                <i class="fas fa-exchange-alt nav-icon"></i>
                <p>Mutasi Rekening</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Login or logout -->
        <li class="nav-item">
          <?php if ($this->session->userdata("tahunajaran") != "") { ?>
          <a href="<?php echo site_url(); ?>auth/logout" class="nav-link">
            <i class="fas fa-sign-out-alt nav-icon"></i>
            <p>Logout</p>
          </a>
          <?php } else { ?>
            <a href="<?php echo site_url(); ?>auth/login" class="nav-link">
              <i class="fas fa-sign-in-alt nav-icon"></i>
              <p>Login</p>
            </a>
          <?php }?>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

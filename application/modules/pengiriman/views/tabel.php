<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Dashboard - ESC Indonesia</title>
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
	<link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css') ?>">
</head>

<body id="page-top">
  <div id="wrapper">
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
      <div class="container-fluid d-flex flex-column p-0">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="<?= site_url() ?>">
          <div class="sidebar-brand-icon rotate-n-15"><i class="fab fa-phoenix-framework"></i></div>
          <div class="sidebar-brand-text mx-3"><span>ESC Indonesia</span></div>
        </a>
        <hr class="sidebar-divider my-0">
        <ul class="nav navbar-nav text-light" id="accordionSidebar">
          <li class="nav-item" role="presentation"></li>
          <li class="nav-item" role="presentation"><a class="nav-link active" href="<?= site_url('pengiriman') ?>"><i class="fas fa-table"></i><span>Data Pengiriman</span></a></li>
        </ul>
        <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
      </div>
    </nav>
    <div class="d-flex flex-column" id="content-wrapper">
      <div id="content">
        <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
          <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
            <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
              <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
              </div>
            </form>
            <ul class="nav navbar-nav flex-nowrap ml-auto">
              <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" role="menu" aria-labelledby="searchDropdown">
                  <form class="form-inline mr-auto navbar-search w-100">
                    <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                      <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                    </div>
                  </form>
                </div>
              </li>
              <li class="nav-item dropdown no-arrow mx-1" role="presentation"></li>
              <li class="nav-item dropdown no-arrow mx-1" role="presentation">
                <div class="shadow dropdown-list dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown"></div>
              </li>
              <div class="d-none d-sm-block topbar-divider"></div>
              <li class="nav-item dropdown no-arrow" role="presentation">
                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small"><?= $full_name; ?></span></a>
                  <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
                    <a class="dropdown-item" role="presentation" href="<?= site_url('auth/logout') ?>"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a>
                  </div>
              </div>
            </li>
          </ul>
        </div>
      </nav>
      <div class="container-fluid">
        <h3 class="text-dark mb-4">Data Pengiriman</h3>
        <div class="card shadow">
          <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Barang Dikirim</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 text-nowrap">
                <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label>Show&nbsp;<select class="form-control form-control-sm custom-select custom-select-sm"><option value="10" selected="">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>&nbsp;</label></div>
              </div>
              <div class="col-md-6">
                <div class="text-md-right dataTables_filter" id="dataTable_filter"><label><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label></div>
              </div>
            </div>
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
              <table class="table my-0" id="dataTable">
                <thead>
                  <tr>
										<th>Resi</th>
                    <th>Pengirim</th>
                    <th>Penerima</th>
                    <th>Berat Total</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item) : ?>
                  <tr>
                    <td><?= $item->resi ?></td>
                    <td><b><?= $item->pengirim ?></b><br><p><?= $item->alamat_pengirim ?></p></td>
                    <td><b><?= $item->penerima ?></b><br><p><?= $item->alamat_penerima ?></p></td>
                    <td><?= number_format((double) $item->berat_total / 1000,2,',','.') ?> kilogram</td>
                    <td>
                      <dl>
                      <?php $r = $item->riwayat[0]; ?>
                        <dt><?= $r->status ?></dt>
                        <dd><?= $r->waktu ?></dd>
                      
                      </dl>
                    </td>
                    <td>
                    <?php
                      if(!empty($item->riwayat))
                      {
                        if ($item->riwayat[0]->status == 'Diterima')
                        {
                          $url = '#';
                          $text = 'Sudah Diterima';
                          $disabled = true;
                        }

                        else if ($item->riwayat[0]->status == 'Dikirim')
                        {
                          $url = site_url('pengiriman/terima?id='.$item->id);
                          $text = 'Terima';
                          $disabled = false;
                        }
                        else
                        {
                          $url = site_url('pengiriman/kirim?id='.$item->id);
                          $text = 'Kirim';
                          $disabled = false;
                        }
                      }
                    ?>
                      <a href="<?= $url ?>" class="btn btn-secondary<?= $disabled ? ' disabled' : '' ?>"><?= $text ?></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Resi</th>
                    <th>Pengirim</th>
                    <th>Penerima</th>
                    <th>Berat Total</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="row">
              <div class="col-md-6 align-self-center">
                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of 27</p>
              </div>
              <div class="col-md-6">
                <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                  <ul class="pagination">
                    <!-- Previous page -->
                  <?php if ($page <= 1): ?>
                    <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                  <?php else : ?>
                    <li class="page-item"><a class="page-link" href="<?= site_url('pengiriman?page='.($page-1)) ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                  <?php endif; ?>
                    <!-- Page numbers -->
                  <?php for ($i = 1; $i <= $pages; $i++) : ?>
                  <?php if ($page === $i): ?>
                    <li class="page-item disabled"><a class="page-link" href="#"><?= $i ?></a></li>
                  <?php else : ?>
                    <li class="page-item"><a class="page-link" href="<?= site_url('pengiriman?page='.$i) ?>"><?= $i ?></a></li>
                  <?php endif; ?>
                  <?php endfor; ?>
                    <!-- Next page -->
                  <?php if ($page >= $pages): ?>
                    <li class="page-item disabled"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                  <?php else : ?>
                    <li class="page-item"><a class="page-link" href="<?= site_url('pengiriman?page='.($page+1))?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                  <?php endif; ?>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="bg-white sticky-footer">
      <div class="container my-auto">
        <div class="text-center my-auto copyright"><span>Copyright © ESC Indonesia 2020</span></div>
      </div>
    </footer>
  </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
	<script src="<?= base_url('assets/js/script.min.js') ?>"></script>
</body>

</html>
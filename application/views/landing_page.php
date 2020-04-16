<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Toko Alwan</title>

  <!-- Bootstrap core CSS -->
  <link href="<?= base_url('user-assets/') ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?= base_url('user-assets/') ?>css/shop-homepage.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url() ?>">Toko Alwan</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Beranda
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#order">Pemesanan</a>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">

        <h4 class="my-4">Kategori Produk</h4>
        <div class="search">
          <div class="form-group">
            <?php echo form_open('home/index', ['method' => 'get']) ?>
              <div class="row">
                <div class="col-9">
                  <?php
                    $form = array(
                      'name' => 'search',
                      'id' => 'search',
                      'class' => 'form-control',
                      'options' => $list_categories,
                      'selected' => $search
                    );
                    echo form_dropdown($form);
                  ?>
                </div>
                <div class="col-3">
                  <button type="submit" class="btn btn-primary">Filter</button>
                </div>
              </div>
          <?php echo form_close(); ?>
          </div>
        </div>

      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="<?= base_url('user-assets/') . 'icon/slide-1.jpg'?>" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="<?= base_url('user-assets/') . 'icon/slide-2.jpg'?>" alt="Second slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row" id="product">

          <?php if(count($products)):?>
            <?php foreach ($products as $key => $product) :?>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <a href="#"><img class="card-img-top" src="<?= $product->image ?>" alt=""></a>
                  <div class="card-body">
                    <h4 class="card-title">
                      <a href="#"><?= $product->name ?></a>
                    </h4>
                    <h5>Rp. <?= number_format($product->price) ?></h5>
                    <p class="card-text"><?= $product->description ?></p>
                  </div>
                  <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                  </div>
                </div>
              </div>
            <?php endforeach?>
            <?php else: ?>
              <div class="text-center col-12 mt-5 mb-5">
                <h4>Produk Kosong!</h4>
              </div>
            <?php endif; ?>
        </div>
        <!-- /.row -->
        <?php echo (isset($pagination_links)) ? $pagination_links : '';  ?>

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->
    <div class="row mb-5 mt-3" id="order">
      <div class="container ml-2">

        <div class="text-center">
          <h5>Tertarik untuk membeli produk kami?</h5>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="card shadow" style="border-radius: 10px">
              <div class="row">
                <div class="col-4 p-3 card-name">
                  <div class="mb-2 mt-3 text-center">
                    <img src="<?= base_url('user-assets/') . 'icon/logo.png'?>" alt="image" width="80rem">
                  </div>
                  <div class="text-center">
                    <a href="#" class="btn btn-sm btn-name">Toko Alwan</a>
                  </div>
                </div>
                <div class="col-8 p-4 text-center">
                  <h4>Toko Alwan</h4>
                  <p>Mall Mandonga Kendari, <br> Lt. Basement Blok B/5</p>
                  <div class="row justify-content-center">
                    <div class="col-1">
                      <img src="<?= base_url('user-assets/') . 'icon/whatsapp.png' ?>" alt="" width="20px">
                    </div>
                    <div class="col-8">
                      <p>081234567890</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-4 bg-light">
    <div class="container">
      <p class="m-0 text-center">&copy; Toko Alwan</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="<?= base_url('user-assets/') ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('user-assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="<?= base_url('user-assets/') ?>vendor/main.js"></script> -->

</body>

</html>

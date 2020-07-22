<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Login - ESC Indonesia</title>
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css') ?>">
</head>

<body>
  <div class="container h-100">
    <div class="row justify-content-center h-100">
      <div class="col-md-9 col-lg-12 col-xl-10 my-auto">
        <div class="card shadow-lg o-hidden border-0 my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-flex">
                <div class="flex-grow-1 bg-login-image" style="background: url(<?= base_url('assets/img/delivery/rosebox-BFdSCxmqvYc-unsplash.jpg') ?>) 50% 20% / cover;"></div>
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h4 class="text-dark mb-4">Generate API Key</h4>
                  </div>
                  <?= form_open('control/generate_api',array('class' => 'user')) ?>
                    <div class="form-group"><?php echo form_input('identifier','','class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Set Website Identifier..."');?><?= form_error('identifier','<small class="help-text text-danger">','</small>') ?></div>
                    <button class="btn btn-primary btn-block text-white btn-user" type="submit">Generate API Key</button>
                    <hr>
                  </form>
                  <div class="text-center"><a href="<?= site_url('control') ?>">Back to API List</a></div>
                  <div class="text-center"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
  <script src="<?= base_url('assets/js/script.min.js') ?>"></script>
</body>

</html>
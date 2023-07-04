<!doctype html>
<html lang="en">

<head>
  <?php include "includes/head.php";  ?>
  <link rel="stylesheet" href="public/theme/css/custom.css" />
</head>

<body>
  <div class="box1"></div>
  <div class="box2"></div>
  <div class="box3"></div>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="public/theme/images/logo.png" width="280" alt="">
                </a>
                <p class="text-center">Your HRIS Account</p>
                <form id="hrisForm">
                  <div class="mb-3">
                    <label for="hrisUsername" class="form-label labeltext">Username</label>
                    <input type="text" class="form-control" name="hrisusername" id="hrisUsername" autofocus>
                  </div>
                  <div class="mb-4">
                    <label for="hrisPass" class="form-label labeltext">Password</label>
                    <input type="password" class="form-control" name="hrispass" id="hrisPass">
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" id="signInBtn">Sign In</button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>













  <?php include("includes/scripts.php"); ?>
  <script src="public/app/login.js"></script>

</body>




</html>
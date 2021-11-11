<?php include_once 'inc/code.php' ?>
<?php if (!isset($_SESSION['user_login'])):
        header('location:login.php');
        ?>

<?php else: ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include_once 'links/head.php' ?>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include_once 'links/topbar.php' ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include_once 'links/sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-capitalize">
              <?=@$_REQUEST['nav'] == ""? "dashboard":str_replace("_", " ", $_REQUEST['nav']);?>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active text-capitalize">
                <?=@$_REQUEST['nav'] == ""? "dashboard":str_replace("_", " ", $_REQUEST['nav']);?>
              </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
        
    <span id="responseArea"></span>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <?php include_once $page ?>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<?php include_once 'links/foot.php' ?>
<script>
  var nav = '<?=@empty($_REQUEST['nav'])?"dashboard":$_REQUEST['nav'];?>';
  $(".menu_"+nav).addClass('menu-open')
  $(".menu2_"+nav).addClass('active')
  $("."+nav).addClass('active');
</script>
</body>
</html>
<?php endif; ?>

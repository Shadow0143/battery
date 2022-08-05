<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/summernote/summernote-bs4.css')}}">
  @yield('css')
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
@include('admin.layout.top-bar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->

@include('admin.layout.left-bar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
@yield('body-content')
  </div>
  <!-- /.content-wrapper -->

@include('admin.layout.footer')
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> 
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<!-- <script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script> -->
<!-- jQuery Knob Chart -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/moment/moment.min.js')}}"></script>
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/daterangepicker/daterangepicker.js')}}"></script>




<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/dist/js/demo.js')}}"></script>


{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet" type="text/css" /> --}}




<script>
    function onClickDelete(e) {
        if(!confirm('Are you want to delete ?')){
            e.preventDefault();
            return false;
        }
    }
</script>


<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
<link href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css" rel="stylesheet" media="screen">

<link href="https://cdn.datatables.net/colreorder/1.5.1/css/colReorder.dataTables.min.css" rel="stylesheet" media="screen">
<link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet" media="screen">
<!-- <link type="text/css" rel="stylesheet" href="https://www.eparivahan.com/validator/css/validationEngine.jquery.css"> -->
<!-- <link type="text/css" rel="stylesheet" href="https://www.eparivahan.com/css/style.css"> -->
<!--<script src="https://eparivahan.com/js/jquery-2.1.1.min.js"></script>-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script> -->


<script type="text/javascript" src="https://cdn.datatables.net/colreorder/1.5.1/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>


 

<script type="text/javascript">
     $(document).ready(function() {
      $('#pagi').DataTable({
        paging: true,
        "ordering": true,
        "order": [[0, 'desc' ]],
        //"lengthChange": false,
        //"searching": false,
      });
    });
</script>

</body>
</html>

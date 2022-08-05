<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@extends('admin.layout.app')
  @section('title')
    Admin |All Stock In / Out
  @endsection
@section('body-content')

<style>
  .card-header li
  {
    display: inline-block;
  }
  .card-header li form
  {
    float: right;
    margin-left: 617px !important;
    margin-top: 6px;
  }
  .subbtn{
    border: 1px solid #ced4da;
  }
  .content-wrapper>.content{
    position: relative;
  }
  #loader{
    position: absolute;
    z-index: 2;
    background-color: rgb(255 255 255 / 90%);
    width: 100%;
    height: calc(100vh - 145px);
  }
  #loader img{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
</style>


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Stock In / Out</h1>
      </div>

      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Stock In / Out</li>
        </ol>
      </div>

    </div>
  </div>
</section>


@include('admin.layout.alert')

<section class="content">
  <div id="loader">
    <img src="{{ asset('images/loader.gif') }}" alt="loader">
  </div>

  <div class="card">
    <div class="card-header">
        <!-- <li>
        <form class="form-inline ml-6" action="{{route('admin.all-stock.search')}}" method="post">
            @csrf
            <div class="input-group input-group-sm">
    <input type="date" class="form-control form-control-navbar" name="start_date" value="{{ $start_date }}" placeholder="Start Date"> 
    <input type="date" class="form-control form-control-navbar" name="end_date" value="{{ $end_date }}" placeholder="Start Date">
    <input class="form-control form-control-navbar" type="text" name="search" placeholder="Search Text" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar subbtn" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </form>
        </li> -->

      <div class="card-tools col-12">
        <div class="col-12">
          <div class="row">
            <div class="col-8 pr-5 "> 
              <h5 class="text-danger"> * Last 30 days record showing </h5>
            </div>
            <div class="col-4 text-right">
              <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#myModal">Download</a> 
            </div>
          </div>
        </div>

        <div class="card-tools col-12 mt-3">
          <div class="row">
            <div class="col-4">
              <label for="start_date"> Start Date</label>
              <input type="text" name="" id="start_date_forsearch">
              <p>
                <span class="text-danger" id="startdate-error-mssg" style="display:none;">Please Select Start Date</span>
              </p>
            </div>
            <div class="col-4">
              <label for="end_date">End Date</label>
              <input type="text" name="" id="end_date_forsearch">
              <span class="text-danger" id="enddate-error-mssg" style="display:none;">Please Select End Date</span>

            </div>
            <div class="col-4">
              <a href="javaScript:void(0);" class="btn btn-outline-primary"style="border-radius:50%;width:30px;padding:5px;" title="Search" id="search-button" > <i class="fa-solid fa-magnifying-glass"></i>  </a>
            </div>
          </div>
        </div>

       
      <!-- <a href="{{route('admin.all-stock.inout_print')}}" class="btn btn-primary" target="_blank" onclick="return confirm('Do you want to Print Now?')" >Print</a>  -->


      
<!-- Modal popup start-->
<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Stock In / Out Print</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
              <form action="{{route('admin.all-stock.inout_print')}}" class="form" target="_blank" enctype="multipart/form-data" method="post" onsubmit="return validateForm()">
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                <div class="row">
                  <input type="hidden" name="datatype" id="datatype" value="" />

                  <div class="form-group col-lg-6">
                    <label class="control-label">Start Date</label>
                    <input type="text" class="form-control" name="start_date" id="start_date" value="" readonly="readonly" style="cursor: pointer; background-color: #ffffff;">
                    <p class="text-danger" id="error_start_date_mssg" style="display:none;">* Please select start date</p>
                  </div>
                  
                  <div class="form-group col-lg-6">
                    <label class="control-label">End Date</label>
                    <input type="text" class="form-control" name="end_date" id="end_date" value="" readonly="readonly" style="cursor: pointer; background-color: #ffffff;" ">
                    {{-- onchange="datefilter() --}}
                    <p class="text-danger" id="error_date_mssg" style="display:none;">* You can only select maximum 31 days</p>
                  </div>

                  <div class="form-group col-lg-12">
                    <label class="control-label">Invoice</label>
                    <input type="text" class="form-control" name="invoice" id="invoice" value="">
                  </div>

                  <div class="form-group col-lg-12">
                    <label class="control-label">Product Name</label>
                    <input type="text" class="form-control" name="product" id="product" value="">
                  </div>

                  <div class="form-group col-lg-12">
                    <label class="control-label">Customers / Dealer</label>
                    <input type="text" class="form-control" name="cust_name" id="cust_name" value="">
                  </div>

                </div>

                <div class="" style="text-align: left;">
                  <button type="Submit" class="btn btn-primary" onclick="csvDownload();">CSV</button>
                  <button type="Submit" class="btn btn-primary" onclick="pdfDownload();">PDF</button>
                </div>

              </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
        </div>
        
      </div>
    </div>
  </div>
<!-- Modal popup end-->

       <!--  <a href="{{route('admin.stock.add')}}" class="btn btn-primary">Add Stock New</a> -->
        {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button> --}}
      </div>
    </div>

    <div class="card-body p-0" id="will_remove">
      @include('admin.all-stock.ajax_seach_b_date')
      
    </div>

    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</section>
<!-- /.content -->
<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $(document).ready(function() {
      
    $("#start_date").datepicker( { dateFormat: "dd-mm-yy"} );
    $("#end_date").datepicker({ dateFormat: "dd-mm-yy"}).datepicker("setDate", new Date());
    // $("#end_date").datepicker({ dateFormat: "dd-mm-yy"});

    $("#start_date_forsearch").datepicker( { dateFormat: "dd-mm-yy"} );
    $("#end_date_forsearch").datepicker({ dateFormat: "dd-mm-yy"}).datepicker("setDate", new Date());
    $('#startdate-error-mssg').hide();
    $('#enddate-error-mssg').hide();
    

        $.ajax({
        url: "/admin/all-stock/search-by-date-inout",
        type: 'GET',
        data: {
        },
        success: function(data) {
            $('#will_remove').html(data);
            $('#pagi').DataTable({ 
              "destroy": true, //use for reinitialize datatable
              "paging": true,
              "ordering": true,
              "order": [[0, 'desc' ]],
              "lengthChange": false,
              "searching": false,
            });
            $('#loader').hide();
        }
        });
  });
</script>
<script>
  function datefilter(){
    var start_date = $('#start_date').val();
    var date = new Date(start_date);
    var last_date = date.setDate(date.getDate()+31);
    console.log(start_date);
    console.log(date);
    console.log(last_date);

    var end_date = $('#end_date').val();
    if(start_date == ''){
        $('#error_start_date_mssg').show();
    }
    if(start_date != ''){
        $('#error_start_date_mssg').hide();
    }

    
    else{
   
    //   $('#error_date_mssg').show();
    }
  }
</script>

<script>
  $("#search-button").on("click", function() {  
      var start_date = $('#start_date_forsearch').val();
      var end_date = $('#end_date_forsearch').val();

      if(start_date == '')
      {
          $('#startdate-error-mssg').show();
      }else{
        $('#startdate-error-mssg').hide();
         $('#enddate-error-mssg').hide();
         $('#loader').show();
        $.ajax({
        url: "/admin/all-stock/search-by-date-inout",
        type: 'GET',
        data: {
          start_date:start_date,
          end_date:end_date,
        },
        success: function(data) {
            $('#will_remove').html(data);
            $('#pagi').DataTable({ 
              "destroy": true, //use for reinitialize datatable
              "paging": true,
              "ordering": true,
              "order": [[0, 'desc' ]],
              "lengthChange": false,
              "searching": false,
            });
            $('#loader').hide();

        }
        });
      }

     
  });
</script>


<script>
  function validateForm(){
   
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val(); 
    var invoice = $('#invoice').val(); 
    var product = $('#product').val(); 
    var cust_name = $('#cust_name').val(); 
   
      // if(startDate == '' &&  endDate == '' && invoice == '' && product == '' && cust_name == ''){
      //   alert('Please Input any one');
      //   return false;
      // }

        if (startDate > endDate){
            alert('Start Date should not be greater than End Date');
         // $('#start_date').val('');
         // $('#end_date').val('');
          return false;
        } 
    
  }


  function pdfDownload(){
    $('#datatype').val('pdf');
  }

  function csvDownload(){
    $('#datatype').val('csv');
   // $('form[target="_blank"]').removeAttr('target');
  }

</script>

@stop


@extends('admin.layout.app')
@section('title')
    Admin | Stock New Edit
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Purchase New</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Edit Purchase New</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@include('admin.layout.alert')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit Purchase New</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          <form role="form"  action="{{route('admin.stock.edit',$item->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body row">

              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Dealer Name *</label>
                <select  class="form-control select2" name="ref_customer">
                  <option value="" selected="selected" disabled="disabled">-- select one --</option>
                  @foreach($customers as $customer)
                  @if($customer->type==1)
                  <option value="{{$customer->id}}"  {{ (isset($item)&&$item->ref_customer == $customer->id)?'selected':''}}>{{$customer->name}}</option>
                  @endif
                  @endforeach
                </select>
              </div>

              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Invoice No *</label>
                <input type="text" class="form-control" placeholder="Please Enter Invoice Number" name="invoice" value="{{ $item->invoice }}">
              </div>
            
              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Invoice Date *</label>
                <input type="text" class="form-control datepicker" name="invoicedate" value="@if(isset($item->invoicedate)){!!date('d-m-Y', strtotime($item->invoicedate))!!}@endif" readonly="readonly" style="cursor: pointer; background-color: #ffffff;" required>
              </div>

              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Entry Date *</label>
                <input type="text" class="form-control datepicker" name="date" value="@if(isset($item->date)){!!date('d-m-Y', strtotime($item->date))!!}@endif" readonly="readonly" style="cursor: pointer; background-color: #ffffff;" required>
              </div>
            </div>

            <div class="col-sm-10 omg-row-area">
                <a href="{{route('admin.edit-stock.add',$item->id)}}" class="btn btn-primary">Add Product</a>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="dynamic_field">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                          <tbody>
                            @php($produts=App\Models\Stock::where('ref_stock_detail',$item->id)->get())
                            @foreach($produts as $produt)
                           <tr id="row1">
                                <td>
                                    <?php
                                        $product_name=App\Models\Product::find($produt->ref_product)
                                    ?>
                                    @if($product_name != null)
                                    {{$product_name->name}}
                                    @endif
                                </td>
                                <td>
                                  {{$produt->quantity}}
                                </td>
                                <td>
                                  <a class="btn btn-info btn-sm" href="{{route('admin.edit-stock.edit',$produt->id)}}">
                                      <i class="fas fa-pencil-alt">
                                      </i>
                                      Edit
                                  </a>
                                  <a onclick="onClickDelete(event)" class="btn btn-danger btn-sm" href="{{route('admin.edit-stock.delete',$produt->id)}}">
                                      <i class="fas fa-trash">
                                       </i>
                                      Delete
                                  </a>
                                </td>
                           </tr>
                           @endforeach
                         </tbody>
                      </table>
                    </div>
                </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="{{route('admin.stock.view')}}" class="btn btn-primary">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>

<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>


<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $('.select2').select2();

  $(document).ready(function() {
    $('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' }); 
  });
</script>

<style type="text/css">
  label.error { color: red }
  .select2-container .select2-selection--single{height: 39px;border: 1px solid #ced4da;}
  .select2-container--default .select2-selection--single .select2-selection__arrow{height:100%;}
</style>

@stop

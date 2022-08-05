@extends('admin.layout.app')
@section('title')
    Admin | Purchase New Add
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add Purchase New</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Add Purchase New</li>
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
            <h3 class="card-title">Add Purchase New</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          <form role="form"  action="{{route('admin.stock.add')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="card-body row">

              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Dealer Name *</label>
                <select  class="form-control select2" name="ref_customer" required>
                  <option value="" selected="selected" disabled="disabled">-- select one --</option>
                  @foreach($customers as $customer)
                  @if($customer->type==1)
                  <option value="{{$customer->id}}">{{$customer->name}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
          
              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Invoice No *</label>
                <input type="text" class="form-control" placeholder="Please Enter Invoice Number" name="invoice" value="{{ old('invoice') }}">
              </div>
           
              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Invoice Date *</label>
                <input type="text" class="form-control datepicker" name="invoicedate" value="{{ old('invoicedate') }}" readonly="readonly" style="cursor: pointer; background-color: #ffffff;" required>
              </div>
            
              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Entry Date *</label>
                <input type="text" class="form-control datepicker" name="date" value="{{ old('date') }}" readonly="readonly" style="cursor: pointer; background-color: #ffffff;" required>
              </div>
            </div>

            <div class="col-sm-10 omg-row-area">
                            <button class="btn btn-primary btn-sm cost-btn-add-row">Add More Product</button>
                            <div class="table-responsive">
                            <table class="table extra_cost">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody class="cost_items">
                                <tr class="cost_item">
                                    <td>
                                    <select  class="form-control product"  required>
                                          <option value="" selected="selected" disabled="disabled">-- select one Product--</option>
                                          @foreach($products as $product)
                                          <option value="{{$product->id}}" >{{$product->name}}</option>
                                          @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control quantity" required/>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger">Delete</a></button>
                                    </td>
                                </tr>
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
<script
src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>

<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>


<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $('.select2').select2();

  $(document).ready(function() {
    $(".datepicker").datepicker({ dateFormat: "dd-mm-yy"}).datepicker("setDate", new Date());
  });
</script>


<script>
let $_clone_row = false;
let $_extra_cost_body = false;
let $_list_rows = false;
let $_list_rows_dels = false;
function func_add_new_row(e){
  e.preventDefault(true);
  let $new_row = $_clone_row.clone();
  $_extra_cost_body.append($new_row);
  initiate_rows();
}

function namingInputs(){
  $.each($_list_rows, function(index, item){
      let $_item = $(item);
      let $input_product = $_item.find('select.product');
      let $input_quantity = $_item.find('input.quantity');
      $input_product.attr('name', 'stock['+index+'][product]');
      $input_quantity.attr('name', 'stock['+index+'][quantity]');

  });
}

function initiate_rows(){
  if($_list_rows_dels){
      $_list_rows_dels.off('click');
  }
  $_list_rows = $_extra_cost_body.find('.cost_item');
  namingInputs();
  $_list_rows_dels = $_list_rows.find('button');
  $_list_rows_dels.on('click', function(e){
      e.preventDefault(true);
      if($_list_rows_dels.length > 1){
          let index = $_list_rows_dels.index(this);
          $($_list_rows.get(index)).remove();
      }else{
          $($_list_rows.get(0)).find('input').val('');
      }
      initiate_rows();
  });
}

$(document).ready(()=>{
  let $btn_add_row = $('button.cost-btn-add-row');
  $_extra_cost_body = $("table.extra_cost .cost_items");
  if($btn_add_row.length && $_extra_cost_body.length){
      $btn_add_row.on('click', func_add_new_row);
      $_clone_row = $($_extra_cost_body.find('.cost_item').get(0)).clone();
      $_clone_row.find('input').val('');
      initiate_rows();
  }else{
      alert("Cost module not working properly, please reload again...");
  }




  let $dom_categories = $(".item-categories select");
  let $dom_sub_categories = $(".item-sub-categories select");

  function setSubCategory(resp){
      if(resp.success && resp.data && resp.data.length){
          console.log($dom_sub_categories);
          let data_list = resp.data;
          $dom_sub_categories.append('<option value="" selected>-- SELECT --</option>');
          $.each(data_list, function (index, item) {
              $dom_sub_categories.append('<option value="'+item.id+'">'+item.name+'</option>');
          });
      }else{
          resetSubCategory();
      }
  }

  function resetSubCategory(){
      $dom_sub_categories.append('<option value="" selected>-- NONE --</option>');
  }

  $dom_categories.on('change',function(){
      $dom_sub_categories.empty();
      let cat_val = $(this).val();
      $.ajax({
          url: ''+cat_val,
          success: setSubCategory,
          error: resetSubCategory,
      });
  });
});
</script>

<style type="text/css">
  label.error { color: red }
  .select2-container .select2-selection--single{height: 39px;border: 1px solid #ced4da;}
  .select2-container--default .select2-selection--single .select2-selection__arrow{height:100%;}
</style>

@stop

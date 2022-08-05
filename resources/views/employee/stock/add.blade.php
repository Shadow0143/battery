@extends('employee.layout.app')
@section('title')
    Employee | Stoke New Add
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add Stoke New</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('employee.employee-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Add Stoke New</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@include('employee.layout.alert')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Add Stoke New</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          <form role="form"  action="{{route('employee.stock.add')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Invoice No *</label>
                <input type="text" class="form-control" placeholder="Please Enter Invoice Number" name="invoice" value="{{ old('invoice') }}">
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">date *</label>
                <input type="date" class="form-control" name="date" value="{{ old('date') }}" required>
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
              <a href="{{route('employee.stock.view')}}" class="btn btn-primary">Back</a>
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
@stop

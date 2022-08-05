@extends('employee.layout.app')
@section('title')
    Employee | Order Add
@endsection
@section('body-content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add Order</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('employee.employee-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Add Order</li>
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
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Add Order</h3>
          </div>
        <form role="form"  action="{{route('employee.order.add')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Customer *</label>
                  <select  class="form-control" name="ref_customer" required>
                    <option value="" selected="selected" disabled="disabled">-- select one --</option>
                    @foreach($customers as $customer)
                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Invoice Number *</label>
                  <input type="text" class="form-control" placeholder="Please Enter Invoice Number" name="invoice_number" value="{{ old('invoice_number') }}" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Order Date *</label>
                  <input type="date" class="form-control" name="date" value="{{ old('date') }}" required>
                </div>
              </div>
              <div class="col-sm-10 omg-row-area">
                <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="dynamic_field">
                        <thead>
                            <tr>
                                <th>Product Name *</th>
                                <th>Quantity *</th>
                                <th>Scan Code *</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                          <tbody>
                           <tr id="row1">
                                <td>
                                    <select  class="form-control product" name="product[]" required>
                                      <option value="" selected="selected" disabled="disabled">-- select one Product--</option>
                                      @foreach($products as $product)
                                      <option value="{{$product->id}}" >{{$product->name}}</option>
                                      @endforeach
                                    </select>
                                </td>
                                <td>
                                  <input type="number" name="quantity[]" id="qty_1" class="form-control name_list" onblur="quantity(1)" required />
                                </td>
                                {{-- <td id="scanArea_1"></td> --}}
                                <td>
                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter_1">Scan</button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body" id="scanArea_1">
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" id="saveScanCode" data-dismiss="modal">Save</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </td>
                           </tr>
                         </tbody>
                      </table>
                    </div>
                </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{route('employee.order.view')}}" class="btn btn-primary">Back</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
<script
src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous">
</script>
<script>
function MyEnter(id,rowId) {

  $('#'+rowId+'_sacn_code_'+id).keypress(function(event){
       var keycode = (event.keyCode ? event.keyCode : event.which);
       if(keycode == '13'){
         var myId = (Number(id)+1);
         $('#'+rowId+'_sacn_code_'+myId).focus();
         event.preventDefault(true);
           // alert('You pressed a "enter" key in somewhere');
           //$('#sacn_code_''+(Number(id)+1)+').focus();
       }
   });
 }
$(document).ready(function(){
     var i=1;
     var products = {!! json_encode($products->toArray()) !!};
     $('#add').click(function(){
          i++;
          $('#dynamic_field').append('<tr id="row'+i+'"><td><select  class="form-control product" name="product[]" id="select_area_'+i+'" required><option value="" selected="selected" disabled="disabled">-- select one Company--</option> </select> </td><td><input id="qty_'+i+'" type="number" onblur="quantity('+i+')" name="quantity[]" placeholder="Enter Quantity" class="form-control name_list" /></td><td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter_'+i+'">Scan</button><div class="modal fade" id="exampleModalCenter_'+i+'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body" id="scanArea_'+i+'"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Save</button></div></div></div></div></td><td> <button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">Delete</button></td></tr>');
          let $dom_selectProduct = $("#select_area_"+i);
          $.each(products, function (i, d) {
            $dom_selectProduct.append('<option value="' + d.id + '">' + d.name + '</option>');
          });
     });
     $(document).on('click', '.btn_remove', function(){
          var button_id = $(this).attr("id");
          $('#row'+button_id+'').remove();
     });
});
function quantity(id){
  var qty=$('#qty_'+id).val();
  var html='';
  for (var i = 0; i < qty; i += 1) {
  html=html+'<tr><td><input id="'+id+'_sacn_code_'+i+'" onkeypress="MyEnter('+i+','+id+')" type="text" name="scan_code['+(Number(id)-1)+'][]" placeholder="Please Scan Your Code" class="form-control" required/></td></tr>';
  }
  $('#scanArea_'+id).html(' ');
    $('#scanArea_'+id).append(html);
}

</script>
@stop

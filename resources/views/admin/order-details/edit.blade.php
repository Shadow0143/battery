@extends('admin.layout.app')
@section('title')
    Admin | Order Edit
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Order</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Edit Order</li>
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
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit Order</h3>
          </div>
        <form role="form"  action="{{route('admin.order-details.edit',$item->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Product Name</label>
                <select  class="form-control select2" name="ref_product">
				        	<option value="" selected="selected" disabled="disabled">-- select one --</option>
                  @foreach($products as $product)
                  <option value="{{$product->id}}"  {{ (isset($item)&&$item->ref_product == $product->id)?'selected':''}}>{{$product->name}}</option>
                  @endforeach
					      </select>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Quantity</label>
                <input type="number" class="form-control" placeholder="Please Enter Invoice Number" name="quantity" value="{{ $item->quantity }}" style="background-color: #ffffff;" required readonly>
              </div>
            </div>
            <div class="col-sm-10 omg-row-area">
              <a href="{{route('admin.bar-code.add',$item->id)}}" class="btn btn-primary">Add Bar Code</a>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field">
                      <thead>
                          <tr>
                              <th>Code</th>
                              <th>Action</th>
                          </tr>
                          </thead>

                        <tbody>
                          @php($scan_codes=App\Models\ScanCode::where('ref_order_details',$item->id)->get())

                          @foreach($scan_codes as $scan_code)

                         <tr id="row1">

                              <td>{{ $scan_code->scan_code }}</td>
                              <td>
                                <a class="btn btn-info btn-sm" href="{{route('admin.bar-code.edit',$scan_code->id)}}">
                                    <i class="fas fa-pencil-alt"></i>Edit
                                </a>
                                <a onclick="onClickDelete(event)" class="btn btn-danger btn-sm" href="{{route('admin.bar-code.delete',$scan_code->id)}}">
                                    <i class="fas fa-trash"></i>Delete
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

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>

<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>

<script>
    $('.select2').select2();
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
          $('#dynamic_field').append('<tr id="row'+i+'"><td><select  class="form-control product" name="product[]" id="select_area_'+i+'" required><option value="" selected="selected" disabled="disabled">-- select one Company--</option> </select> </td><td><input id="qty_'+i+'" type="number" onblur="quantity('+i+')" name="quantity[]" placeholder="Enter Quantity" class="form-control name_list" /></td><td id="scanArea_'+i+'"></td><td> <button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">Delete</button></td></tr>');
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
  html=html+'<tr><td><input id="'+id+'_sacn_code_'+i+'" onkeypress="MyEnter('+i+','+id+')" type="text" name="scan_code['+(Number(id)-1)+'][]" placeholder="Please Scan Your Code" class="form-control" /></td></tr>';
  }
  $('#scanArea_'+id).html(' ');
    $('#scanArea_'+id).append(html);
}

</script>

<style type="text/css">
  label.error { color: red }
  .select2-container .select2-selection--single{height: 39px;border: 1px solid #ced4da;}
  .select2-container--default .select2-selection--single .select2-selection__arrow{height:100%;}
</style>

@stop

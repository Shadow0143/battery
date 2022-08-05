@extends('admin.layout.app')
@section('title')
    Admin | Order Add
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add Order</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Add Order</li>
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
            <h3 class="card-title">Add Order</h3>
          </div>
        <form role="form"  action="{{route('admin.order.add')}}" method="post" enctype="multipart/form-data">
            @csrf

         
          <?php /*   <div class="card-body">            
             <div class="form-group">
                <label for="exampleInputEmail1">Contact Number *</label>
            <input type="text" class="form-control" placeholder="Please Enter Contact Number" name="phone_number" value="{{ old('phone_number') }}" required>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Address </label>
                <input type="text" class="form-control" placeholder="Please Enter Address" name="address" value="{{ old('address') }}">
              </div> 
            </div> */ ?>

<style type="text/css">
.line{
  border: 2px solid blue;
  box-sizing: border-box;
}
</style>

<style>
.select2 {
  /* line-height: 28px !important;  */
  line-height: 17px;
}
</style>

            <div class="card-body row">

              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Customer Name *</label>
                <select  class="form-control select2" name="ref_customer" required>
                  <option value="" selected="selected" disabled="disabled">-- select one --</option>
                  @foreach($customers as $customer)
                  @if($customer->type==2)
                  <option value="{{$customer->id}}">{{$customer->name}}</option>
                  @endif
                  @endforeach
                </select>
              </div>

              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Invoice Number *</label>
                <input type="text" class="form-control" placeholder="Please Enter Invoice Number" name="invoice_number" value="{{ old('invoice_number') }}" required>
              </div>

            <?php /*  <div class="form-group">
                <label for="exampleInputEmail1">Bill Number *</label>
                <input type="text" class="form-control" placeholder="Please Enter Bill Number" name="bill_number" value="{{ old('bill_number') }}" required>
              </div> */ ?>
              

              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Order Date *</label>
                <input type="text" class="form-control datepicker" name="date" value="{{ old('date') }}" readonly="readonly" style="cursor: pointer; background-color: #ffffff;" required>
              </div>

              <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Delivery Date *</label>
                <input type="text" class="form-control datepicker" name="delivery_date" value="{{ old('delivery_date') }}" readonly="readonly" style="cursor: pointer; background-color: #ffffff;" required>
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
                              <th>Scan</th>
                              <th>Scan Code</th>
                              <th>Action</th>
                          </tr>
                          </thead>

                        <tbody>
                         <tr id="row1">
                              <td>
                                  <select  class="form-control product select2" name="product[]" required>
                                    <option value="" selected="selected" disabled="disabled">-- select one Product--</option>
                                    @foreach($products as $product)
                                    <option value="{{$product->id}}" >{{$product->name}}</option>
                                    @endforeach
                                  </select>
                              </td>
                              <td>
                                <input type="number" name="quantity[]" id="qty_1" class="form-control name_list" onblur="quantity(1)" required />
                              </td>

                              <!-- add code start -->
                              <td>
                                <select  class="form-control" name="scan_check[]" id="scan_check_1" onchange="scanOption(1)">
                                  <option value="0">YES</option>
                                  <option value="1">NO</option>
                                </select>
                              </td>
                            <!-- add code end -->

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
                <button type="submit" class="btn btn-primary" id="form_submit_btn">Submit</button>
                <a href="{{route('admin.order.view')}}" class="btn btn-primary">Back</a>
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
         // $('#dynamic_field').append('<tr id="row'+i+'"><td><select  class="form-control product select2" name="product[]" id="select_area_'+i+'" required><option value="" selected="selected" disabled="disabled">-- select one Company--</option> </select> </td><td><input id="qty_'+i+'" type="number" onblur="quantity('+i+')" name="quantity[]" class="form-control name_list" required/></td><td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter_'+i+'">Scan</button><div class="modal fade" id="exampleModalCenter_'+i+'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body" id="scanArea_'+i+'"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Save</button></div></div></div></div></td><td> <button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">Delete</button></td></tr>');
          $('#dynamic_field').append('<tr id="row'+i+'"><td><select  class="form-control product select2" name="product[]" id="select_area_'+i+'" required><option value="" selected="selected" disabled="disabled">-- select one Company--</option> </select> </td><td><input id="qty_'+i+'" type="number" onblur="quantity('+i+')" name="quantity[]" class="form-control name_list" required/></td><td><select  class="form-control" name="scan_check[]" id="scan_check_'+i+'" onchange="scanOption('+i+')"><option value="0">YES</option><option value="1">NO</option></select></td><td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter_'+i+'">Scan</button><div class="modal fade" id="exampleModalCenter_'+i+'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body" id="scanArea_'+i+'"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Save</button></div></div></div></div></td><td> <button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">Delete</button></td></tr>');
         
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
  html=html+'<tr><td><input id="'+id+'_sacn_code_'+i+'" onkeypress="MyEnter('+i+','+id+')" type="text" name="scan_code['+(Number(id)-1)+'][]" placeholder="Please Scan Your Code" class="form-control myfunction" required onblur="myFunction(this)" onfocusout="checkName(this)"/></td></tr>';
  }
    $('#scanArea_'+id).html(' ');
    $('#scanArea_'+id).append(html);

    // code add start
     scanOption(id); 
    // code add end

}

// code add start
function scanOption(id){ 
   var op_scan =$('#scan_check_'+id).val();
   var qty=$('#qty_'+id).val();
   if(op_scan==1){
      for (var i = 0; i < qty; i += 1) {  
        $('#'+id+'_sacn_code_'+i).val('blank');
        $('#'+id+'_sacn_code_'+i).attr('readonly', 'readonly');
      }
   }
   if(op_scan==0){
      for (var i = 0; i < qty; i += 1) {  
        $('#'+id+'_sacn_code_'+i).val('');
        $('#'+id+'_sacn_code_'+i).removeAttr('readonly');
      }
   }

}
// code add end

  $(document).ready(function() {
  $("#1_sacn_code_0").keypress(function(e) {
    var length = this.value.length;
    if (length >= 11) {
      e.preventDefault();
      alert("not allow more than 11 character");
    }
  });
});



    function checkName(thisvalues) {
            var currentval = $('#' + thisvalues.id).val();
        var idsss = thisvalues.id;
           var splites = idsss.split("_");
           var nextid = +splites[3]+ +1; 
           var nextfullid = splites[0] +'_'+splites[1]+'_'+splites[2]+'_'+nextid;
        //alert(this.value.length);
              if(currentval!=''){

                  // code add start
                if(currentval != 'blank'){
                  // code add end

                  $('.myfunction').each(function () {
                       console.log(this.value + ',' + this.id);
                      if (currentval == this.value && thisvalues.id != this.id) {
                    alert('The bar code ' + this.value+ '  is already exists');
                    $('#'+idsss).val('');
                       }else{
                          // $(this).next('.inputs').focus();
                          $('#' + nextfullid).focus();
                       }
                 });

                }

              }            
        }






    function myFunction(value) { 
      var scancodes = '<?php echo $scancodes; ?>';
      var scancodesarray = scancodes.split(",");
      var currentval = $('#' + value.id).val();
      var idsss = value.id;
    
        if(currentval!=''){
          // code add start
          if(currentval != 'blank'){
          // code add end

            if(jQuery.inArray(currentval, scancodesarray) !== -1) {
                alert("The bar code " + currentval + " is already exists");
                $('#'+idsss).val('');
            } else {
            $(this).next('.inputs').focus();
            }

          }

        }

    }

 
        
                          

        

    $('#form_submit_btn').click(function(){
    $('input').each(function() {
        if(!$(this).val()){
            alert('Please give value in all mandatory fields including the bar code numbers before submit'); 
           return false;
        }
    });
  });

</script>

<style type="text/css">
  label.error { color: red }
  .select2-container .select2-selection--single{height: 39px;border: 1px solid #ced4da;}
  .select2-container--default .select2-selection--single .select2-selection__arrow{height:100%;}
</style>

@stop

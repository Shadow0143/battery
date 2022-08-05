@extends('admin.layout.app')
@section('title')
    Admin | User Edit
@endsection
@section('body-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Edit User</li>
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
            <h3 class="card-title">Edit User</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          <form role="form"  action="{{route('admin.user.edit',$item->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Name *</label>
                <input type="text" class="form-control" placeholder="Please Enter User Name" name="name" value="{{$item->name}}" required>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Change Password</label>
                <input type="password" class="form-control" placeholder="Please Enter User Login Password" autocomplete="off" name="password">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">User Role *</label>
                <select class="form-control" name="user_type" required>
                    <!-- <option value="" selected="selected" disabled="disabled">-- select one --</option> -->
            <option value="1"{{ (isset($item)&&$item->user_type == 1)?'selected':''}}>Administrator</option>
            <option value="2"{{ (isset($item)&&$item->user_type == 2)?'selected':''}}>Employee</option>
                </select>
              </div>

              <div class="form-group" style="display:none;">
                <label for="exampleInputEmail1">User Role *</label>
                <select class="form-control" name="type" required>
                  <option value="admin">Admin</option>
                  <!-- <option value="" selected="selected" disabled="disabled">-- select one --</option> -->
                  <!-- <option value="employee"{{ (isset($item)&&$item->type == 'employee')?'selected':''}}>Employee</option> -->
                  <!-- <option value="sales" {{ (isset($item)&&$item->type == 'sales')?'selected':''}}>Sales Man</option> -->
                </select>
              </div>

            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="{{route('admin.user.view')}}" class="btn btn-primary">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@stop

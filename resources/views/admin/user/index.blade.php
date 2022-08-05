@extends('admin.layout.app')
@section('title')
    Admin | User
@endsection
@section('body-content')
<!-- Content Header (Page header) -->
<?php $user = Auth::user(); ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.admin-dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">User</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@include('admin.layout.alert')
<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <div class="card-tools">
        <a href="{{route('admin.user.add')}}" class="btn btn-primary">Add User</a>
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped projects" id="pagi">
          <thead>
              <tr>
                  <th style="width: 20%">
                      Sl No.
                  </th>
                  <th style="width: 20%">
                      Name
                  </th>
                  <th style="width: 20%">
                      Email
                  </th>
                  <th style="width: 20%">
                      User Type
                  </th>
                  <th style="width: 20%">
                    Action
                  </th>
              </tr>
          </thead>
          <tbody>
            @if($items->isNotEmpty())
            @php($count = 0)
            @foreach($items as $item)
            @php($count++)
              <tr>
                  <td>
                      {{$count}}
                  </td>
                  <td>
                      {{$item->name}}
                  </td>
                  <td>
                    {{$item->email}}
                  </td>
                  <td>
                    <?php if($item->user_type==1){echo 'Administrator';}else{echo 'Employee';} ?>
                  </td>
                  <td class="project-actions text-right">
                    <?php  if($item->user_type!=1 && $user->user_type==1){ ?> 
                      <a class="btn btn-info btn-sm" href="{{route('admin.user.edit',$item->id)}}">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                      </a>
                    
                      <a onclick="onClickDelete(event)" class="btn btn-danger btn-sm" href="{{route('admin.user.delete',$item->id)}}">
                          <i class="fas fa-trash">
                          </i>
                          Delete
                      </a>
                      <?php } ?>
                  </td>
              </tr>
              @endforeach
              @else
            <tr>
                <td colspan="8">
                    <div class="alert alert-danger" role="alert">
                        No User Exist on system, please add new
                    </div>
                </td>
            </tr>
            @endif
          </tbody>
      </table>
    </div>
  </div>
 <?php /* {{ $items->links() }} */ ?>
</section>
<!-- /.content -->
@stop

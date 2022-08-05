<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('admin.admin-dashboard')}}" class="brand-link">
    <img src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Admin Panel</span>
  </a>

<?php $user = Auth::user();
  //echo '<pre>'; print_r($user->user_type);die; ?>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->


    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
       <li class="nav-item">
         <a href="{{route('admin.admin-dashboard')}}" class="nav-link">
           <i class="nav-icon fas fa-tachometer-alt"></i>
           <p>
             Dashboard
           </p>
         </a>
       </li>
        <!-- <li class="nav-header">PRODUCT</li> -->
        <!-- <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-list-alt"></i>
            <p>
              Category
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('admin.category.view')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.category.add')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-list-alt"></i>
            <p>
            Brand
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('admin.brand.view')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.brand.add')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add</p>
              </a>
            </li>
          </ul>
        </li> -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fab fa-product-hunt"></i>
            <p>
            Create Item
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('admin.product.view')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>List</p>
              </a>
            </li>
         <?php // if($user->user_type==1){ ?>
            <li class="nav-item">
              <a href="{{route('admin.product.add')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add</p>
              </a>
            </li>
        <?php // } ?>

          </ul>
        </li>
        <!-- <li class="nav-header">STOCK</li> -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
             <i class="nav-icon fab fa-product-hunt"></i>
            <p>Purchase
                <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('admin.stock.view')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>List</p>
              </a>
            </li>

      <?php // if($user->user_type==1){ ?>
            <li class="nav-item">
              <a href="{{route('admin.stock.add')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add</p>
              </a>
            </li>
      <?php // } ?>

          </ul>
        </li>
        <!-- <li class="nav-item">
          <a href="{{route('admin.all-stock.view')}}" class="nav-link">
             <i class="nav-icon fab fa-product-hunt"></i>
            <p>Total Stock</p>
          </a>
        </li> -->

        <li class="nav-item">
          <a href="{{route('admin.all-stock.allview')}}" class="nav-link">
             <i class="nav-icon fab fa-product-hunt"></i>
            <p>Stock In / Out Details</p>
          </a>
        </li>
        
        <!-- <li class="nav-header">Customer</li> -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-user"></i>
            <p>
            Customer Or Dealer
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('admin.customer.view')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>List</p>
              </a>
            </li>

          <?php // if($user->user_type==1){ ?>
            <li class="nav-item">
              <a href="{{route('admin.customer.add')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add</p>
              </a>
            </li>
        <?php // } ?>

        </ul>
      </li>
     <!--  <li class="nav-header">ORDER</li> -->
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-shopping-cart "></i>
          <p>
          Order
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('admin.order.view')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>List</p>
            </a>
          </li>
      <?php if($user->user_type==1){ ?>
          <li class="nav-item">
            <a href="{{route('admin.order.add')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Add</p>
            </a>
          </li>
          <?php  } ?>

      </ul>
    </li>

    <!-- <li class="nav-header">USER</li> -->
    <?php if($user->type=='admin'){ ?>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fa fa-user "></i>
        <p>
        User
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('admin.user.view')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>List</p>
          </a>
        </li>
        <?php // if($user->user_type==1){ ?>
        <li class="nav-item">
          <a href="{{route('admin.user.add')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Add</p>
          </a>
        </li>
        <?php // } ?>
        
    </ul>
  </li>

<?php } ?>

</ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('employee.employee-dashboard')}}" class="brand-link">
    <img src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Employee Panel</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
       <li class="nav-item">
         <a href="{{route('employee.employee-dashboard')}}" class="nav-link">
           <i class="nav-icon fas fa-tachometer-alt"></i>
           <p>
             Dashboard
           </p>
         </a>
       </li>
       <li class="nav-header">PRODUCT</li>
       <li class="nav-item has-treeview">
         <a href="#" class="nav-link">
           <i class="nav-icon fa fa-list-alt"></i>
           <p>
             Category
             <i class="fas fa-angle-left right"></i>
           </p>
         </a>
         <ul class="nav nav-treeview">
           <li class="nav-item">
             <a href="{{route('employee.category.view')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>List</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="{{route('employee.category.add')}}" class="nav-link">
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
             <a href="{{route('employee.brand.view')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>List</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="{{route('employee.brand.add')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>Add</p>
             </a>
           </li>
         </ul>
       </li>
       <li class="nav-item has-treeview">
         <a href="#" class="nav-link">
           <i class="nav-icon fab fa-product-hunt"></i>
           <p>
           Product
             <i class="fas fa-angle-left right"></i>
           </p>
         </a>
         <ul class="nav nav-treeview">
           <li class="nav-item">
             <a href="{{route('employee.product.view')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>List</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="{{route('employee.product.add')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>Add</p>
             </a>
           </li>
         </ul>
       </li>
       <li class="nav-header">USER</li>
       <li class="nav-item has-treeview">
         <a href="#" class="nav-link">
           <i class="nav-icon fa fa-user"></i>
           <p>
           Customer
             <i class="fas fa-angle-left right"></i>
           </p>
         </a>
         <ul class="nav nav-treeview">
           <li class="nav-item">
             <a href="{{route('employee.customer.view')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>List</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="{{route('employee.customer.add')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>Add</p>
             </a>
           </li>
       </ul>
     </li>
     <li class="nav-header">STOCK</li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-inventory"></i>
            <p>
                New Stock
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('employee.stock.view')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('employee.stock.add')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{route('employee.all-stock.view')}}" class="nav-link">
            <i class="nav-icon fas fa-inventory"></i>
            <p>
                Existing Stock
            </p>
          </a>
        </li>

     <li class="nav-header">ORDER</li>
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
           <a href="{{route('employee.order.view')}}" class="nav-link">
             <i class="far fa-circle nav-icon"></i>
             <p>List</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="{{route('employee.order.add')}}" class="nav-link">
             <i class="far fa-circle nav-icon"></i>
             <p>Add</p>
           </a>
         </li>
     </ul>
   </li>
     </ul>
   </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

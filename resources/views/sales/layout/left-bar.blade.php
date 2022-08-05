<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('sales.sales-dashboard')}}" class="brand-link">
    <img src="{{ \App\Http\Controllers\ExtraController::assetURL('Design-admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Sales Panel</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->


    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <li class="nav-item">
           <a href="{{route('sales.sales-dashboard')}}" class="nav-link">
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
               <a href="{{route('sales.category.view')}}" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>List</p>
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
               <a href="{{route('sales.brand.view')}}" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>List</p>
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
               <a href="{{route('sales.product.view')}}" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>List</p>
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
               <a href="{{route('sales.customer.view')}}" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>List</p>
               </a>
             </li>

         </ul>
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
             <a href="{{route('sales.order.view')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>List</p>
             </a>
           </li>

       </ul>
     </li>
     <li class="nav-item">
        <a href="{{route('sales.all-stock.view')}}" class="nav-link">
          <i class="nav-icon fas fa-inventory"></i>
          <p>
            Stock
          </p>
        </a>
      </li>
       </ul>
     </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

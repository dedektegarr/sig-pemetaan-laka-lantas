 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="{{ route('dashboard.index') }}" class="brand-link">
         <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
         <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="/img/avatar.png" class="img-circle elevation-2" alt="User Image">
             </div>
             <div class="info">
                 <a href="#" class="d-block">Alexander Pierce</a>
             </div>
         </div>

         <!-- SidebarSearch Form -->
         <div class="form-inline">
             <div class="input-group" data-widget="sidebar-search">
                 <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                     aria-label="Search">
                 <div class="input-group-append">
                     <button class="btn btn-sidebar">
                         <i class="fas fa-search fa-fw"></i>
                     </button>
                 </div>
             </div>
         </div>
         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item">
                     <a href="{{ route('dashboard.index') }}"
                         class="nav-link {{ Route::is('dashboard.index') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-home"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('peta.index') }}" class="nav-link {{ Route::is('peta.index') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-map"></i>
                         <p>
                             Peta
                         </p>
                     </a>
                 </li>
                 <li class="nav-item {{ Request::is('administrator/data/*') ? 'menu-is-opening menu-open' : '' }}">
                     <a href="#" class="nav-link {{ Request::is('administrator/data/*') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-database"></i>
                         <p>
                             Data
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('kecelakaan.index') }}"
                                 class="nav-link {{ Request::is('administrator/data/kecelakaan/*') || Route::is('kecelakaan.index') ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Kecelakaan</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('lokasi.index') }}"
                                 class="nav-link {{ Request::is('administrator/data/lokasi/*') || Route::is('lokasi.index') ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Lokasi Jalan</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 {{-- <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-print"></i>
                         <p>
                             Cetak Laporan
                         </p>
                     </a>
                 </li> --}}
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>

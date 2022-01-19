
<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
      <div class="nano">
        <div class="nano-content">
          <div class="logo">
            <a href="index.html">
              <!-- <img src="assets/images/logo.png" alt="" /> -->
              <span>SUMMARY</span>
            </a>
          </div>
          <ul>
             @hasanyrole($role)
            {{-- <li class="label">Aplikasi</li>
            <li>
              <a class="sidebar-sub-toggle">
                <i class="ti-home"></i> Dashboard
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                <li>
                  <a href="index.html">Pelaporan</a>
                </li>
                <li>
                  <a href="index1.html">Presensi</a>
                </li>
              </ul>
            </li> --}}
            

            
            <li class="label">Pelaporan</li>
            <li>
              <a href="{{ route('myreport_create') }}">
                <i class="ti-pencil-alt"></i> Buat 5w1H
              </a>
            </li>

             <li>
              <a class="sidebar-sub-toggle">
                <i class="ti-write"></i> 5W1H-Ku
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                <li>
                  <a href="{{ route('myreport') }}">Penyusun</a>
                </li>
                <li>
                  <a href="{{ route('pengikut') }}">Pengikut</a>
                </li>
              </ul>

            </li>
              
          
            @endhasanyrole

            @can('create indicator')
            <li class="label">Kategori IKU</li>
            <li>
              <a href="{{ route('indicator_create') }}"> <i class="ti-book"></i> Kategori IKU </a>
            </li>
            @endcan
            
            @can('show user')
            <li class="label">Menu Pengguna</li>
            <li>
              
              <a class="sidebar-sub-toggle">
                <i class="ti-user"></i> Lihat User
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                <li>
                  <a href="chart-flot.html">Lihat Pengguna</a>
                </li>
                <li>
                  <a href="{{ route('report_index') }}">5W1H Seluruh Pengguna</a>
                </li>
              </ul>
            </li>
            @endcan
            
            @can('assign permission')
              <li class="label">Kebijakan</li>
            <li>
              <a class="sidebar-sub-toggle">
                <i class="ti-settings"></i> Role & Permission
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                <li>
                  <a href="{{ route('role_index') }}">Role</a>
                </li>
                <li>
                  <a href="{{ route('permission_index') }}">Permission</a>
                </li>
                <li>
                  <a href="{{ route('assign_create') }}">Pemberian Akses Role</a>
                </li>
                <li>
                  <a href="{{ route('user_create') }}">Pemberian Akses User</a>
                </li>
              </ul>
            </li>
            @endcan
            
            {{-- <li>
              <a href="app-widget-card.html">
                <i class="ti-layout-grid2-alt"></i> Widget</a
              >
            </li>
            <li class="label">Features</li>
            <li>
              <a class="sidebar-sub-toggle">
                <i class="ti-layout"></i> UI Elements
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                <li>
                  <a href="ui-typography.html">Typography</a>
                </li>
                <li>
                  <a href="ui-alerts.html">Alerts</a>
                </li>

                <li>
                  <a href="ui-button.html">Button</a>
                </li>
                <li>
                  <a href="ui-dropdown.html">Dropdown</a>
                </li>

                <li>
                  <a href="ui-list-group.html">List Group</a>
                </li>

                <li>
                  <a href="ui-progressbar.html">Progressbar</a>
                </li>
                <li>
                  <a href="ui-tab.html">Tab</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="sidebar-sub-toggle">
                <i class="ti-panel"></i> Components
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                <li>
                  <a href="uc-calendar.html">Calendar</a>
                </li>
                <li>
                  <a href="uc-carousel.html">Carousel</a>
                </li>
                <li>
                  <a href="uc-weather.html">Weather</a>
                </li>
                <li>
                  <a href="uc-datamap.html">Datamap</a>
                </li>
                <li>
                  <a href="uc-todo-list.html">To do</a>
                </li>
                <li>
                  <a href="uc-scrollable.html">Scrollable</a>
                </li>
                <li>
                  <a href="uc-sweetalert.html">Sweet Alert</a>
                </li>
                <li>
                  <a href="uc-toastr.html">Toastr</a>
                </li>
                <li>
                  <a href="uc-range-slider-basic.html">Basic Range Slider</a>
                </li>
                <li>
                  <a href="uc-range-slider-advance.html"
                    >Advance Range Slider</a
                  >
                </li>
                <li>
                  <a href="uc-nestable.html">Nestable</a>
                </li>

                <li>
                  <a href="uc-rating-bar-rating.html">Bar Rating</a>
                </li>
                <li>
                  <a href="uc-rating-jRate.html">jRate</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="sidebar-sub-toggle">
                <i class="ti-layout-grid4-alt"></i> Table
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                <li>
                  <a href="table-basic.html">Basic</a>
                </li>

                <li>
                  <a href="table-export.html">Datatable Export</a>
                </li>
                <li>
                  <a href="table-row-select.html">Datatable Row Select</a>
                </li>
                <li>
                  <a href="table-jsgrid.html">Editable </a>
                </li>
              </ul>
            </li>
            <li>
              <a class="sidebar-sub-toggle">
                <i class="ti-heart"></i> Icons
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                <li>
                  <a href="font-themify.html">Themify</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="sidebar-sub-toggle">
                <i class="ti-map"></i> Maps
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                <li>
                  <a href="gmaps.html">Basic</a>
                </li>
                <li>
                  <a href="vector-map.html">Vector Map</a>
                </li>
              </ul>
            </li>
            <li class="label">Form</li>
            <li>
              <a href="form-basic.html">
                <i class="ti-view-list-alt"></i> Basic Form
              </a>
            </li>
            <li class="label">Extra</li>
            <li>
              <a class="sidebar-sub-toggle">
                <i class="ti-files"></i> Invoice
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                <li>
                  <a href="invoice.html">Basic</a>
                </li>
                <li>
                  <a href="invoice-editable.html">Editable</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="sidebar-sub-toggle">
                <i class="ti-target"></i> Pages
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                <li>
                  <a href="page-login.html">Login</a>
                </li>
                <li>
                  <a href="page-register.html">Register</a>
                </li>
                <li>
                  <a href="page-reset-password.html">Forgot password</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="../documentation/index.html">
                <i class="ti-file"></i> Documentation</a
              >
            </li>
            <li>
              <a> <i class="ti-close"></i> Logout</a>
            </li> --}}
            @hasanyrole($role)
              <li>
              <a class="sidebar-sub-toggle">
                <i class="ti-write"></i> Akun
                <span class="sidebar-collapse-icon ti-angle-down"></span>
              </a>
              <ul>
                {{-- <li>
                  <a href="{{ route('pengikut') }}">Profil</a>
                </li> --}}
                <li>
                  <a href="{{ route('password_edit') }}">Ubah Password</a>
                </li>
              </ul>

            </li>
            @endhasanyrole
          </ul>
        </div>
      </div>
    </div>

 
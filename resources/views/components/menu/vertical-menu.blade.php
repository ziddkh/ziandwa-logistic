{{--

/**
*
* Created a new component <x-menu.vertical-menu/>.
*
*/

--}}


        <div class="sidebar-wrapper sidebar-theme">
            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="{{getRouterValue();}}/">
                                {{-- TODO: Change the div tag to img tag --}}
                                <div style="width: 40px; height: 40px; background-color: #4361ee; border-radius: 9999px;" class="navbar-logo logo-light"></div>
                                {{-- <div style="width: 40px; height: 40px; background-color: #778ce8; border-radius: 9999px;" class="navbar-logo logo-dark"></div> --}}
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="{{getRouterValue();}}/" class="nav-link"> TSL </a>
                        </div>
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                        </div>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">

                    <li class="menu {{ Request::routeIs('barebone') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Home</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>APPLICATIONS</span></div>
                    </li>

                    @if (auth()->user()->can('view-shipment') || auth()->user()->can('create-shipment') || auth()->user()->can('edit-shipment') || auth()->user()->can('delete-shipment'))
                        <li class="menu {{ Request::is('dashboard/pengiriman/*') ? "active" : "" }}">
                            <a href="#pengiriman" data-bs-toggle="collapse" aria-expanded="{{ Request::is('dashboard/pengiriman/*') ? "true" : "false" }}" class="dropdown-toggle">
                                <div class="">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                    <span>Pengiriman</span>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </div>
                            </a>
                            <ul class="collapse submenu list-unstyled {{ Request::is('dashboard/pengiriman/*') ? "show" : "" }}" id="pengiriman" data-bs-parent="#accordionExample">
                                @if (auth()->user()->can('create-shipment'))
                                    <li class="{{ Request::routeIs('shipments-2.create') ? 'active' : '' }}">
                                        <a href="{{ route('shipments-2.create') }}/"> Tambah </a>
                                    </li>
                                @endif
                                @if (auth()->user()->can('view-shipment'))
                                    <li class="{{ Request::routeIs('shipments-2.index') ? 'active' : '' }}">
                                        <a href="{{ route('shipments-2.index') }}/"> List </a>
                                    </li>
                                    <li class="{{ Request::routeIs('shipments-2.archive') ? 'active' : '' }}">
                                        <a href="{{ route('shipments-2.archive') }}/"> Arsip </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->can('view-payment'))
                    <li class="menu {{ Request::is('dashboard/pembayaran/*') ? 'active' : '' }}">
                        <a href="{{ route('payment.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                <span>Pembayaran</span>
                            </div>
                        </a>
                    </li>
                    @endif

                    @if (auth()->user()->can('report-shipment-client') || auth()->user()->can('report-shipment'))
                        <li class="menu {{ Request::is('dashboard/laporan/*') ? "active" : "" }}">

                            <a href="#laporan" data-bs-toggle="collapse" aria-expanded="{{ Request::is('dashboard/laporan/*') ? "true" : "false" }}" class="dropdown-toggle">
                                <div class="">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                    <span>Laporan</span>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </div>
                            </a>
                            <ul class="collapse submenu list-unstyled {{ Request::is('dashboard/laporan/*') ? "show" : "" }}" id="laporan" data-bs-parent="#accordionExample">
                                @if (auth()->user()->can('report-shipment'))
                                <li class="{{ Request::routeIs('shipment-report.index') ? 'active' : '' }}">
                                    <a href="{{ route('shipment-report.index') }}/"> Pengiriman </a>
                                </li>
                                @endif
                                @if (auth()->user()->can('report-shipment-client'))
                                <li class="{{ Request::routeIs('shipment-client-report') ? 'active' : '' }}">
                                    <a href="{{ route('shipment-client-report') }}/"> Manifest Barang Perwakilan </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->can('view-user'))
                    <li class="menu {{ Request::is('dashboard/users/*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <span>Users</span>
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>

            </nav>

        </div>

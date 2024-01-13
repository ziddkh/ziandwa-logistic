{{--

/**
*
* Created a new component <x-menu.horizontal-menu/>.
*
*/

--}}


        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="{{getRouterValue();}}/dashboard/analytics">
                                <img src="{{Vite::asset('resources/images/logo.svg')}}" class="navbar-logo" alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="{{getRouterValue();}}/dashboard/analytics" class="nav-link"> CORK </a>
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
                    <li class="menu {{ Request::is('*/dashboard/*') ? "active" : "" }}">
                        <a href="#dashboard" data-bs-toggle="dropdown" aria-expanded="{{ Request::is('*/dashboard/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('analytics') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/dashboard/analytics"> Analytics </a>
                            </li>
                            <li class="{{ Request::routeIs('sales') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/dashboard/sales"> Sales </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>APPLICATIONS</span></div>
                    </li>

                    <li class="menu {{ Request::is('*/app/*') ? "active" : "" }}">
                        <a href="#apps" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                <span>Apps</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="dropdown-menu submenu list-unstyled" id="apps" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('calendar') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/calendar"> Calendar </a>
                            </li>
                            <li class="{{ Request::routeIs('chat') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/chat"> Chat </a>
                            </li>
                            <li class="{{ Request::routeIs('mailbox') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/mailbox"> Mailbox </a>
                            </li>
                            <li class="{{ Request::routeIs('todolist') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/todo-list"> Todo List </a>
                            </li>
                            <li class="{{ Request::routeIs('notes') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/notes"> Notes </a>
                            </li>
                            <li class="{{ Request::routeIs('scrumboard') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/scrumboard"> Scrumboard </a>
                            </li>
                            <li class="{{ Request::routeIs('contacts') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/contacts"> Contacts </a>
                            </li>
                            <li class="sub-submenu dropend {{ Request::is('*/app/invoice/*') ? "active" : "" }}">
                                <a href="#invoice" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle collapsed">Invoice <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="dropdown-menu list-unstyled sub-submenu" id="invoice">
                                    <li class="{{ Request::routeIs('invoice-list') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/invoice/list"> List </a>
                                    </li>
                                    <li class="{{ Request::routeIs('invoice-preview') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/invoice/preview"> Preview </a>
                                    </li>
                                    <li class="{{ Request::routeIs('invoice-add') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/invoice/add"> Add </a>
                                    </li>
                                    <li class="{{ Request::routeIs('invoice-edit') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/invoice/edit"> Edit </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-submenu dropend {{ Request::is('*/app/ecommerce/*') ? "active" : "" }}">
                                <a href="#ecommerce" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle collapsed">Ecommerce <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="dropdown-menu list-unstyled sub-submenu" id="ecommerce" data-bs-parent="#apps">
                                    <li class="{{ Request::routeIs('ecommerce-shop') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/ecommerce/shop"> Shop </a>
                                    </li>
                                    <li class="{{ Request::routeIs('ecommerce-detail') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/ecommerce/detail"> Product </a>
                                    </li>
                                    <li class="{{ Request::routeIs('ecommerce-list') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/ecommerce/list"> List </a>
                                    </li>
                                    <li class="{{ Request::routeIs('ecommerce-add') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/ecommerce/add"> Create </a>
                                    </li>
                                    <li class="{{ Request::routeIs('ecommerce-edit') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/ecommerce/edit"> Edit </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-submenu dropend {{ Request::is('*/app/blog/*') ? "active" : "" }}">
                                <a href="#blog" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle collapsed">Blog <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="dropdown-menu list-unstyled sub-submenu" id="blog" data-bs-parent="#apps">
                                    <li class="{{ Request::routeIs('blog-grid') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/blog/grid"> Grid </a>
                                    </li>
                                    <li class="{{ Request::routeIs('blog-list') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/blog/list"> List </a>
                                    </li>
                                    <li class="{{ Request::routeIs('blog-post') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/blog/post"> Post </a>
                                    </li>
                                    <li class="{{ Request::routeIs('blog-create') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/blog/create"> Create </a>
                                    </li>
                                    <li class="{{ Request::routeIs('blog-edit') ? 'active' : '' }}">
                                        <a href="{{getRouterValue();}}/app/blog/edit"> Edit </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

            </nav>

        </div>

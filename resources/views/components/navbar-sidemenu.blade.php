<div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">

        <div class="nk-menu-trigger me-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                    class="icon ni ni-arrow-left  text-light"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex text-light">
                <em class="icon ni ni-help"></em>
            </a>
        </div>

        <div class="nk-sidebar-brand text-light">
            <span id="title-sidemenu">Vechicle Impounding Records</span>
        </div>

    </div>

    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <center>
                    <img src="/images/logo.png" id="logo-sidemenu"
                        style="height: 130px;  filter: drop-shadow(0 0 10px #000);" alt="">
                </center>
                <hr class="mt-4 mb-4">
                <ul class="nk-menu">
                    <li class="nk-menu-heading pt-0">
                        <h6 class="overline-title text-primary-alt">menu</h6>
                    </li>
                    @if (Auth::user()->account_type == 'Administrator')
                        <li class="nk-menu-item">
                            <a href="/dashboard" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                                <span class="nk-menu-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/notification" class="nk-menu-link">
                                @php
                                    $citations_count = App\Models\TrafficCitation::where(
                                        'date',
                                        date('Y-m-d'),
                                    )->count();
                                @endphp
                                <span class="nk-menu-icon"><em class="icon ni ni-bell"></em></span>
                                <span class="nk-menu-text">Notification
                                    @if ($citations_count != 0)
                                        <span class="badge bg-danger">{{ $citations_count }}</span>
                                    @endif
                                </span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/violators" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                <span class="nk-menu-text">Violator Profile</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/citations" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-ticket"></em></span>
                                <span class="nk-menu-text">Traffic Citations</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/violations" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-alert"></em></span>
                                <span class="nk-menu-text">Violetion Entries</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/impoundings" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-truck"></em></span>
                                <span class="nk-menu-text">Vehicle Impoundings</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/generate-report" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-download"></em></span>
                                <span class="nk-menu-text">Generate Reports</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/revenue-report" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-bar-chart"></em></span>
                                <span class="nk-menu-text">Revenue Reports</span>
                            </a>
                        </li>
                        <li class="nk-menu-heading pt-4">
                            <h6 class="overline-title text-primary-alt">Manage Accounts</h6>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/accounts" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-account-setting"></em></span>
                                <span class="nk-menu-text">Account Management</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#registration"
                                class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-user-add"></em></span>
                                <span class="nk-menu-text">Register Account</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->account_type == 'Officer')
                        <li class="nk-menu-item">
                            <a href="/dashboard" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                                <span class="nk-menu-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/citations" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-ticket"></em></span>
                                <span class="nk-menu-text">Traffic Citations</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/violations" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-alert"></em></span>
                                <span class="nk-menu-text">Violetion Entries</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/violators" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                <span class="nk-menu-text">Violator Records</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/impoundings" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-truck"></em></span>
                                <span class="nk-menu-text">Vehicle Impoundings</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

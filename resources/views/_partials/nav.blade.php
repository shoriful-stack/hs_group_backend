    <header class="top-header">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-icon d-xl-none">
                <i class="bi bi-list"></i>
            </div>
            <div class="top-navbar-right ms-auto">
                <ul class="navbar-nav align-items-center">
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <div class="user-setting d-flex align-items-center gap-1">
                                <i class="bi bi-building"></i>
                                <div class="user-name d-none d-sm-block fw-semibold">
                                    {{ session('branch_name', auth()->user()->branch->name ?? 'Select Branch') }}                        
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-3 shadow-lg rounded-3" style="min-width: 280px;">
                            <li>
                                <label for="branch_id" class="form-label fw-semibold text-secondary mb-2">
                                    <i class="bi bi-diagram-3"></i> Choose Concern
                                </label>
                                <select name="branch_id" id="branch_id"
                                    class="form-select search_branch"
                                    data-placeholder="Search branch..." required></select>
                            </li>
                        </ul>
                    </li> -->


                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                            data-bs-toggle="dropdown">
                            <div class="user-setting d-flex align-items-center gap-1">
                                <img src="/assets/images/HSETL-logo-white fav.png" class="user-img" alt="">
                                <div class="user-name d-none d-sm-block">{{ auth()->user()->name }}</div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="/assets/images/HSETL-logo-white fav.png" alt="" class="rounded-circle"
                                            width="60" height="60">
                                        <div class="ms-3">
                                            <h6 class="mb-0 dropdown-user-name">{{ auth()->user()->name }}</h6>
                                            <small class="mb-0 dropdown-user-designation text-secondary">Role: {{ auth()->user()->role->name }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>



                            <li>
                                <a class="dropdown-item" href="{{ route('password.edit') }}">
                                    <div class="d-flex align-items-center">
                                        <div class="setting-icon"><i class="bi bi-shield-lock-fill"></i></div>
                                        <div class="setting-text ms-3"><span>Change Password</span></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <div class="setting-icon"><i class="bi bi-lock-fill"></i></div>
                                            <div class="setting-text ms-3"><span>Logout</span></div>
                                        </div>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    
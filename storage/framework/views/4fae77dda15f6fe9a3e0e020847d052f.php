<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="<?php echo e(url('/' . ($page = 'index')), false); ?>"><img src="<?php echo e(URL::asset('assets/img/brand/logo.png'), false); ?>"
                        class="logo-1" alt="logo"></a>
                <a href="<?php echo e(url('/' . ($page = 'index')), false); ?>"><img src="<?php echo e(URL::asset('assets/img/brand/logo-white.png'), false); ?>"
                        class="dark-logo-1" alt="logo"></a>
                <a href="<?php echo e(url('/' . ($page = 'index')), false); ?>"><img src="<?php echo e(URL::asset('assets/img/brand/favicon.png'), false); ?>"
                        class="logo-2" alt="logo"></a>
                <a href="<?php echo e(url('/' . ($page = 'index')), false); ?>"><img src="<?php echo e(URL::asset('assets/img/brand/favicon.png'), false); ?>"
                        class="dark-logo-2" alt="logo"></a>
            </div>
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>

        </div>
        <div class="main-header-right">
            <ul class="nav">
                <li class="">







                </li>
            </ul>
            <div class="nav nav-item  navbar-nav-right ml-auto">
                <div class="nav-link" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
                                <button type="reset" class="btn btn-default">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="submit" class="btn btn-default nav-link resp-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-search">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>


                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-maximize">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                            </path>
                        </svg></a>
                </div>




                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href="">
                        <img alt="<?php echo e(Auth::user()->name, false); ?>"
                             src="<?php echo e(Auth::user()->profile_picture ? url('storge/' . Auth::user()->profile_picture) : URL::asset('assets/img/faces/6.jpg'), false); ?>"
                             style="width: 32px; height: 32px; object-fit: cover; border-radius: 50%;">
                    </a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user">
                                    <img alt="<?php echo e(Auth::user()->name, false); ?>"
                                         src="<?php echo e(Auth::user()->profile_picture ? url('storge/' . Auth::user()->profile_picture) : URL::asset('assets/img/faces/6.jpg'), false); ?>"
                                         class=""
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                </div>
                                <div class="mr-3 my-auto">
                                    <h6><?php echo e(Auth::user()->name, false); ?></h6><span><?php echo e(Auth::user()->email, false); ?></span>
                                </div>
                            </div>
                        </div>

                        <a class="dropdown-item" href="<?php echo e(route('profile.edit'), false); ?>">
                            <i class="bx bx-user"></i> My Profile
                        </a>
                        <a class="dropdown-item" href="<?php echo e(route('logout'), false); ?>"><i class="bx bx-log-out"></i> Sign
                            Out</a>
                    </div>
                </div>



                <div class="dropdown main-header-message right-toggle">
                    <a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">
                        
                    </a>
                </div>




            </div>
        </div>
    </div>
</div>
<!-- /main-header -->
<?php /**PATH C:\Herd\MDSJEDPR\resources\views/layouts/main-header.blade.php ENDPATH**/ ?>
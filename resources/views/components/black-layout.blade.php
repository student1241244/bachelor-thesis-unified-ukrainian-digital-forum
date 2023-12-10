<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="TechyDevs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Disilab -  Social Questions and Answers HTML Template</title>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" sizes="16x16" href="/images/favicon.png">

    <!-- inject:css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/line-awesome.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/css/style.css">
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
    <!-- end inject -->
</head>
<body>

<!-- start cssload-loader -->
<div id="preloader">
    <div class="loader">
        <svg class="spinner" viewBox="0 0 50 50">
            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
        </svg>
    </div>
</div>
<!-- end cssload-loader -->

<!--======================================
        START HEADER AREA
    ======================================-->
<header class="header-area bg-dark">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2">
                <div class="logo-box">
                    <a href="index.html" class="logo"><img src="images/logo-white.png" alt="logo"></a>
                    <div class="user-action">
                        <div class="search-menu-toggle icon-element icon-element-xs shadow-sm mr-1" data-toggle="tooltip" data-placement="top" title="Search">
                            <i class="la la-search"></i>
                        </div>
                        <div class="off-canvas-menu-toggle icon-element icon-element-xs shadow-sm" data-toggle="tooltip" data-placement="top" title="Main menu">
                            <i class="la la-bars"></i>
                        </div>
                    </div>
                </div>
            </div><!-- end col-lg-2 -->
            <div class="col-lg-10">
                <div class="menu-wrapper">
                    <nav class="menu-bar mr-auto menu-bar-white">
                        <ul>
                            <li>
                                <a href="/home">Home</a>
                            </li>
                            <li class="is-mega-menu">
                                <a href="/qa-home">Q&A</a>
                            </li>
                            <li>
                                <a href="/threads-home">Threads</a>
                            </li>
                            <li>
                                <a href="/about-us">About Lemyk</a>
                            </li>
                        </ul><!-- end ul -->
                    </nav><!-- end main-menu -->
                    <form class="mr-4">
                        <div class="form-group mb-0">
                            {{-- <input class="form-control form--control h-auto py-2" type="text" name="search" placeholder="Type your search words..."> --}}
                            <a href="#" class="text-white mr-2 header-search-icon" title="Search" data-toggle="tooltip" data-placement="bottom">Type your search words... <i class="la la-search"></i></a>
                            {{-- <button class="form-btn" type="button"><i class="la la-search"></i></button> --}}
                        </div>
                    </form>
                    @auth
                    <div class="nav-right-button">
                        <ul class="user-action-wrap d-flex align-items-center">
                            <li class="dropdown">
                                <span class="ball red ball-lg noti-dot"></span>
                                <a class="nav-link dropdown-toggle dropdown--toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-bell"></i>
                                </a>
                                <div class="dropdown-menu dropdown--menu dropdown-menu-right mt-3 keep-open" aria-labelledby="notificationDropdown">
                                    <h6 class="dropdown-header"><i class="la la-bell pr-1 fs-16"></i>Notifications</h6>
                                    <div class="dropdown-divider border-top-gray mb-0"></div>
                                    <div class="dropdown-item-list">
                                        <a class="dropdown-item" href="notifications.html">
                                            <div class="media media-card media--card shadow-none mb-0 rounded-0 align-items-center bg-transparent">
                                                <div class="media-img media-img-sm flex-shrink-0">
                                                    <img src="images/img3.jpg" alt="avatar">
                                                </div>
                                                <div class="media-body p-0 border-left-0">
                                                    <h5 class="fs-14 fw-regular">John Doe following your post</h5>
                                                    <small class="meta d-block lh-24">
                                                        <span>45 secs ago</span>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="notifications.html">
                                            <div class="media media-card media--card shadow-none mb-0 rounded-0 align-items-center bg-transparent">
                                                <div class="media-img media-img-sm flex-shrink-0">
                                                    <img src="images/img4.jpg" alt="avatar">
                                                </div>
                                                <div class="media-body p-0 border-left-0">
                                                    <h5 class="fs-14 fw-regular">Arnold Smith answered on your post</h5>
                                                    <small class="meta d-block lh-24">
                                                        <span>5 mins ago</span>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="notifications.html">
                                            <div class="media media-card media--card shadow-none mb-0 rounded-0 align-items-center bg-transparent">
                                                <div class="media-img media-img-sm flex-shrink-0">
                                                    <img src="images/img4.jpg" alt="avatar">
                                                </div>
                                                <div class="media-body p-0 border-left-0">
                                                    <h5 class="fs-14 fw-regular">Saeed bookmarked your post</h5>
                                                    <small class="meta d-block lh-24">
                                                        <span>1 hour ago</span>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a class="dropdown-item pb-1 border-bottom-0 text-center btn-text fw-regular" href="notifications.html">View All Notifications <i class="la la-arrow-right icon ml-1"></i></a>
                                </div>
                            </li>
                            <li class="dropdown user-dropdown">
                                <a class="nav-link dropdown-toggle dropdown--toggle pl-2" href="#" id="userMenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="media media-card media--card shadow-none mb-0 rounded-0 align-items-center bg-transparent">
                                        <div class="media-img media-img-xs flex-shrink-0 rounded-full mr-2">
                                            <img src="{{auth()->user()->avatar}}" alt="avatar" class="rounded-full js-avatar">
                                        </div>
                                        <div class="media-body p-0 border-left-0">
                                            <h5 class="fs-14" style="color: rgba(255, 255, 255, 0.7)">{{auth()->user()->username}}</h5>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown--menu dropdown-menu-right mt-3 keep-open" aria-labelledby="userMenuDropdown">
                                    <h6 class="dropdown-header">Hi, {{auth()->user()->username}}</h6>
                                    <div class="dropdown-divider border-top-gray mb-0"></div>
                                    <div class="dropdown-item-list">
                                        <a class="dropdown-item" href="user-profile.html"><i class="la la-user mr-2"></i>Profile</a>
                                        <a class="dropdown-item" href="notifications.html"><i class="la la-bell mr-2"></i>Notifications</a>
                                        <a class="dropdown-item" href="referrals.html"><i class="la la-user-plus mr-2"></i>Referrals</a>
                                        <a class="dropdown-item" href="setting.html"><i class="la la-gear mr-2"></i>Settings</a>
                                        <form action="/logout" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="la la-power-off mr-2"></i>Log out</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div><!-- end nav-right-button -->
                    @else
                    <div class="nav-right-button">
                        <a href="/signin" class="btn theme-btn theme-btn-outline theme-btn-outline-white mr-2"><i class="la la-sign-in mr-1"></i> Login</a>
                        <a href="/signup" class="btn theme-btn theme-btn-white"><i class="la la-user mr-1"></i> Sign up</a>
                    </div><!-- end nav-right-button -->
                    @endauth
                </div><!-- end menu-wrapper -->
            </div><!-- end col-lg-10 -->
        </div><!-- end row -->
    </div><!-- end container -->
    <div class="off-canvas-menu custom-scrollbar-styled">
        <div class="off-canvas-menu-close icon-element icon-element-sm shadow-sm" data-toggle="tooltip" data-placement="left" title="Close menu">
            <i class="la la-times"></i>
        </div><!-- end off-canvas-menu-close -->
        <ul class="generic-list-item off-canvas-menu-list pt-90px">
            <li>
                <a href="/home">Home</a>
            </li>
            <li>
                <a href="/qa-home">Q&A</a>
            </li>
            <li>
                <a href="/threads-home">Threads</a>
            </li>
            <li>
                <a href="/about-us">About Lemyk</a>
            </li>
        </ul>
        <div class="off-canvas-btn-box px-4 pt-5 text-center">
            <a href="/signin" class="btn theme-btn theme-btn-sm theme-btn-outline"><i class="la la-sign-in mr-1"></i> Login</a>
            <span class="fs-15 fw-medium d-inline-block mx-2">Or</span>
            <a href="/signup" class="btn theme-btn theme-btn-sm" data-toggle="modal"><i class="la la-plus mr-1"></i> Sign up</a>
        </div>
    </div><!-- end off-canvas-menu -->
    <div class="mobile-search-form">
        <div class="d-flex align-items-center">
            <form method="post" class="flex-grow-1 mr-3">
                <div class="form-group mb-0">
                    <input class="form-control form--control pl-40px" type="text" name="search" placeholder="Type your search words...">
                    <span class="la la-search input-icon"></span>
                </div>
            </form>
            <div class="search-bar-close icon-element icon-element-sm shadow-sm">
                <i class="la la-times"></i>
            </div><!-- end off-canvas-menu-close -->
        </div>
    </div><!-- end mobile-search-form -->
    <div class="body-overlay"></div>
</header><!-- end header-area -->
<!--======================================
        END HEADER AREA
======================================-->

{{$slot}}

<!-- ================================
         START FOOTER AREA
================================= -->
<section class="footer-area pt-80px bg-dark position-relative">
    <span class="vertical-bar-shape vertical-bar-shape-1"></span>
    <span class="vertical-bar-shape vertical-bar-shape-2"></span>
    <span class="vertical-bar-shape vertical-bar-shape-3"></span>
    <span class="vertical-bar-shape vertical-bar-shape-4"></span>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 responsive-column-half">
                <div class="footer-item">
                    <h3 class="fs-18 fw-bold pb-2 text-white">Company</h3>
                    <ul class="generic-list-item generic-list-item-hover-underline pt-3 generic-list-item-white">
                        <li><a href="about.html">About</a></li>
                        <li><a href="contact.html">Contact</a></li>
                        <li><a href="careers.html">Careers</a></li>
                        <li><a href="advertising.html">Advertising</a></li>
                    </ul>
                </div><!-- end footer-item -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 responsive-column-half">
                <div class="footer-item">
                    <h3 class="fs-18 fw-bold pb-2 text-white">Legal Stuff</h3>
                    <ul class="generic-list-item generic-list-item-hover-underline pt-3 generic-list-item-white">
                        <li><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li><a href="terms-and-conditions.html">Terms of Service</a></li>
                        <li><a href="privacy-policy.html">Cookie Policy</a></li>
                    </ul>
                </div><!-- end footer-item -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 responsive-column-half">
                <div class="footer-item">
                    <h3 class="fs-18 fw-bold pb-2 text-white">Help</h3>
                    <ul class="generic-list-item generic-list-item-hover-underline pt-3 generic-list-item-white">
                        <li><a href="faq.html">Knowledge Base</a></li>
                        <li><a href="contact.html">Support</a></li>
                    </ul>
                </div><!-- end footer-item -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 responsive-column-half">
                <div class="footer-item">
                    <h3 class="fs-18 fw-bold pb-2 text-white">Connect with us</h3>
                    <ul class="generic-list-item generic-list-item-hover-underline pt-3 generic-list-item-white">
                        <li><a href="#"><i class="la la-facebook mr-1"></i> Facebook</a></li>
                        <li><a href="#"><i class="la la-twitter mr-1"></i> Twitter</a></li>
                        <li><a href="#"><i class="la la-linkedin mr-1"></i> LinkedIn</a></li>
                        <li><a href="#"><i class="la la-instagram mr-1"></i> Instagram</a></li>
                    </ul>
                </div><!-- end footer-item -->
            </div><!-- end col-lg-3 -->
        </div><!-- end row -->
    </div><!-- end container -->
    <hr class="border-top-gray my-5">
    <div class="container">
        <div class="row align-items-center pb-4 copyright-wrap">
            <div class="col-lg-6">
                <a href="index.html" class="d-inline-block">
                    <img src="images/logo-white.png" alt="footer logo" class="footer-logo">
                </a>
            </div><!-- end col-lg-6 -->
            <div class="col-lg-6">
                <p class="copyright-desc text-right fs-14">Copyright &copy; {{date('Y')}} <a href="https://techydevs.com/">TechyDevs</a> Inc.</p>
            </div><!-- end col-lg-6 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end footer-area -->
<!-- ================================
          END FOOTER AREA
================================= -->

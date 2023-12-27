<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="TechyDevs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@isset($title)
        {{$title}} | LEMYK
        @else
        LEMYK
        @endisset
    </title>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" sizes="16x16" href="/images/favicon.png">

    <!-- inject:css -->
    <link rel="stylesheet" href="/css/upvotejs.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/line-awesome.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/css/selectize.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
<header class="header-area bg-white shadow-sm">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2">
                <div class="logo-box">
                    <a href="/" class="logo"><img src="/images/logo-black.png" alt="logo"></a>
                    <div class="user-action">
                        <div class="search-menu-toggle icon-element icon-element-xs shadow-sm mr-1" data-toggle="tooltip" data-placement="top" title="Пошук">
                            <a href="#" class="text-white mr-2 header-search-icon2" style="top:0px;padding:10px 10px;color:black!important;"><i class="la la-search"></a></i>
                        </div>
                        <div class="off-canvas-menu-toggle icon-element icon-element-xs shadow-sm" data-toggle="tooltip" data-placement="top" title="Main menu">
                            <i class="la la-bars"></i>
                        </div>
                        @auth
                        <div class="user-off-canvas-menu-toggle icon-element icon-element-xs shadow-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="User menu">
                            <i class="la la-user"></i>
                        </div>
                        @else
                        @endauth
                    </div>
                </div>
            </div><!-- end col-lg-2 -->
            <div class="col-lg-10">
                <div class="menu-wrapper border-left border-left-gray pl-4 justify-content-end">
                    <nav class="menu-bar mr-auto menu--bar">
                        <ul>
                            <li>
                                <a href="/home">Головна</a>
                            </li>
                            <li class="is-mega-menu">
                                <a href="/qa-home">Відповіді</a>
                            </li>
                            <li class="is-mega-menu">
                                <a href="/threads-home">Треди</a>
                            </li>
                            <li>
                                <a href="/about">Про Лемика</a>
                            </li>
                        </ul><!-- end ul -->
                    </nav><!-- end main-menu -->
                    <form class="mr-2">
                        <div class="form-group mb-0">
                            <a class="text-white mr-2 header-search-icon" title="Пошук" data-toggle="tooltip" data-placement="bottom">Введіть слова пошуку... <i class="la la-search"></i></a>
                        </div>
                    </form>
                    @auth
                    <div class="nav-right-button">
                        <ul class="user-action-wrap d-flex align-items-center">
                            <li class="dropdown">
                                <a class="nav-link dropdown-toggle dropdown--toggle" href="/favourites/{{auth()->user()->username}}" role="button" aria-expanded="false">
                                    <i class="la la-star-o"></i>
                                </a>
                            </li>
                            <li class="dropdown user-dropdown">
                                <a class="nav-link dropdown-toggle dropdown--toggle pl-2" href="#" id="userMenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="media media-card media--card shadow-none mb-0 rounded-0 align-items-center bg-transparent">
                                        <div class="media-img media-img-xs flex-shrink-0 rounded-full mr-2">
                                            <img src="{{auth()->user()->avatar}}" alt="avatar" class="rounded-full js-avatar">
                                        </div>
                                        <div class="media-body p-0 border-left-0">
                                            <h5 class="fs-14">{{auth()->user()->username}}</h5>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown--menu dropdown-menu-right mt-3 keep-open" aria-labelledby="userMenuDropdown">
                                    <h6 class="dropdown-header">Привіт, {{auth()->user()->username}}</h6>
                                    <div class="dropdown-divider border-top-gray mb-0"></div>
                                    <div class="dropdown-item-list">
                                        <a class="dropdown-item" href="/profile/{{ auth()->user()->username }}"><i class="la la-user mr-2"></i>Профіль</a>
                                        <a class="dropdown-item" href="/favourites/{{ auth()->user()->username }}"><i class="la la-star-o mr-2"></i>Вибране</a>
                                        <a class="dropdown-item" href="/questions/1"><i class="la la-fire mr-2"></i>В тренді</a>
                                        <a class="dropdown-item" href="/profile-settings"><i class="la la-gear mr-2"></i>Налаштування</a>
                                        <form action="/logout" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="la la-power-off mr-2"></i>Вийти</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div><!-- end nav-right-button -->
                    @else
                    <div class="nav-right-button">
                        <a href="/signin" class="btn theme-btn theme-btn-sm theme-btn-outline mr-1">Авторизуватися</a>
                        <a href="/signup" class="btn theme-btn theme-btn-sm">Зареєструватися</a>
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
                <a href="/">Головна</a>
            </li>
            <li>
                <a href="/qa-home">Відповіді</a>
            </li>
            <li>
                <a href="/threads-home">Треди</a>
            </li>
            <li>
                <a href="/about">Про Лемика</a>
            </li>
        </ul>
        @auth
        @else
        <div class="off-canvas-btn-box px-4 pt-5 text-center">
            <a href="/signin" class="btn theme-btn theme-btn-sm theme-btn-outline"><i class="la la-sign-in mr-1"></i> Логін</a>
            <span class="fs-15 fw-medium d-inline-block mx-2">Or</span>
            <a href="/signup" class="btn theme-btn theme-btn-sm" data-toggle="modal"><i class="la la-plus mr-1"></i> Зареєструватися</a>
        </div>
        @endauth
    </div><!-- end off-canvas-menu -->
    @auth
    <div class="user-off-canvas-menu custom-scrollbar-styled">
        <div class="user-off-canvas-menu-close icon-element icon-element-sm shadow-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="Close menu">
            <i class="la la-times"></i>
        </div><!-- end user-off-canvas-menu-close -->
        <ul class="nav nav-tabs generic-tabs generic--tabs pt-90px pl-4 shadow-sm" id="myTab2" role="tablist">
            <li class="nav-item"><div class="anim-bar" style="left: 166.838px; width: 50.7625px;"></div></li>
            <li class="nav-item">
                <a class="nav-link active" id="user-profile-menu-tab" data-toggle="tab" href="#user-profile-menu" role="tab" aria-controls="user-profile-menu" aria-selected="true">Профіль</a>
            </li>
        </ul>
        <div class="tab-content pt-3" id="myTabContent2">
            <div class="tab-pane fade active show" id="user-profile-menu" role="tabpanel" aria-labelledby="user-profile-menu-tab">
                <div class="dropdown--menu shadow-none w-auto rounded-0">
                    <div class="dropdown-item-list">
                        <a class="dropdown-item" href="/profile/{{ auth()->user()->username }}"><i class="la la-user mr-2"></i>Профіль</a>
                        <a class="dropdown-item" href="/favourites/{{ auth()->user()->username }}"><i class="la la-star-o mr-2"></i>Вибране</a>
                        <a class="dropdown-item" href="/questions/1"><i class="la la-fire mr-2"></i>В тренді</a>
                        <a class="dropdown-item" href="/profile-settings"><i class="la la-gear mr-2"></i>Налаштування</a>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="la la-power-off mr-2"></i>Вийти</button>
                        </form>
                    </div>
                </div>
            </div><!-- end tab-pane -->
        </div>
    </div>
    @else
    @endauth
    <div class="body-overlay"></div>
</header><!-- end header-area -->
<!--======================================
        END HEADER AREA
======================================-->

@include('warnings')

{{$slot}}

<!-- ================================
         START FOOTER AREA
================================= -->
<section class="footer-area pt-80px bg-dark position-relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 responsive-column-half">
                <div class="footer-item">
                    <h3 class="fs-18 fw-bold pb-2 text-white">Компанія</h3>
                    <ul class="generic-list-item generic-list-item-hover-underline pt-3 generic-list-item-white">
                        <li><a href="/about">Про Лемика</a></li>
                    </ul>
                </div><!-- end footer-item -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 responsive-column-half">
                <div class="footer-item">
                    <h3 class="fs-18 fw-bold pb-2 text-white">Політика</h3>
                    <ul class="generic-list-item generic-list-item-hover-underline pt-3 generic-list-item-white">
                        <li><a href="/privacy-policy">Політика конфіденційності</a></li>
                        <li><a href="/content-policy">Політика контенту</a></li>
                        <li><a href="/cookie-policy">Політика використання файлів cookie</a></li>
                    </ul>
                </div><!-- end footer-item -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 responsive-column-half">
                <div class="footer-item">
                    <h3 class="fs-18 fw-bold pb-2 text-white">Довідка</h3>
                    <ul class="generic-list-item generic-list-item-hover-underline pt-3 generic-list-item-white">
                        <li><a href="/support">Підтримка</a></li>
                    </ul>
                </div><!-- end footer-item -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 responsive-column-half">
                <div class="footer-item">
                    <h3 class="fs-18 fw-bold pb-2 text-white">Зв'яжіться з нами</h3>
                    <ul class="generic-list-item generic-list-item-hover-underline pt-3 generic-list-item-white">
                        <li><a href="#"><i class="la la-telegram mr-1"></i> Telegram</a></li>
                        <li><a href="#"><i class="la la-facebook mr-1"></i> Facebook</a></li>
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
                <a href="/" class="d-inline-block">
                    <img src="/images/logo-white.png" alt="footer logo" class="footer-logo">
                </a>
            </div><!-- end col-lg-6 -->
            <div class="col-lg-6">
                <p class="copyright-desc text-right fs-14">Copyright &copy; {{date('Y')}} <a href="/">Lemyk</a></p>
            </div><!-- end col-lg-6 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end footer-area -->
<!-- ================================
          END FOOTER AREA
================================= -->

<!-- start back to top -->
<div id="back-to-top" data-toggle="tooltip" data-placement="top" title="Return to top">
    <i class="la la-arrow-up"></i>
</div>
<!-- end back to top -->

<style>
    .hidden {
        display: none;
    }
</style>

<div class="modal fade modal-container" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="replyModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title" id="replyModalTitle">Звіт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-times"></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="report-form" action="{{ route('reports.store') }}">
                    @csrf
                    <input type="hidden" name="type" value="">
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="reason" value="">
                    <div class="form-group">
                        <select class="form-control form--control" id="select_reason">
                            <option value="">Звіт</option>
                            <option value="Spam">Спам</option>
                            <option value="Advert">Оголошення</option>
                            <option value="" class="js-other">Інші відгуки</option>
                        </select>
                    </div>
                    <div class="form-group hidden">
                        <input class="form-control form--control" id="input_reason" placeholder="Введіть причину...">
                    </div>
                    <div class="btn-box">
                        <button type="submit" class="btn theme-btn w-100">
                            Send <i class="la la-arrow-right icon ml-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- template js files -->
<script src="/js/jquery-3.7.1.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/owl.carousel.min.js"></script>
<script src="/js/selectize.min.js"></script>
<script src="/js/jquery.multi-file.min.js"></script>
<script src="/js/main.js"></script>
</body>
</html>

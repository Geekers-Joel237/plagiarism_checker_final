<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>New Project</title>
    @yield('meta')
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <!-- Template CSS -->
    {{--  bundle  --}}
    <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css')}}">
    {{--  form picker start import --}}
    <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/pretty-checkbox/pretty-checkbox.min.css') }}">

    {{--  form picker end import  --}}
    {{--  end bundle  --}}

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('assets/img/favicon.ico') }}" />
    @yield('styles')
</head>

<body>
    <div class="loader" style="opacity: .75;background-color:black">
        <div class="h-100 d-flex justify-content-center">
            <div class="align-self-center">
                {{--  <img src="{{ asset('assets/img/loader/spin.gif') }}" alt="loader">  --}}
            </div>
        </div>
    </div>


    <div id="app">
        {{-- a remplir  --}}
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
                                  collapse-btn"> <i data-feather="align-justify"></i></a></li>
                        <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a>
                        </li>
                        <li class="langue">
                            <select class="form-control selectric changeLang">
                                <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>{{ __('message._lang_en') }}</option>
                                <option value="fr" {{ session()->get('locale') == 'fr' ? 'selected' : '' }}>{{ __('message._lang_fr') }}</option>
                            </select>
                        </li>
                        <li>

                            <form class="form-inline mr-auto">
                                <div class="search-element">
                                    <input class="form-control" type="search" placeholder="Search ..." aria-label="{{ __('message._search_nav_bar') }}" data-width="200">
                                    <button class="btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li   class="dropdown dropdown-list-toggle"><a href="" class="nav-link nav-link-lg message-toggle"><i onclick="event.preventDefault();document.location.href = '';" data-feather="message-circle"></i>
                        <span id="badgess" class="badge headerBadge1" style="background-color: red;">
                             </span> </a>

                    </li>
                    <li id="mail_numb" class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
                            <span id="mailges" class="badge headerBadge1">
                                </span> </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                {{ __('message._message') }}
                                <div class="float-right">
                                    <a href="#">{{ __('message._marck_all_ass_send') }}</a>
                                </div>
                            </div>
                            <div id="content_3" class="dropdown-list-content dropdown-list-message">
                                {{--  liste des mails recu de l'utilisateur  --}}
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="">{{ __('message._view_all_mail') }} <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    {{--  this is for alert  --}}
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                {{ __('message._notif') }}
                                <div class="float-right">
                                    <a href="#">{{ __('message._marka_llasread') }}</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                               {{--  liste des alertes  --}}
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">{{ __('message._view_all_mail') }}<i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    {{--  this is for user information  --}}
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        {{-- @if( Auth::user()->profile_image == null) --}}
                            <img alt="image" src="{{ asset('assets/img/kairos.png') }}" class="user-img-radious-style">
                        {{-- @else
                            <img alt="image" src="{{ Auth::user()->profile_image }}" class="user-img-radious-style">
                        @endif --}}
                         <span class="d-sm-none d-lg-inline-block"></span></a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">
                            <div class="dropdown-title">Hello
                                {{-- {{ Auth::user()->firstname }} --}}UserName
                            </div>
                            {{-- <input type="hidden" id="user_id" value="{{ Auth::user()->id }}"> --}}
                            <a href="#" class="dropdown-item has-icon"> <i class="far
                                      fa-user"></i> Profiles
                            </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                                Activities
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href=""> <img alt="image" src="{{ asset('assets/img/kairos.png') }}" class="header-logo" /> <span class="logo-name">KM</span>
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Main</li>
                        <li class="dropdown active">
                            <a href="" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
                        </li>
                        {{--  debut de la liste des menus  --}}

                        <li><a class="nav-link" href="#"><i class="fas fa-exchange-alt"></i><span>Exchange</span></a></li>
                        <li><a class="nav-link" href="#"><i class="fas fa-signal"></i><span>Reporting</span></a></li>

                       {{--  capture  --}}
                       <li class="dropdown">
                            <a class="menu-toggle nav-link has-dropdown" href="#">
                                <i class="far fa-clone"></i><span>Capture</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="#">{{ __('message._create') }}</a></li>
                                <li><a class="nav-link" href="">{{ __('message._basket') }}</a></li>
                            </ul>
                        </li>
                        {{--  archivage physique  --}}
                        <li class="dropdown">
                            <a class="menu-toggle nav-link has-dropdown" href="#">
                                <i class="fas fa-box-open"></i><span>Archivage Physique</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="#">{{ __('message._regions') }}</a></li>
                                <li><a class="nav-link" href="#">{{ __('message._villes') }}</a></li>
                                <li><a class="nav-link" href="#">{{ __('message._salles') }}</a></li>
                                <li><a class="nav-link" href="#">{{ __('message._typesdeConteneur') }}</a></li>
                                {{--  gestion des etiquetes  --}}
                                <li class="dropdown">
                                    <a class="menu-toggle nav-link has-dropdown" href="#">{{ __('message._gestiondesetiquettes') }}</a>
                                    <ul class="dropdown-menu">
                                        <li> <a class="nav-link" href="#">{{ __('message._etiquettesdesalle') }}</a></li>
                                        <li><a class="nav-link" href="#">{{ __('message._etiquettesEpi') }}</a></li>
                                        <li><a class="nav-link" href="#">{{ __('message._etiquettesTravée') }}</a></li>
                                        <li><a class="nav-link" href="#">{{ __('message._etiquettesEtagère') }}</a>
                                        </li>
                                        <li><a class="nav-link" href="#">{{ __('message._etiquettesConteneur') }}</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        {{--  parametre  --}}
                        <li class="menu-header">Paramètres</li>
                         <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                    class="fas fa-coins"></i><span>{{ __('message._administration') }}</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nac-link" href="">{{ __('message._organization') }}</a></li>
                                <li><a class="nav-link" href="" data-toggle="tooltip" title="" data-original-title="{{ __('message._classification_scheme') }}">{{  __('message._classification_scheme_reduit') }}</a></li>
                                <li><a class="nac-link" href="">{{ __('message._plan_classements_documentaire_reduit') }}</a></li>
                                <li><a class="nac-link" href=""  data-toggle="tooltip" title="" data-original-title="{{ __('message._documentaire') }}">{{ __('message._documentaire_reduit') }}</a></li>
                                <li><a class="nav-link" href="#">{{ __('message._regle_de_description') }}</a></li>
                                {{--  profile de metadonnee  --}}
                                <li class="dropdown">
                                    <a href="" class="nav-link "><span>{{ __('message._profildemetadonnee') }}</span></a>
                                </li>
                                {{--  regles de convertion  --}}
                                <li class="dropdown">
                                    <a href="" class="nav-link"><span>{{ __('message._conversion') }}</span></a>
                                </li>
                                    {{-- <ul class="dropdown-menu">
                                        <li><a class="nav-link" href="{{route('admin.regle_conversion.index')}}">{{ __('message._regledeconversion') }}</a></li>
                                        <li><a class="nav-link" href="{{route('admin.rapport_conversion.index')}}">{{ __('message._rapport_conversion') }}</a></li>
                                    </ul>
                                </li> --}}

                                <li>
                                    <a class="nav-link" href="">{{ __('message._referentiel_gestion') }}</a>
                                </li>

                            </ul>
                        </li>
                         {{--  security  --}}
                         {{-- @if(check_access_groupe(Auth::user()->id_groupe,'view_security_tag') == 'on')
                            <li class="dropdown">
                                <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-lock"></i><span>{{ __('message._security') }}</span></a>
                                <ul class="dropdown-menu">

                                    <li><a class="nav-link" href="">{{ __('message._groupeutilisateur') }}</a></li>
                                    <li><a class="nav-link" href="">{{ __('message._utilisateurs') }}</a></li>
                                    <li><a class="nav-link" href="">{{ __('message._historiques') }}</a></li>
                                </ul>
                            </li>
                         @endif --}}
                        {{--  for coffre fort  --}}
                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-user-lock"></i><span>{{ __('message._safe_deposit') }}</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="">Management tools</a></li>
                                <li><a class="nav-link" href="">Get access</a></li>

                                <li><a class="nav-link" href="#">{{ __('message._historiques') }}</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-wrench"></i><span>{{ __('message._tools') }}</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="">{{ __('message._contacts') }}</a></li>
                            </ul>
                        </li>
                        {{-- @if(check_access_groupe(Auth::user()->id_groupe,'view_settings') == 'on') --}}
                            <li><a class="nav-link" href=""><i class="fas fa-cogs"></i><span>{{ __('message._setting') }}</span></a></li>
                        {{-- @endif --}}
                    </ul>
                </aside>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                    {{-- yield content here  --}}
                    @yield('content')
                <div class="settingSidebar">
                    <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
                    </a>
                    <div class="settingSidebar-body ps-container ps-theme-default">
                        <div class=" fade show active">
                            <div class="setting-panel-header">Setting Panel
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Select Layout</h6>
                                <div class="selectgroup layout-color w-50">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                                        <span class="selectgroup-button">Light</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                                        <span class="selectgroup-button">Dark</span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                                <div class="selectgroup selectgroup-pills sidebar-color">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                                        <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                                        <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Color Theme</h6>
                                <div class="theme-setting-options">
                                    <ul class="choose-theme list-unstyled mb-0">
                                        <li title="white" class="active">
                                            <div class="white"></div>
                                        </li>
                                        <li title="cyan">
                                            <div class="cyan"></div>
                                        </li>
                                        <li title="black">
                                            <div class="black"></div>
                                        </li>
                                        <li title="purple">
                                            <div class="purple"></div>
                                        </li>
                                        <li title="orange">
                                            <div class="orange"></div>
                                        </li>
                                        <li title="green">
                                            <div class="green"></div>
                                        </li>
                                        <li title="red">
                                            <div class="red"></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <div class="theme-setting-options">
                                    <label class="m-b-0">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="mini_sidebar_setting">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="control-label p-l-10">Mini Sidebar</span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <div class="theme-setting-options">
                                    <label class="m-b-0">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="sticky_header_setting">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="control-label p-l-10">Sticky Header</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                                    <i class="fas fa-undo"></i> Restore Default
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    <a href="#">&copy; {{ __('message._copyrith_') }}</a></a>
                </div>
                <div class="footer-right">
                     <p><a target="_blank" href="kairos-sarl.com">Kairos KM</a></p>
                </div>
            </footer>
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- JS Libraies -->
    {{--  bundle folder  --}}
    <script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js')}}"></script>
    <!-- datatable-->
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js')}}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/bundles/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/cleave-js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/cleave-js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('assets/bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>
    {{--  end bundle folder  --}}


    <!-- Page Specific JS File -->
    {{--  page folder  --}}
    <script src="{{ asset('assets/js/page/index.js') }}"></script>
    <script src="{{ asset('assets/js/page/widget-data.js') }}"></script>
    <script src="{{ asset('assets/js/page/toastr.js') }}"></script>
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
    <script src="{{ asset('assets/js/page/chart-apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/page/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script>
    {{--  end page folder  --}}
    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('toastr.js') }}"></script>
    <script src="{{ asset('assets/js/chat.js') }}"></script>
    <script src="{{ asset('assets/js/treeview.js') }}"></script>
    <!-- Template JS File -->
    <script type="text/javascript">
        var url = "#";

        $(".changeLang").change(function() {
            window.location.href = url + "?lang=" + $(this).val();
        });

    </script>
    {{-- {!! Toastr::message() !!} --}}
    <script>
        @if($errors->any())
        @foreach($errors->all() as $error)
        toastr.error('{{ $error }}', 'Error', {
            closeButtor: true
            , progressBar: true
        });
        @endforeach
        @endif
    </script>
    @yield('scripts')
    @stack('other-scripts')
</body>
</html>

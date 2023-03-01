<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
		<title>Admin Pannel - {{ config('app.name')}} </title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="{{ config('app.name')}} | Admin Pannel">
        <meta name="author" content="Bdtask">
		<meta name="robots" content="noindex, nofollow">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ get("favicon") }}">
        <!--Global Styles(used by all pages)-->
        <link href="{{ asset("admin-assets/plugins/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/plugins/metisMenu/metisMenu.min.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/plugins/fontawesome/css/all.min.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/plugins/typicons/src/typicons.min.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/plugins/themify-icons/themify-icons.min.css")}}" rel="stylesheet">
        <!--Third party Styles(used by this page)-->
        <link href="{{ asset("admin-assets/plugins/emojionearea/dist/emojionearea.min.css")}}" rel="stylesheet">
        <script src="{{ asset("admin-assets/plugins/jQuery/jquery-3.4.1.min.js")}}"></script>
        <!--Start Your Custom Style Now-->

        @if (Request::segment(2)=='faqs' || ( Request::segment(2)=='blogs' and Request::segment(3)=='category'))
        <!-- JQuery UI -->
        <link href="{{ asset("admin-assets/plugins/jquery-ui-1.12.1/jquery-ui.css")}}" rel="stylesheet">
        @endif
         @if (Request::segment(2)=='services')
        <!-- JQuery UI -->
        <link href="{{ asset("admin-assets/plugins/bootstrap4-toggle/css/bootstrap4-toggle.min.css")}}" rel="stylesheet">
        @endif
        <link href="{{ asset("admin-assets/dist/css/style.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/dist/css/custom.css")}}" rel="stylesheet">
        {{-- For Only Blog page --}}
        <link href="{{ asset("admin-assets/plugins/icheck/skins/all.css")}}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
        var baseURL = "{{route('HomeUrl')}}/{{admin}}/";
        homeURL = "{{route('HomeUrl')}}/";
        </script>
    </head>
    <body class="fixed">
        <!-- Page Loader -->
{{--        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>  --}}
        <!-- #END# Page Loader -->
    </div>
</div>
<!-- Modal: Search Activity -->

<div class="wrapper">
    <!-- Sidebar  -->
    <nav class="sidebar sidebar-bunker">
        <div class="profile-element d-flex align-items-center flex-shrink-0">
            <div class="avatar online">
                
				<a href="{{ route("HomeUrl") }}" target="_blank"><img src="{{ asset("admin-assets/dist/img/digital-applications-logo-small.png")}}" class="img-fluid rounded-circle" alt="Digital Applications"></a>
            </div>
            <div class="profile-text">
                <h6 class="m-0">Admin</h6>
                <span><a class="text-white" href="{{ route('HomeUrl') }}" target="_blank" >View Website</a></span>
            </div>
            </div><!--/.profile element-->
            <!--                <form class="search sidebar-form" action="#" method="get" >
                <div class="search__inner">
                    <input type="text" class="search__text" placeholder="Search...">
                    <i class="typcn typcn-zoom-outline search__helper" data-sa-action="search-close"></i>
                </div>
            </form>/.search-->
            
            <div class="sidebar-body">
                <nav class="sidebar-nav" style="padding-bottom: 30px;">
                    <ul class="metismenu">
                        <li class="nav-label">Main Menu</li>
                        <li class="{{ Request::segment(2)=='dashboard' ? 'mm-active' : '' }}">
                            <a href="{{url('/'.admin.'/dashboard')}}"><i class="typcn typcn-home-outline mr-2"></i> Dashboard</a>
                        </li>
                        <li class="{{ Request::segment(2)=='menu' ? 'mm-active' : '' }}">
                            <a href="{{url('/'.admin.'/menu')}}"><i class="typcn typcn-th-menu mr-2"></i> Menu</a>
                        </li>
                        <li class="{{ Request::segment(2)=='homepage' ? 'mm-active' : '' }}">
                            <a href="{{url('/'.admin.'/homepage')}}"><i class="typcn typcn-device-desktop mr-2"></i> Home Page</a>
                        </li>
                        <li class="{{ Request::segment(2)=='about' || Request::segment(2)=='contactus' || Request::segment(2)=='terms-condition' || Request::segment(2)=='privacy-policy' || Request::segment(2)=='faqs'  || Request::segment(2)=='faqs-list'  ? 'mm-active' : '' }}">
                            <a class="has-arrow material-ripple" href="#">
                                <i class="typcn typcn-tabs-outline mr-2"></i>
                                CMS
                            </a>
                            <ul class="nav-second-level">
                                <li class="{{ Request::segment(2)=='about' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/about')}}">About</a></li>
                                <li class="{{ Request::segment(2)=='write-us' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/write-us')}}">Write For Us</a></li>
                                <li class="{{ Request::segment(2)=='contactus' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/contactus')}}">Contact</a></li>
                                <li class="{{ Request::segment(2)=='terms-condition' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/terms-condition')}}">Terms & Conditions</a></li>
                                <li class="{{ Request::segment(2)=='privacy-policy' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/privacy-policy')}}">Privacy Policy</a></li>
                                <li class="{{ (Request::segment(2)=='faqs' || Request::segment(2)=='faqs-list' ) ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/faqs')}}">FAQs</a></li>
                            </ul>
                        </li>
                        @php
                            echo $pg =  request()->has('pg') ? request()->get('pg') : ''
                        @endphp
                        <li class="{{ Request::segment(2)=='sidebar-settings' ? 'mm-active' : '' }}">
                            <a class="has-arrow material-ripple" href="#">
                                <i class="typcn icon typcn-th-menu-outline mr-2"></i>
                                Sidebar Settings
                            </a>
                            <ul class="nav-second-level">
                                <li class="{{ $pg=='blog' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/sidebar-settings?pg=blog')}}">Blog Detail</a></li>
                               
                                <li class="{{ $pg =='about' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/sidebar-settings?pg=about')}}">About</a></li>
                                <li class="{{ $pg =='write-for-us' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/sidebar-settings?pg=write-for-us')}}">Write For Us</a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::segment(2)=='emails'  ? 'mm-active' : '' }}">
                            <a class="has-arrow material-ripple" href="#">
                                <i class="typcn typcn-mail mr-2"></i>
                                Emails  
                            </a>
                            <ul class="nav-second-level">
                                <li class="{{ (Request::segment(2)=='emails' && Request::segment(3)=='') || Request::segment(2)=='edit-emails' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/emails')}}">Emails</a></li>
                                <li class="{{ Request::segment(3)=='' && Request::segment(2)=='send-email' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/send-email')}}">Send Emails</a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::segment(2)=='blogs'  ? 'mm-active' : '' }}">
                            <a class="has-arrow material-ripple" href="#">
                                <i class="typcn typcn-th-list mr-2"></i>
                                Blogs
                            </a>
                            <ul class="nav-second-level">
                                <li class="{{ Request::segment(2)=='blogs' && Request::segment(3)=='' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/blogs')}}">Add New Blog</a></li>
                                <li class="{{ Request::segment(3)=='list' && Request::segment(2)=='blogs' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/blogs/list')}}">Blogs List</a></li>
                                <li class="{{ Request::segment(3)=='category' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/blogs/category')}}">Blog Category</a></li>
                            </ul>
                        </li> 
                        <li class="{{ Request::segment(2)=='add-author' || Request::segment(2)=='authors-list' ? 'mm-active' : '' }}">
                            <a href="{{url('/'.admin.'/authors-list')}}"><i class="typcn typcn-group mr-2"></i> Authors</a>
                        </li>
						<li class="{{ Request::segment(2)=='ads' ? 'mm-active' : '' }}">
                            <a href="{{url('/'.admin.'/ads')}}"><i class="typcn typcn-arrow-forward mr-2"></i> Ads</a>
                        </li>
						<li class="insert-media">
                            <a href="" class="md-btn"><i class="typcn typcn-image mr-2"></i> Media  </a>
                        </li>
						<script>
							$('a.md-btn').click(function(event){
								event.preventDefault();
								//do whatever
							  });
						</script>
                        <li class="{{ Request::segment(2)=='general-setting' || Request::segment(2)=='theme-setting' || Request::segment(2)=='login-info' || Request::segment(2)=='footer' ? 'mm-active' : '' }}">
                            <a class="has-arrow material-ripple" href="#">
                                <i class="typcn typcn typcn-cog mr-2"></i>
                                Settings
                            </a>
                            <ul class="nav-second-level">
								<li class="{{ Request::segment(2)=='general-setting' ? 'mm-active' : '' }}"><a href="{{url('/'.admin.'/general-setting')}}">General Setting</a></li>
								<li class="{{ Request::segment(2)=='theme-setting' ? 'mm-active' : '' }}"><a href="{{url('/'.admin.'/theme-setting')}}">Theme Setting</a></li>
								<li class="{{ Request::segment(2)=='internal-links' ? 'mm-active' : '' }}"><a href="{{url('/'.admin.'/internal-links')}}">Internal Links</a></li>
								<li class="{{ Request::segment(2)=='log-book' ? 'mm-active' : '' }}"><a href="{{url('/'.admin.'/log-book')}}">Log Book</a></li>
                                <li class="{{ Request::segment(2)=='login-info' ? 'mm-active' : '' }}"><a href="{{url('/'.admin.'/login-info')}}">Login Setting</a></li>      
                            </ul>
                        </li>
                    </ul>
                </nav>
                </div><!-- sidebar-body -->
                
            </nav>
            <!-- Page Content  -->
            <div class="content-wrapper">
                <div class="main-content">
                    <nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
                        <div class="sidebar-toggle-icon" id="sidebarCollapse">
                            sidebar toggle<span></span>
                            </div><!--/.sidebar toggle icon-->
                            <div class="d-flex flex-grow-1">
                                <ul class="navbar-nav flex-row align-items-center ml-auto">
                                    <li class="nav-item dropdown user-menu">
                                        <a class="nav-link {{-- dropdown-toggle --}}" href="{{ route("HomeUrl") }}/{{ admin }}/logout" {{-- data-toggle="dropdown" --}} title="Log Out">
                                            <!--<img src="assets/dist/img/user2-160x160.png" alt="">-->
                                            <span class="typcn typcn-export-outline"></span>
                                        </a>
                                        <!--        <div class="dropdown-menu dropdown-menu-right" >
                                            <div class="dropdown-header d-sm-none">
                                                <a href="#" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                                            </div>
                                            <div class="user-header">
                                                <div class="img-user">
                                                    <img src="{{ asset("admin-assets/dist/img/avatar-1.jpg")}}" alt="">
                                                </div>img-user
                                                <h6>Ghulam Abbas</h6>
                                                <span><a href="">dgaps.com@gmail.com</a></span>
                                            </div>user-header
                                            <a href="#" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
                                            <a href="#" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
                                            <a href="#" class="dropdown-item"><i class="typcn typcn-arrow-shuffle"></i> Activity Logs</a>
                                            <a href="#" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account Settings</a>
                                            <a href="page-signin.html" class="dropdown-item"><i class="typcn typcn-key-outline"></i> Sign Out</a>
                                            --><!--/.dropdown-menu -->
                                        </li>
                                        </ul><!--/.navbar nav-->
                                        
                                    </div>
                                    </nav><!--/.navbar-->
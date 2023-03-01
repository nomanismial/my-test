@php

function __has_children( $arr = array() ) {
    $r = false;
    foreach ( $arr as $k => $v ) {
        if ( isset( $v[ "children" ] ) ) {
            $r = true;
        }
    }
    return $r;
}

function __menu( $data, $level = 1 ) {

    foreach ( $data as $k => $v ) {
        if ( isset( $v[ "children" ] ) ) {
            $link = $v[ "link" ];
            $title = $v[ "title" ];
            $type = $v[ "type" ];
            $exp = explode( "/", $link );
            $slug = $exp[ count( $exp ) - 1 ];
            $class = ( __has_children( $v[ "children" ] ) ) ? "sub-menu" : "sub-menu";
            $selected = ( $slug == get_postid( "full" ) ) ? "m-active" : "";
            echo "
				<li class='dropdown'>
					<a class='btn-dropdown $selected ' href='$link'>
					   $title
					</a>               
					<ul class='dropdown-content'>";
					__menu( $v[ "children" ], $level++ );
					echo "</ul>
				</li>";
        } else {
            $link = $v[ "link" ];
            $exp = explode( "/", $link );
            $slug = $exp[ count( $exp ) - 1 ];
            $title = $v[ "title" ];
            $type = $v[ "type" ];
            $selected = ( $slug == get_postid( "full" ) ) ? "class='m-active'" : "";
            echo "<li $selected><a href='$link'>$title</a></li>";
        }
    }
}
$Options = new App\Helpers\Options;
$menu = $Options->get("menu");
$data = ( $menu == "" ) ? array() : json_decode( $menu, true );
@endphp
    <div class="bd-topnav">
	    <div class="bd-container">
	        <div class="row align-items-center">
	            <div class="col-6 col-sm-6 col-md-3 col-lg-3">
@php
$rec = DB::table("generalsettings")->first();
@endphp
	      		<a href="{{ route('HomeUrl') }}" class="site_logo">
@if (!empty($rec->logo))
	       		<img src="{{ $rec->logo }}" class="img-fluid" alt="Web Site Logo" width="300" height="70">
@endif
	       		</a>
	            </div>
	            <div class="col-6 col-sm-6 d-sm-block d-md-none d-lg-none d-xl-none">
	                <div class="nav-mob">
	                    <button class="toggle-menu-btn">Menu</button>
	                </div>
	            </div>
	            <div class="col-12 col-sm-12 col-md-9 col-lg-9">
	                <div class="navbar">
	                    <ul class="nav quote-nav">
	                       @php
                              		 __menu($data); 
                           @endphp
	                    </ul>
	                    <div class="search-list">
	                       <button type="submit" class="search-submit searchbtn"> <i class="icon-search"></i> </button>
	                    </div>
		                <div class="searchContent">
	                         <form role="search" class="form--search" action="/search">
	                            <input class="form-search" type="search" name="search" placeholder="Search ...">
	                            <button type="submit" class="search-submit search-submit2 "> <i class="icon-search2"></i> </button>
	                        </form>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<div id="add-this"></div>

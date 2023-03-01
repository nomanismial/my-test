@php
$logo = get("logo");
get_image($logo)
@endphp

<header>
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
            $class = ( __has_children( $v[ "children" ] ) ) ? "" : "dropdown";
            $selected = ( $slug == get_postid( "full" ) ) ? "active" : "";
            echo "
        <li class='nav-item $class '>
          <a class='nav-link dropdown-toggle rounded-top rounded-0 ' id='navbarDropdown' data-bs-toggle='dropdown' aria-expanded='false' href='$link'>
             $title
          </a>
          <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>";
          __menu( $v[ "children" ], $level++ );
          echo "</ul>
        </li>";
        } else {
            $link = $v[ "link" ];
            $exp = explode( "/", $link );
            $slug = $exp[ count( $exp ) - 1 ];
            $title = (strtolower($v[ "title" ]) == "home") ? "<i class='icon-home3'></i>"  : $v[ "title" ];
            $type = $v[ "type" ];
            $selected = ( $slug == get_postid( "full" ) ) ? "active" : "";
            echo "<li class='nav-item $selected'><a class='nav-link' href='$link'>$title</a></li>";
        }
    }
}
$Options = new App\Helpers\Options;
$menu = $Options->get("menu");
$data = ( $menu == "" ) ? array() : json_decode( $menu, true );
@endphp
  <nav class="navbar navbar-expand-md navbar-light" id="navbar">
    <div class="container wrapper_con position-relative">
      @php
      $logo = get("logo");
      @endphp
      @if (!empty($logo))
      <a class="navbar-brand" href="{{ route('HomeUrl') }} ">
       <img src="{{ get_image($logo) }}" alt="{{ get_alt($logo) }}" title="{{ get_alt($logo) }}" width="300" height="70">
        </a>
      @endif
        <button class="btn btn-outline-light searchbtn search-sm" type="submit" aria-label="search"><span class="icon-search"></span></button>
        <div class="searchContent">
          <form role="search" class="form--search" action="/search">
            <input class="form-search" autocomplete="off" type="search" value="{{ (request()->has('q')) ? request()->get('q') : "" }}" name="q" placeholder="Search ..." autofocus>
            <!--            change the button type to submit -->
            <button type="button" class="search-submit search-submit2" aria-label="search"> <span class="icon-search"></span> </button>
          </form>
        </div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse position-relative" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto me-0 me-md-1">
          @php
            __menu($data);
         @endphp
        </ul>
        <button class="btn btn-outline-light searchbtn searching-md" type="submit" aria-label="search"><span class="icon-search"></span></button>
        <div class="searchContent">
          <form role="search" class="form--search" action="/search">
            <input class="form-search" autocomplete="off" type="search" name="search" placeholder="Search ..." >
            <!--            change the button type to submit -->
            <button type="button" class="search-submit search-submit2" aria-label="search"> <span class="icon-search"></span> </button>
          </form>
        </div>
      </div>
    </div>
  </nav>
</header>
<script>
    document.addEventListener('scroll', function(e){
      var navbar = document.getElementById("navbar");
      var sticky = navbar.offsetTop;
      if (window.pageYOffset > sticky) {
        navbar.classList.add("sticky")
      } else {
        navbar.classList.remove("sticky");
      }
    });
</script>

@php
	$url = route("HomeUrl")."/".get_postid("full");
	$site_name = get("website_title");
	$google_analytics =  get("google_analytics");
	$bing_master =  get("bing_master");
	$header_script =  get("header_script");
@endphp
<!-- start back-to-top -->
<div id="back-to-top" class="element-3"> <i class="icon-arrow-up2" title="Go top"></i> </div>
<!-- end back-to-top -->
<div class="newsletter py-4 py-md-5">
  <div class="container wrapper_con">
    <div class="row align-items-center justify-content-center">
      <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-5 newsletter__text d-lg-block d-flex justify-content-center justify-content-md-start pb-2 pb-md-2 pb-lg-0">
		  @if(get("subscriber_text") != "" )
        <h3 class="font-weight-bold text-white m-0">{{ get("subscriber_text") }}</h3>
		  @endif
      </div>
      <div class="col-12 col-sm-12 col-md-5 col-lg-6 col-xl-5">
        <form action="{{ route("HomeUrl") }}">
          <div class="newsletter__input d-flex justify-content-md-end justify-content-xl-start justify-content-center">
            <input type="email" name="email" class="form-control" placeholder="Please Enter Your Email to Subscribe">
            <a class="btn btn-subscribe _sub_btn">Subscribe </a> </div>
          <div class="sub_error text-green"></div>
        </form>
      </div>
    </div>
  </div>
</div>
<footer>
  <div class="footer-b">
    <div class="container">
      <div class="row">
        <div class="col-12 social-links text-center py-2 py-md-3">
          <ul class="social-profile">
        @php
          $facebook = get("facebook_url");
        @endphp
        @if (!empty($facebook))
          <li><a href="{{ $facebook }}" class="facebook-bg" target="_blank" title="Facebook" rel="nofollow noopener"><i class="icon-facebook"></i></a></li> 
        @endif
        @php
          $twitter = get("twitter_url");
        @endphp
        @if (!empty($twitter))
          <li><a href="{{ $twitter }}" class="twitter-bg" target="_blank" title="Twitter" rel="nofollow noopener"><i class="icon-twitter"></i></a></li>
        @endif

        @php
          $instagram = get("instagram_url");
        @endphp
        @if (!empty($instagram))
          <li><a href="{{ $instagram }}" class="instagram-bg" target="_blank" title="Instagram" rel="nofollow noopener"><i class="icon-instagram"></i></a></li>
        @endif
        @php
          $linkedin = get("linkedin_url");
        @endphp
		    @if (!empty($linkedin))
        <li><a href="{{ $linkedin }}" class="linkedin-bg" target="_blank" title="LinkedIn" rel="nofollow noopener"><i class="icon-linkedin"></i></a></li>
        @endif
        
        @php
          $youtube = get("youtube_url");
        @endphp
        @if (!empty($youtube))
          <li><a href="{{ $youtube }}" class="youtube-bg" target="_blank" title="Youtube" rel="nofollow noopener"><i class="icon-youtube"></i></a></li>
        @endif
          </ul>
        </div>
        <div class="col-12">
          <nav class="footer__nav">
            <ul class="d-flex justify-content-center list-unstyled m-0 p-0">
              <li class="my-2 m-2"><a href="{{ route('contact-us') }}" class="text-decoration-underline" > Contact Us </a></li>
              <li class="my-2 m-2"><a href="{{ route('write-for-us') }}" class="text-decoration-underline" > Write For Us </a></li>
              <li class="my-2 m-2"><a href="{{ route('about-us') }}" class="text-decoration-underline" > About Us </a></li>
              <li class="my-2 m-2"><a href="{{ route('privacy-policy') }}" class="text-decoration-underline" > Privacy Policy </a></li>
              <li class="my-2 m-2"><a href="{{ route('terms-conditions') }}" class="text-decoration-underline" > Terms &amp; Conditions </a></li>
              <li class="my-2 m-2"><a href="{{ route('faqs') }}" class="text-decoration-underline" > FAQs </a></li>
            </ul>
          </nav>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 d-flex justify-content-center justify-content-lg-start">
        @if (!empty(get("copy_rights")))
        <div class="footer__copy py-sm-2 py-md-3 py-1">{!! get("copy_rights") !!}</div>
        @endif          
        </div>

        @php
            $type = "rel='noopener noreferrer' ";
        @endphp 

        <div class="col-12 col-sm-12 col-md-12 col-lg-6 d-flex justify-content-center justify-content-lg-end mb-5 mb-lg-0">
          <div class="footer__copy py-sm-2 py-md-3 py-1">Developed By: <a href="https://bintefarooq.com" {!! $type !!}  target="_blank">BinteFarooq.com</a></div>
        </div>
      </div>
    </div>
  </div>
</footer>
<!--Add This-->
@if(desktop)
<div id="add-this"></div>
@endif
<link rel="preload" href="{{ asset('assets/css/icomoon.css') }}" as="style" onload="this.rel='stylesheet'">
<!--Web Designer--> 
<!--Abdullah Yousaf--> 
<!--fb.com/raoabdullah07/--> 
<!--Jquery 3.5.1--> 
<script src="{{ asset('assets/js/jquery.min.js') }}" defer></script> 

<script src="{{ asset('assets/js/main.js') }}?v={{ rand("999" , "9999")}}" defer></script> 
<!--Lazy load--> 
<!--<script src="assets/js/lazyloadimage.js" async></script> --> 
<!--Bootstrap latest 5.0.2--> 
<script src="{{ asset('assets/js/bootstrap.min.js') }}" defer></script> 
<!-- Button trigger modal --> 
<!-- Modal -->
<div class="modal fade" id="model" tabindex="-1" aria-labelledby="successLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content success"> 
      <div class="modal-header">
        <h5 class="modal-title fw-bolder text-center flex-grow-1" id="successLabel">{{ str_replace("-", " ", config('app.name') ) }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-3 text-center">
        <p class=" h3 fw-bold">Congratulations! <span class="icon-smile"></span></p>
        <p class="text-black-50 h6 fw-bolder my-3">You have subscribed for {{ str_replace("-", " ", config('app.name') ) }} Newsletter</p>
      </div>
    </div>
  </div>
</div>
<div class="modal model-error fade" id="error" tabindex="-1" aria-labelledby="errorLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content"> 
      <div class="modal-header">
        <h5 class="modal-title fw-bolder text-center flex-grow-1" id="errorLabel">{{ $site_name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-3 text-center">
        <p class="text-danger h3 fw-bold">oops! <span class="icon-sad"></span></p>
        <p class="text-black-50 h6 fw-bolder my-3 error_message">You have subscribed for our SEO Tips &amp; Tricks</p>
      </div>
    </div>
  </div>
</div>
<template class="db-temp">
{!! $google_analytics !!}
{!! $bing_master !!}
@if(get_postid("full") !="")
{!! $header_script !!}
@endif
</template>
<script>
	setTimeout(function(){
		$('head').append($(".db-temp").html());
		$(".db-temp").remove();
	},5000);
  var seg1 = "{{ get_postid("full") }}";
  var _token = "{{ csrf_token() }}";
  var base_url = "{{ route("HomeUrl") }}";
  var page_id = {{ get_postid("page_id") }};
  var site_name = "{{ $site_name }}";
  var _fullUrl = "{{ $url }}";
  var _desktop = "{{ desktop }}";
  @if (desktop)
    window.onload=function(){setTimeout(function(){var t=document.createElement("script");t.src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-61518a30248404bf",document.getElementById("add-this").appendChild(t),t.setAttribute("data-url","{{  url()->full() }}")},6500)};
  @endif

</script> 

@include("front.layout.header")

    <link rel="stylesheet" href="{{ asset('assets/css/head_foot.css') }}?v{{ get("css_version") }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ask_me.css') }}?v{{ get("css_version") }}">
</head>
<body>
@include("front.layout.main-menu")
<div class="page-header">
   <div class="wrapper_con">
      <div class="row">
         <div class="col-md-12">
            <nav aria-label="breadcrumb">
			  <ol class="breadcrumb float-start">
				<li class="breadcrumb-item"><i class="icon-location2 me-2 me-sm-3"></i><a href="{{ route('HomeUrl') }}">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Contact Us</li>
			  </ol>
        	</nav>
         </div>
      </div>
   </div>
</div>

<!--Starts Contact Content Section -->

  <div class="container my-5">
    <div class="row">
      <div class="col-lg-8">
        <div class="block-card">
          <div class="block-card-header">
            <h1 class="widget-title pb-0 mb-0">Send us a message</h1>
            <p class="p-0 m-0">Contact us today using this form and our support team will reach out as soon as possible.</p>
            <div class="mt-2 mb-0 alert alert-success alert-dismissible fade show" role="alert" style="display: none">
              <strong>Message Sent!</strong> You should check in on some of those fields below.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
          <!-- block-card-header -->
          <div class="block-card-body">
            <form method="post" class="form-box row" id="myForm">
              <div class="col-lg-6">
                <div class="input-box">
                  <label class="label-text">Your Name <span class="text-danger"> *</span></label>
                  <span class="d-block text-danger _errorText float-end font-size-12"></span>
                  <div class="form-group"> <span class="icon-user form-icon"></span>
                    <input class="form-control form-control-styled" type="text" name="name" placeholder="Name">
                  </div>
                </div>
              </div>
              <!-- end col-lg-6 -->
              <div class="col-lg-6">
                <div class="input-box">
                  <label class="label-text">Your Email</label>
                  <span class="d-block text-danger _errorText float-end font-size-12"></span>
                  <div class="form-group"> <span class="icon-envelop form-icon"></span>
                    <input class="form-control form-control-styled" type="email" name="email" placeholder="Email">
                  </div>
                </div>
              </div>
              <!-- end col-lg-6 -->
              <div class="col-lg-12">
                <div class="input-box">
                  <label class="label-text">Subject <span class="text-danger"> *</span></label>
                  <span class="d-block text-danger _errorText float-end font-size-12"></span>
                  <div class="form-group"> <span class="icon-files-empty form-icon"></span>
                    <input class="form-control form-control-styled" type="text" name="subject" placeholder="Subject">
                  </div>
                </div>
              </div>
              <!-- end col-lg-12 -->
              <div class="col-lg-12">
                <div class="input-box">
                  <label class="label-text">Your Message <span class="text-danger"> *</span></label>
                  <span class="d-block text-danger _errorText float-end font-size-12"></span>
                  <div class="form-group"> <span class="icon-pencil form-icon"></span>
                    <textarea class="message-control form-control" name="message" placeholder="Write message"></textarea>
                  </div>
                </div>
              </div>
              <!-- end col-lg-12 -->
              <div class="col-lg-12">
                <div class="btn-box d-block d-sm-block d-md-flex justify-content-between">
                  <p class="font-size-14 pt-1 pb-2 mb-0">*We'll never share your email with anyone else.</p>
                  <button type="submit" class="theme-btn gradient-btn border-0 mybtn1">Send Message <i class="icon-arrow-right2 ms-2"></i></button>
                </div>
              </div>
              <!-- end col-lg-12 -->
            </form>
          </div>
          <!-- end block-card-body -->
        </div>
        <!-- end block-card -->
      </div>
      <!-- end col-lg-8 -->
      <div class="col-lg-4 mt-3 mt-sm-3 mt-lg-0">
        <div class="block-card">
          <div class="block-card-header">
            <h3 class="widget-title">Our Office</h3>
          </div>
			@php
				if(!empty($res['email'])){
			  $prt = explode("@" , $res['email']);
			@endphp
			 <span class="_rec" style="display:none" data-1st="{{ $prt[0] }}" data-2nd="{{ $prt[1] }}"> </span>
			@php
				}
			@endphp
          <!-- block-card-header -->
          <div class="block-card-body">
            @if (!empty($res['cover_image']))
                <img src="{{ get_image($res['cover_image']) }}" alt="Contact Us Image" class="w-100 rounded" width="300" height="200">
            @endif
            <ul class="list-items list--items list-items-style-2 py-4">
              @if (!empty($res['phone']))
                  <li><span class="text-color"><i class="fas fa-phone-alt me-2 text-color-2 "></i>Phone:</span><a href="tel:{{  $res['phone'] }}">{{  $res['phone'] }}</a></li>
              @endif
              @if  (!empty($res['email']))
                  <li><span class="text-color"><i class="far fa-envelope me-2 text-color-2 "></i>Email:</span><a class="_showEmail">dgaps****</a></li>
              @endif
              @if  (!empty($res['address']))
                 <li><span class="text-color"><i class="fas fa-map-marker me-2 text-color-2 "></i>Address:</span>
					<span class="second-txt">{{ $res['address'] }}</span>
				</li>
              @endif

            </ul>
            <div class="section-block-2"></div>
            <h3 class="widget-title font-size-16 pt-4">Working Hours</h3>
            <ul class="list-items pb-4">
              <li class="d-flex align-items-center justify-content-between"><span>Monday To Saturday</span> <span class="text-success">9am - 9pm</span></li>
              <li class="d-flex align-items-center justify-content-between"><span>Sunday</span> <span class="text-color-2">Closed</span></li>
            </ul>
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
          <!-- end block-card-body -->
        </div>
        <!-- end block-card -->
      </div>
      <!-- end col-lg-4 -->
    </div>
  </div>
<!--end Contact Content Section -->
  @php
    $tviews = total_views( 0 , 0 , get_postid("full"));
    refresh_views($tviews , 0,  0 , get_postid("full"));
  @endphp
@include("front.layout.footer")
<script src="{{ asset('assets/js/validate.js') }}"></script>
</body>
</html>

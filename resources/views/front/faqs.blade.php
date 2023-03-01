@include("front.layout.header")

    <link rel="stylesheet" href="{{ asset('assets/css/head_foot.css') }}?v{{ get("css_version") }}">
    <link rel="stylesheet" href="{{ asset('assets/css/faqs.css') }}?v{{ get("css_version") }}">
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
                            <li class="breadcrumb-item active" aria-current="page">Frequently Asked Questions</li>
                        </ol>
                    </nav>
             </div>
          </div>
       </div>
    </div>

    <section class="section__terms my-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="faq-title text-center mb-4">
                        <h1><em>Frequently Asked Questions</em></h1>
                    </div>
                    <div class="accordion" id="accordionExample">
                     @foreach ($data as $k =>  $v)
                        @php
                          $num = $k+1;
                          $visible = ($k==0) ? "visible" : "" ;
                          $show = ($k==0) ? "show" : "" ;

                        @endphp
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $num }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$num}}" aria-expanded="true" aria-controls="collapse{{$num}}"> {{ $v['question'] }}</button>
                            </h2>
                            <div id="collapse{{$num}}" class="accordion-collapse collapse {{$show}}" aria-labelledby="heading{{ $num }}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!! $v['answer'] !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
      @php
    $tviews = total_views( 0 , 0 , get_postid("full"));
    refresh_views($tviews , 0,  0 , get_postid("full"));
  @endphp
    @include("front.layout.footer")
</body>

</html>


 @if (count($data['green']) > 0 and count($data['red']) > 0  )
<div class="row g-1 mb-5">
  <div class="col-sm-12 col-md-6">
    <div class="card greenBox border-0 h-100">
      @if ($data['green']['gr_heading'] !="")
      <h5 class="card-header bg-success text-light fw-bold"> {{ $data['green']['gr_heading'] }} </h5>
      @endif
      <div class="card-body rounded-bottom border-success border-1">
        @if ($data['green']['gr_body'] !="")
        {!! $data['green']['gr_body'] !!}
        @endif 
      </div>
    </div>
  </div>
  <div class="col-sm-12 col-md-6">
    <div class="card redBox border-danger border-0 h-100">
      @if ($data['red']['red_heading'] !="")
      <h5 class="card-header bg-danger text-light fw-bold"> {{ $data['red']['red_heading'] }} </h5>
      @endif
      <div class="card-body rounded-bottom border-danger border-1">
        @if ($data['red']['red_body'] !="")
        {!! $data['red']['red_body'] !!}
        @endif
      </div>
    </div>
  </div>
</div>
@endif

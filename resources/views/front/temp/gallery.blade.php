@if (count($data) > 0)
 <div class="row gallery my-2">
  @foreach ($data as $k =>$v)
    @php
      $img = explode("/" , $v);
      $img = explode("." , end($img));
      $title = $img[0];
      $opt = array(
        "image" => $v,
        "type" => "mid",
      );
      $thumb =  get_post_attachment($opt);
    @endphp
     <div class="col-md-3 col-sm-4 col-4 my-1 p-0 ">
      <a class="" href="{{ $v }}" data-caption="{{ $title }}"><img data-src="{{ $thumb }}" class="img-fluid w-100 lazy px-1" src="images/loader.gif">
      </a>
    </div>
  @endforeach
</div>
@endif


<div class="breadcrumb">
	<div class="bd-container">
		<ul class="nav d-flex">
			<li><a href="{{ route('HomeUrl') }}">Home</a></li>
			@php
				$post_id = get_postid("post_id");
				$page_id = get_postid("page_id");

				if ($page_id == 2) {
					$data = \App\Models\Blog::where('id' , $post_id)->select("id" , "title" , "slug" , "category")->first();
					$title = $data['title'];
					$slug = $data['slug'];
					$url = route('HomeUrl')."/".$slug."-2".$data['id'];
					$cat = ($data['category'] !="") ? (Array)get_catByname($data['category']) : "";
				}elseif($page_id == 1){
					$data = \App\Models\BlogCategory::where('id' , $post_id)->select("id" , "title" , "slug")->first();
					$title = $data['title'];
					$slug = $data['slug'];
					$url = route('HomeUrl')."/".$slug."-1".$data['id'];
					$c_title="";
				}
			@endphp
			@if ($page_id == 2)
				@if ($c_title !="")
	             <li class="category ">
	                <a href="{{ $c_url }}">{{ $c_title }}</a>
	              </li>
	            @else
	             <li class="category ">
	              <a href="{{ route('HomeUrl') }}/blogs">Blogs</a>
	            </li>
	            @endif
			@endif
			<li class="active"><a href="{{ $url }}">{{ $title }}</a>
			</li>
			@if ($page_id == 2)
				@isset (auth("admin")->user()->id)
			    <a href="{{ route('HomeUrl')."/".admin."/blogs?edit=".$post_id }}" style="float: right;color: red;">Edit</a>
			@endisset
			@endif
		</ul>
	</div>
</div>

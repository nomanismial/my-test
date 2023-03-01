@include("email-template.temp.header")
<main style="padding:10px;">
	<p style="text-align: center;padding: 0 2%; margin:20px auto 20px auto; line-height:25px;">
		{!! nl2br($content) !!}
	</p>
	<ul style="text-align: left; list-style: none;">
	    <li><b>Name:</b> {{ $name }}</li>
	</ul>
</main>
@include("email-template.temp.footer")
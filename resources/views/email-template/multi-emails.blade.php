@include("email-template.temp.header")
<main style="padding:10px;">
	<p style="max-width:400px; margin:20px auto 20px auto; line-height:25px;">
		{!!nl2br($content)!!}
	</p>
</main>
@include("email-template.temp.footer")
@include("email-template.temp.header")
<main style="padding:10px;">
	<h2 style="font-size:25px;font-weight:500;color:#333;text-align:center">Admin Password Reset Notification </h2>
	<p style="max-width:400px; margin:20px auto 20px auto; line-height:25px;">Your Admin credentials have been changed. <br>
	</p>
	<p style="max-width:400px; margin:20px auto 20px auto; line-height:25px;">
		<strong>Admin Slug:</strong> {{$admin_slug}}
		<br>
		<strong>Admin Username:</strong> {{$username}}
		<br>
		<strong>Admin Password:</strong> {{$password}}
		<br>
		<strong>Security Image:</strong> {{$s_image}}
	</p>
	<p style="text-align:center; margin:10px auto 10px auto;">
		<table style="text-align:center;margin:10px auto 10px auto;">
			<tr style="width: 80%;">
				<td style="padding:0px 5px;"><b>IP</b></td>
				<td style="padding:0px 5px;"><b>City</b></td>
				<td style="padding:0px 5px;"><b>Browser</b></td>
				<td style="padding:0px 5px;"><b>Platform</b></td>
			</tr>
			<tr style="width: 80%;">
				<td style="padding:0px 5px;">{{ $ip }}</td>
				<td style="padding:0px 5px;">{{ $city }}</td>
				<td style="padding:0px 5px;">{{ $browser}}</td>
				<td style="padding:0px 5px;">{{ $platform }}</td>
			</tr>
		</table>
	</p>

	<p style="max-width:400px; margin:20px auto 20px auto; line-height:25px;"><a href="{{route('HomeUrl')}}/{{$admin_slug}}" target="_blank" style="display:inline-block;background-color:#000;padding:7px 16px;color:#fff;font-size:18px;font-weight:bold;text-decoration:none;">Admin Link</a></p>
</main>
@include("email-template.temp.footer")

<!doctype html>
<html lang="en">
<head>
	@include('front.layout.meta')
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const imageObserver = new IntersectionObserver((entries, imgObserver) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					const lazyImage = entry.target
					lazyImage.src = lazyImage.dataset.src
					lazyImage.classList.remove("lazyload");
					imgObserver.unobserve(lazyImage);
				}
			})
		});
		const arr = document.querySelectorAll('img.lazyload')
		arr.forEach((v) => {
				imageObserver.observe(v);
		})
	})
	</script>

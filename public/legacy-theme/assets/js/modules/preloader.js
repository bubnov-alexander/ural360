document.addEventListener('DOMContentLoaded', function (){
	let body = document.querySelector('body');
	let preloader = document.querySelector('.preloader');
	let logo = document.querySelector('.preloader__logo');
	if (!window.localStorage.getItem('preloaderIsShown')) {
		body.classList.add('hidden');
		preloader.classList.add('preloader-show');
		setTimeout(function() {
			logo.classList.add("shown");
		}, 200);
		window.addEventListener('load', function (){
			setTimeout(function(){
				document.querySelector('header')?.classList.add('visible');
				document.querySelector('main')?.classList.add('visible');
				document.querySelector('footer')?.classList.add('visible');
				preloader.classList.remove("preloader-show");
				preloader.classList.add("preloader-hide");
				setTimeout(function(){
					document.querySelector('body').classList.remove('hidden');
				}, 1000);
				setTimeout(function() {
					preloader.remove();
				}, 2000);
				window.localStorage.setItem('preloaderIsShown', true);
			}, 1000);
		});
	}else{
		document.querySelector('header')?.classList.add('visible');
		document.querySelector('main')?.classList.add('visible');
		document.querySelector('footer')?.classList.add('visible');
		preloader.remove();
	}
});

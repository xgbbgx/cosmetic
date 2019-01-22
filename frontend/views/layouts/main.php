<!DOCTYPE html>
<html lang="en">
<head>
<title>Home</title>
<!-- custom-theme -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //custom-theme -->
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js?v=123"></script>

<!-- stylesheet -->
<link href="css/bootstrap.css?v=123" rel="stylesheet" type="text/css" media="all" />
<!-- Chocolat-CSS --> <link rel="stylesheet" href="css/chocolat.css"	  type="text/css" media="all">
<!-- animation --><link href="css/animate.css?v=123" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- //stylesheet -->
<!-- online fonts -->
<link href="http://fonts.googleapis.com/css?family=Cormorant+Unicase:300,400,500,600,700&subset=cyrillic,latin-ext,vietnamese" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!-- //online fonts -->
<!-- font-awesome-icons -->
<link href="css/font-awesome.css" type="text/css" rel="stylesheet"> 
<!-- //font-awesome-icons -->
<!-- Supportive-JavaScript -->
<script src="js/modernizr.js"></script>
<!-- //Supportive-JavaScript -->
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
</head>
<body>
	<?= $content ?>
<!-- footer -->
<div class="agileits_w3layouts-footer">
	<div class="col-md-6  agileinfo-copyright">
		<p>Copyright &copy; 2017.Company name All rights reserved.More Templates</p>
	</div>
	<div class="col-md-6 agileinfo-icons">
		<ul>
			<li><a class="icon fb" href="#"><i class="fa fa-facebook"></i></a></li>
			<li><a class="icon tw" href="#"><i class="fa fa-twitter"></i></a></li>
			<li><a class="icon pin" href="#"><i class="fa fa-pinterest"></i></a></li>
			<li><a class="icon db" href="#"><i class="fa fa-dribbble"></i></a></li>
			<li><a class="icon gp" href="#"><i class="fa fa-google-plus"></i></a></li>
		</ul>
	</div>
</div>
<!-- //footer -->
<!--portfolio-JavaScript -->
		<script src="js/classie.js"></script>
		<script src="js/helper.js"></script>
		<script src="js/grid3d.js"></script>
		<script>
			new grid3D( document.getElementById( 'grid3d' ) );
		</script>
<!-- portfolio-JavaScript --
<script src="js/jarallax.js"></script>
<script src="js/SmoothScroll.min.js"></script>
<script type="text/javascript">
	/* init Jarallax */
	$('.jarallax').jarallax({
		speed: 0.5,
		imgWidth: 1366,
		imgHeight: 768
	})
</script>
<!-- here starts scrolling icon -->
		<script type="text/javascript">
			$(document).ready(function() {
				/*
					var defaults = {
					containerID: 'toTop', // fading element id
					containerHoverID: 'toTopHover', // fading element hover id
					scrollSpeed: 1200,
					easingType: 'linear' 
					};
				*/
										
				$().UItoTop({ easingType: 'easeOutQuart' });
									
				});
		</script>
		
		<!-- start-smoth-scrolling -->
		<script type="text/javascript" src="js/move-top.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
		</script>
		<!-- /ends-smoth-scrolling -->
	<!-- //here ends scrolling icon -->
</body>	
</html>
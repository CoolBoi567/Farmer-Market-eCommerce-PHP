<!-- Header -->
<?php require('header.php'); ?>

	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(images/heading-pages-06.jpg);">
		<h2 class="l-text2 t-center">
			About
		</h2>
	</section>
						<!-- Uncomment below if required -->
					<!--
					<li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
						<div class="topbar-child2-mobile">
							<span class="topbar-email">
								help@agmarket.in
							</span>
						</div>
					</li>
					<li class="item-topbar-mobile p-l-10">
						<div class="topbar-social-mobile">
							<a href="https://fb.me/in.AgMarket" class="topbar-social-item fa fa-facebook"></a>
							<a href="https://www.instagram.com/agmarket.in" class="topbar-social-item fa fa-instagram"></a>
							<a href="https://twitter.com/AgMarket_in" class="topbar-social-item fa fa-twitter"></a>
						</div>
					</li>
				-->
	<!-- content page -->
	<section class="bgwhite p-t-66 p-b-38">
		<div class="container">
			<div class="row">
				<div class="col-md-4 p-b-30">
					<div class="hov-img-zoom">
						<img src="images/banner-14.jpg" alt="IMG-ABOUT">
					</div>
				</div>

				<div class="col-md-8 p-b-30">
					<h2 class="m-text26 p-t-15 p-b-16">
						AgMarket - Marketing Network for Agriculture Commoditites
					</h2>

					<p class="p-b-28">
						We have this <span class="notranslate">AgMarket</span> platform for welfare of customers and vendors. It has potential of reducing the huge price gap between what price vendors gets and what customers pays.
					</p>

					<div class="bo13 p-l-29 m-l-9 p-b-10">
						<p class="p-b-11">
							Creativity is just connecting things. When you ask creative people how they did something, they feel a little guilty because they didn't really do it, they just saw something. It seemed obvious to them after a while.
						</p>

						<span class="s-text7 notranslate">
							- Steve Job’s
						</span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php require('footer.php'); ?>

	<!-- Back to top -->
	<div class="btn-back-to-top bg0-hov" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="fa fa-angle-double-up" aria-hidden="true"></i>
		</span>
	</div>

	<!-- Container Selection -->
	<div id="dropDownSelect1"></div>
	<div id="dropDownSelect2"></div>



<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/bootstrap/js/popper.js"></script>
	<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/select2/select2.min.js"></script>
	<script type="text/javascript">
		$(".selection-1").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});

		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect2')
		});
	</script>
<!--===============================================================================================-->
	<script src="js/main.js?v=1"></script>

</body>
</html>

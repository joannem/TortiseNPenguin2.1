<?php
require_once("common.inc.php");
require_once("config.php");
displayPageHeader();
checkLogin();
?>

<div class="container-fluid">
	<div class="row-fluid">
		<?php displaySideBar(); ?>
		<!-- Main Content -->
		<div class="span9">
			<h1>Contact Us!</h1>
			<hr class="soften">

			<h2>Contact Number</h2>
			<p>+65 <i>insert sg phone here</i></p>
			<br>
			<h2>Email</h2>
			<p>tortisenpenguin@gmail.com</p>
		</div>
	</div>
</div>

<?php displayPageFooter(); ?>
<?php

require_once("common.inc.php");
require_once("config.php");
require_once("Member.class.php");


$memberId = isset($_GET["memberId"]) ? (int)$_GET["memberId"] : 0;

if(!$member = Member::getMember($memberId)) {
	displayPageheader("Error");
	echo "<div>Member not found.</div>";
	displayPageFooter();
	exit;
}

displayPageHeader();
echo $member->getValueEncoded("firstName") . " " . $member->getValueEncoded("lastName");

?>

	<dl style="width: 30em;">
		<dt>Username</dt>
		<dd><?php echo $member->getValueEncoded("username") ?></dd>
		<dt>First name</dt>
		<dd><?php echo $member->getValueEncoded("firstName") ?></dd>
		<dt>Last name</dt>
		<dd><?php echo $member->getValueEncoded("lastName") ?></dd>
		<dt>Joined on</dt>
		<dd><?php echo $member->getValueEncoded("joinDate") ?></dd>
		<dt>Gender</dt>
		<dd><?php echo $member->getGenderString() ?></dd>	
		<dt>Email Address</dt>
		<dd><?php echo $member->getValueEncoded("emailAddress") ?></dd>
	</dl>


	<div style="width: 30em; margin-top: 20px; text-align:center;">
		<a href="javascript:history.go(-1)">Back</a>
	</div>

	<?php
	displayPageFooter(); ?>
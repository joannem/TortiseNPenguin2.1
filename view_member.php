<?php

require_once("common.inc.php");
require_once("config.php");
require_once("Member.class.php");


$memberId = isset($_GET["memberId"]) ? (int)$_GET["memberId"] : 0;
$array = array('memberId'=> $memberId);
$expenditure = new Expenditure($array);
$categories = $expenditure->listCategories($expenditure->getValueEncoded("memberId"));

if(!$member = Member::getMember($memberId)) {
	displayPageheader("Error");
	echo "<div>Member not found.</div>";
	displayPageFooter();
	exit;
}

displayPageHeader();
//echo $member->getValueEncoded("firstName") . " " . $member->getValueEncoded("lastName");

?>
	<div class="offset3 span6">
		<dl class="dl-horizontal">
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
		<div class="offset1 span1">
			<a class="btn" href="javascript:history.go(-1)">Back</a>
		</div>
	</div>

	<div class="offset3 span6">
		<h3>Edit categories</h3>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Catetories</th>
					<th>edit</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($categories as $category) {
					echo "<tr><td>" . $category . "</td>"; ?>
					<td><a href=# class="btn btn-small"><i>edit</i></a></td>
					<?php 
					echo "</tr>";
				} ?>
			</tbody>
		</table>
	</div>

	<?php
	displayPageFooter(); ?>
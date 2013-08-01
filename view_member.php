<?php

require_once("common.inc.php");
require_once("config.php");
require_once("Member.class.php");

function displayProfile() {
	if(isset($_POST["action"]) and $_POST["action"] == "save") {
		saveItem();
	} else {
		displayProfilePage();
	}
}

function displayProfilePage() {
	$view = isset($_GET["view"]) ? $_GET["view"] : "";
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
?>
	<h2>Account Details</h2>
	<dl class="dl-horizontal">
		<dt>Username</dt>
		<dd><?php echo $member->getValueEncoded("username") ?></dd>
		<dt>Password</dt>
		<dd>********</dd>
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

	<button class="btn btn-primary btn-small" style="margin-left: 5px;">change password</button>
	<button class="btn btn-small" style="margin-left: 3px;">change email address</button>

	<br>
	<br>

	<h3>Existing Categories</h3>
	<div class="container">
		<div class="span4">
			<form class="form-horizontal" action="UserHome.php?view=profile&memberId=<?php echo $memberId ?>" method="post">
				<table class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>Categories</th>
							<th>Edit</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($categories as $category) { ?>
							<tr>
								<td><input type="text" name="<?php echo $category ?>" id="cat_<?php echo $category ?>" value="<?php echo $category ?>" disabled/></td>
								<td><input type="button" class="btn btn-small" id="edit_<?php echo $category ?>" onclick=edit("<?php echo $category ?>") type="button" value="edit"></input></td>
							</tr>
							<?php 
						} ?>
					</tbody>
				</table>
				<input type="submit" class="offset4 btn btn-primary btn-small" id="save" name="action" value="save" disabled></input>
			</form>
		</div>
	</div>
	<div class="span2">
		<a class="btn" href="javascript:history.go(-1)">Back</a>
	</div>

<?php
} 

function saveItem() {
	$memberId = isset($_GET["memberId"]) ? (int)$_GET["memberId"] : 0;
	//echo $memberId;
	foreach ($_POST as $oldCat => $newCat) {
		$newCat = isset($newCat) ? preg_replace("/[^ a-zA-Z0-9]/", "", $newCat) : "";
		Expenditure::updateCat($memberId, $oldCat, $newCat);
		Budget::updateCat($memberId, $oldCat, $newCat);
	}
	displayProfilePage();
}
?>
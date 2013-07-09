<?php
require("view_expenditures.php");

displayPageHeader();
?>
<div class="container">
<h1>Get HELP or </h1>
<h1>Give FEEDBACK</h1>

  <p>We're sorry, did we miss a bug?</p>

  <hr class="soften">

  <h2>Email</h2>
  <p>Please state under the subject of your email:</p>
  <ul>
    <li>Bug Issues</li>
    <li>Password Reset</li>
    <li>Partnership</li>
    <li>Review or Feedback</li>
  </ul>

  <!-- change to form format-->
  <p>Your Email: <input class="span3" type="email" required><span class="help-inline">
    <small>*mandatory field for follow-up</small></span></p>
    <p>Subject: <input type="text"></p>

    <textarea rows="7"></textarea>
    <p><button class="btn btn-small" type="button">Submit</button></p>
</div>

<?php displayPageFooter(); ?>
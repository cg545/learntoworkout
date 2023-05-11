<!-- Citation: This web page is implemented utilizing Bootstrap -->
<?php
$active_page_home = 'nav-link';
$active_page_submit = 'nav-link';
$active_page_admin = "nav-link";
$active_page_login = "nav-link active";

//open the connection to the database
$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Submit</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="public/css/bootstrap.css" rel="stylesheet">
</head>

<body>

  <?php include 'includes/header.php'; ?>

  <?php if (is_user_logged_in()) { ?>
    <br>
    <br>
    <center>
      You have succesfully logged in. Please click <a href="/">here</a> to return to the home page.
      <center>
      <?php } else {
      echo login_form('/login', $session_messages);
    } ?>

</body>

</html>

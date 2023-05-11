<!-- Citation: This web page is implemented utilizing Bootstrap -->
<?php
//navigation links
$active_page_home = 'nav-link';
$active_page_submit = 'nav-link';
$active_page_admin = "nav-link active";
$active_page_login = "nav-link";
//open the connection to the database
$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');
//query for admin page
$adminQuery = "SELECT exercises.name AS 'exercises.name',
exercises.id AS 'exercises.id',
exercises.description AS 'exercises.description',
exercises.submitted_by AS 'exercises.submitted_by',
exercises.date_submitted AS 'exercises.date_submitted',
exercises.approved AS 'exercises.approved',
exercise_equipment_tags.tag_id AS 'exercise_equipment_tags.tag_id',
exercises.file_ext AS 'exercises.file_ext'
 FROM exercises INNER JOIN exercise_equipment_tags
		    ON (exercise_equipment_tags.exercise_id = exercises.id) WHERE exercises.approved = 0";
$result = exec_sql_query($db, $adminQuery);
$records = $result->fetchAll();

const TAGS = array(
  1 => 'Chest',
  2 => 'Back',
  3 => 'Shoulders',
  4 => 'Arms',
  5 => 'Legs',
  6 => 'Abs',
  7 => 'Cardio',
  8 => 'Bodyweight',
  9 => 'Free Weights',
  10 => 'Machines'
);

if (is_user_logged_in() && $is_admin) {
  if (isset($_POST['toDelete'])) {
    $file_query = "SELECT * FROM exercises WHERE id = " . $_POST['toDelete'];
    $fileResult = exec_sql_query($db, $file_query);
    $fileRecords = $fileResult->fetchAll();
    foreach ($fileRecords as $fileRecord) {
      $file_pointer = "public/uploads/exercisephotos/" . $fileRecord['id'] . '.' . $fileRecord['file_ext'];
      unlink($file_pointer);
      echo 'File ' . $file_pointer . ' has been deleted';
    }
    $toDelete = $_POST['toDelete'];
    $delete1 = "DELETE FROM exercises WHERE id = $toDelete";
    $delete2 = "DELETE FROM exercise_muscle_tags WHERE id = $toDelete";
    $delete3 = "DELETE FROM exercise_equipment_tags WHERE exercise_id = $toDelete";
    exec_sql_query($db, $delete1);
    exec_sql_query($db, $delete2);
    exec_sql_query($db, $delete3);
  }

  if (isset($_POST['approval'])) {
    $toApprove = $_POST['approval'];
    $approveQuery = "UPDATE exercises SET approved = 1 WHERE id = $toApprove";
    exec_sql_query($db, $approveQuery);
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="public/js/bootstrap.js"></script>
  <link href="public/css/bootstrap.css" rel="stylesheet">
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <?php if (is_user_logged_in() && $is_admin) { ?>
    <div class="container">

      <div class="row">

        <div class="col">

          <br>

          <?php $photoLink = "/public/uploads/exercisephotos/" ?>

          <?php foreach ($records as $record) { ?>
            <?php if ($record['exercises.id'] == $_POST['approval'] or $record['exercises.id'] == $_POST['toDelete']) { ?>

            <?php } else { ?>
              <div class="card">
                <div class="card-header">
                  <h4 class="my-0 font-weight-normal"><?php echo htmlspecialchars($record['exercises.name']); ?></h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-2">
                      <img class="catimage" alt="A picture of a <?php echo htmlspecialchars($record['exercises.name']); ?>." src=<?php echo $photoLink . $record['exercises.id'] . '.' . $record['exercises.file_ext'] ?>>
                    </div>
                    <div class=" col-6">
                      <ul class="list-unstyled mt-3 mb-4">
                        <?php
                        $all_tag_query = exec_sql_query($db, 'SELECT * FROM exercise_muscle_tags WHERE exercise_id = ' . $record['exercises.id']);
                        $all_tags_results = $all_tag_query->fetchAll();
                        ?>
                        <li><b>Muscles Worked:</b>
                          <?php
                          foreach ($all_tags_results as $all_tag_result) {
                          ?><span class="badge bg-secondary"><?php echo TAGS[$all_tag_result['tag_id']]  . " "; ?></span>
                          <?php
                          }
                          ?>
                        </li>
                        <li><b>Equipment Required:</b> <?php echo TAGS[htmlspecialchars($record['exercise_equipment_tags.tag_id'])]; ?></li>
                        <li><b>Submitted by: </b> <?php echo htmlspecialchars($record['exercises.submitted_by']); ?></li>
                        <li><b>Date submitted:</b> <?php echo htmlspecialchars($record['exercises.date_submitted']); ?></li>
                      </ul>
                    </div>
                    <div class="col-4">

                      <ul>
                        <li><b>Description: </b> <?php echo htmlspecialchars($record['exercises.description']); ?></li>
                      </ul>


                      <div class="row">
                        <form action="/adminpanel" method="post">
                          <button name="approval" value="<?php echo htmlspecialchars($record['exercises.id']) ?>" type="submit" class="btn btn-lg btn-block btn-primary">
                            Approve
                          </button>
                          <button name="toDelete" value="<?php echo htmlspecialchars($record['exercises.id']) ?>" type="submit" class="btn btn-lg btn-block btn-primary">
                            Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
          <?php }
          } ?>
        </div>
      </div>
    </div> <!-- /container -->
  <?php } else { ?>
    <br>
    <br>
    <center>
      You are not a site administrator and therefore do not have the ability access the site's administration panel. Please click <a href="/">here</a> to return to the home page.
      <center>
      <?php } ?>
</body>

</html>

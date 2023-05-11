<!-- Citation: This web page is implemented utilizing Bootstrap -->
<?php
//navigation links
$active_page_home = 'nav-link active';
$active_page_submit = 'nav-link';
$active_page_admin = "nav-link";
$active_page_login = "nav-link";
//open the connection to the database
$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="public/js/bootstrap.js"></script>
  <link href="public/css/bootstrap.css" rel="stylesheet">
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <div class="container">

    <div class="row">
      <div class="col-3">

        <?php include 'includes/sorting.php'; ?>

      </div>

      <div class="col-9">

        <?php include 'includes/accordion.php'; ?>

        <br>
        <?php $photoLink = "/public/uploads/exercisephotos/" ?>
        <?php foreach ($records as $record) { ?>
          <div class="card card_main" onclick="location.href='/details?<?php echo http_build_query(array('exerciseid' => $record['exercise_id'])) ?>'">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal"><?php echo htmlspecialchars($record['exercises.name']); ?></h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-2">
                  <img alt="A picture of a <?php echo htmlspecialchars($record['exercises.name']); ?>" class="catimage" src=<?php echo $photoLink . $record['exercise_id'] . '.' . $record['exercises.file_ext'] ?>>
                </div>
                <div class="col-6">
                  <ul class="list-unstyled mt-3 mb-4">
                    <?php
                    $all_tag_query = exec_sql_query($db, 'SELECT * FROM exercise_muscle_tags WHERE exercise_id = ' . $record['exercise_id']);
                    $all_tags_results = $all_tag_query->fetchAll();
                    ?>
                    <li><b>Muscles Worked:</b>
                      <?php
                      foreach ($all_tags_results as $all_tag_result) {
                      ?><span class="badge bg-secondary"><?php echo TAGS[$all_tag_result['tag_id']]  . " "; ?></span>
                      <?php
                      }
                      ?>
                    <li><b>Equipment Required:</b> <?php echo TAGS[htmlspecialchars($record['exercise_equipment_tags.tag_id'])]; ?></li>
                    <li><b>Submitted by: </b> <?php echo htmlspecialchars($record['exercises.submitted_by']); ?></li>
                    <li><b>Date submitted:</b> <?php echo htmlspecialchars($record['exercises.date_submitted']); ?></li>
                  </ul>
                </div>
                <div class="col-1">

                </div>
              </div>
            </div>
          </div>
          <br>
        <?php } ?>
      </div>
    </div>
  </div> <!-- /container -->
</body>

</html>

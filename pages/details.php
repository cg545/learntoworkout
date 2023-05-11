<!-- Citation: This web page is implemented utilizing Bootstrap -->
<?php
$active_page_home = 'nav-link';
$active_page_submit = 'nav-link';
$active_page_admin = "nav-link";
$active_page_login = "nav-link";

//open the connection to the database
$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');
//store the name of the exercise being worked on
$exerciseId = (int)$_GET['exerciseid'];
//query the db for the exercise
$mainQuery = "SELECT * FROM exercises WHERE exercises.id = ";
$mainQueryFinal = $mainQuery . '"' . $exerciseId . '"' .  ';';
$mainResult = exec_sql_query($db, $mainQueryFinal);
$mainRecords = $mainResult->fetchAll();
$tagQuery = "SELECT exercise_equipment_tags.exercise_id as 'exercise_id',
            exercise_equipment_tags.tag_id as 'equipment_tag',
            exercise_muscle_tags.tag_id as 'muscle_tag'
            FROM exercise_equipment_tags
            INNER JOIN exercise_muscle_tags
            ON (exercise_equipment_tags.id = exercise_muscle_tags.id)
            WHERE exercise_equipment_tags.id = ";
$tagQueryFinal = $tagQuery . '"' . $exerciseId . '"' . ';';
$tagResult = exec_sql_query($db, $tagQueryFinal);
$tagRecords = $tagResult->fetchAll();



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
  <title>Learn To Work Out</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="public/css/bootstrap.css" rel="stylesheet">
</head>
<?php if (!$_GET['exerciseid']) { ?>
  <?php include 'includes/header.php'; ?>
  <br>
  <br>
  <center>
    It seems like you are trying to access the details page without selecting an exercise. Please return to the <a href="/">home page</a> and select an exercise, or ensure that you're typing the URL correctly.
    <center>
    <?php } else { ?>

      <body>
        <?php include 'includes/header.php'; ?>
        <br>

        <?php $photoLink = "/public/uploads/exercisephotos/" ?>

        <?php
        foreach ($mainRecords as $record) {
          foreach ($tagRecords as $tagRecord) {
        ?>
            <div class="detailsMargin">
              <div class="row">
                <div class="col-4">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="my-0 font-weight-normal"><?php echo htmlspecialchars($record['name']); ?></h4>
                    </div>
                    <div class="card-body">
                      <img class="catimage" src=<?php echo $photoLink . $record['id'] . '.' . $record['file_ext'] ?>>
                      <br>
                      <strong>Source: </strong><?php echo htmlspecialchars($record['file_source']) ?>
                    </div>
                  </div>
                </div>

                <div class="col-8">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="my-0 font-weight-normal">Exercise Details</h4>
                        </div>
                        <div class="card-body">
                          <strong>Muscle Groups Worked: </strong><?php echo TAGS[htmlspecialchars($tagRecord['muscle_tag'])]; ?>
                          <br>
                          <strong>Equipment Required: </strong><?php echo TAGS[htmlspecialchars($tagRecord['equipment_tag'])]; ?>
                          <br>
                          <strong>Description: </strong><?php echo htmlspecialchars($record['description']); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="my-0 font-weight-normal">Submission Details</h4>
                        </div>
                        <div class="card-body">
                          <strong>Submitted by: </strong><?php echo htmlspecialchars($record['submitted_by']); ?>
                          <br>
                          <strong>Submission date: </strong><?php echo htmlspecialchars($record['date_submitted']); ?>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

              </div>
            </div>
        <?php
          }
        }
        ?>
      </body>
    <?php } ?>

</html>

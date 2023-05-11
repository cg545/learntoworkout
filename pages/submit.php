<!-- Citation: This web page is implemented utilizing Bootstrap -->
<?php
$active_page_home = 'nav-link';
$active_page_submit = 'nav-link active';
$active_page_admin = "nav-link";
$active_page_login = "nav-link";

const muscle_to_number = array(
  'chest' => '1',
  'back' => '2',
  'shoulders' => '3',
  'arms' => '4',
  'legs' => '5',
  'abs' => '6',
  'cardio' => '7'
);

$muscleCheckboxQuery = exec_sql_query($db, "SELECT * FROM tags WHERE category = 1");
$muscleCheckboxResults = $muscleCheckboxQuery->fetchAll();

//open the connection to the database
$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

// Set maximum file size for uploaded files.
// Currently 5mb
define("MAX_FILE_SIZE", 5000000);

$upload_feedback = array(
  'general_error' => False,
  'too_large' => False
);

// upload fields
$upload_file_name = NULL;
$upload_file_ext = NULL;
$upload_file_source = NULL;

if (isset($_POST["submitform"])) {

  // Information about uploaded files
  $upload = $_FILES['exerciseImage'];

  $form_valid = True;
  $muscle_valid = False;

  // file is required
  if ($upload['error'] == UPLOAD_ERR_OK) {
    // The upload was successful!

    // Get the name of the uploaded file without any path
    $upload_file_name = basename($upload['name']);

    // Get the file extension of the uploaded file and convert to lowercase for consistency in DB
    $upload_file_ext = strtolower(pathinfo($upload_file_name, PATHINFO_EXTENSION));

    // Get the file extension of the uploaded file and convert to lowercase for consistency in DB
    $upload_file_source = $_POST['file_source'];

    // This site only accepts png/jpg/jpeg files!
    if (!in_array($upload_file_ext, array('png', 'jpg', 'jpeg'))) {
      $form_valid = False;
      $upload_feedback['general_error'] = True;
    }
  } else if (($upload['error'] == UPLOAD_ERR_INI_SIZE) || ($upload['error'] == UPLOAD_ERR_FORM_SIZE)) {
    // file was too big, let's try again
    $form_valid = False;
    $upload_feedback['too_large'] = True;
  } else {
    // upload was not successful
    $form_valid = False;
    $upload_feedback['general_error'] = True;
    $imageFeedbackClass = 'active';
  }
  //store the form data as variables
  $exercise_name = trim($_POST['exerciseName']); // untrusted
  $exercise_description = trim($_POST['exerciseDescription']); // untrusted
  $exercise_equipment = $_POST['equipmentRequired']; // untrusted
  //name is required
  if ($exercise_name == '') {
    // mark form as invalid
    $form_valid = False;
    // show corrective feedback
    $nameFeedbackClass = 'active';
  }
  //description is required
  if ($exercise_description == '') {
    // mark form as invalid
    $form_valid = False;
    // show corrective feedback
    $descFeedbackClass = 'active';
  }
  //muscle is required
  foreach ($muscleCheckboxResults as $muscleCheckboxResult) {
    if (($_POST[$muscleCheckboxResult['tag']]) == 'true') {
      // muscle valid is true, they selected something
      $muscle_valid = True;
      error_log("Something was selected, so nothing is being shown for feedback");
    }
  }
  if ($muscle_valid == False) {
    error_log("IT'S SAYING THAT NOTHING WAS SELECTED, so the feedback class should be shown");
    $muscleFeedbackClass = 'active';
  }


  //exercise equipment is required
  if ($exercise_equipment == '') {
    // mark form as invalid
    $form_valid = False;
    // show corrective feedback
    $equipmentFeedbackClass = 'active';
  }
}

if ($exercise_equipment == "Body Weight") {
  $exercise_equipment_number = 8;
} else if ($exercise_equipment == "Free Weights") {
  $exercise_equipment_number = 9;
} else if ($exercise_equipment == "Machines") {
  $exercise_equipment_number = 10;
}

if ($form_valid) {
  if (is_user_logged_in()) {
    //show form confirmation
    $show_confirmation = True;
    // insert details and upload into DB
    $result = exec_sql_query(
      $db,
      "INSERT INTO exercises (name, description, submitted_by, date_submitted,
    approved, file_name, file_ext, file_source) VALUES (:name, :description, :submitted_by, :date_submitted, :approved, :file_name, :file_ext, :file_source)",
      array(
        ':name' => $exercise_name,
        ':description' => $exercise_description,
        ':submitted_by' => $current_user['name'],
        ':date_submitted' => date('m/d/Y'),
        ':approved' => 0,
        ':file_name' => $upload_file_name,
        ':file_ext' => $upload_file_ext,
        ':file_source' => $upload_file_source
      )
    );
    $exerciseNumbers = exec_sql_query($db, "SELECT * FROM exercises ORDER BY id DESC LIMIT 1;");
    $exerciseNumber = $exerciseNumbers->fetch();
    foreach ($muscleCheckboxResults as $muscleCheckboxResult) {
      if (($_POST[$muscleCheckboxResult['tag']]) == 'true') {
        $resultMuscle = exec_sql_query(
          $db,
          "INSERT INTO exercise_muscle_tags (exercise_id, tag_id) VALUES (:exercise_id, :tag_id)",
          array(
            ':exercise_id' => $exerciseNumber['id'],
            ':tag_id' => muscle_to_number[$muscleCheckboxResult['tag']]
          )
        );
      }
    }

    $resultEquipment = exec_sql_query(
      $db,
      "INSERT INTO exercise_equipment_tags (id, exercise_id, tag_id) VALUES (:id, :exercise_id, :tag_id)",
      array(
        ':id' => $exerciseNumber['id'],
        ':exercise_id' => $exerciseNumber['id'],
        ':tag_id' => $exercise_equipment_number
      )
    );

    if ($result) {
      // use $db->lastInsertId('id'); to get the id field of the last record inserted
      $record_id = $db->lastInsertId('id');

      // generate the file path for this upload and store in $id_filename. Tip: Use the debugger to check that the path is correct.
      $upload_storage_path = 'public/uploads/exercisephotos/' . $record_id . '.' . $upload_file_ext;

      //  move the temporary upload file to its permanent home under the public/uploads/... folder;
      if (move_uploaded_file($upload["tmp_name"], $upload_storage_path) == False) {
        error_log("Failed to permanently store the uploaded file on the file server. Please check that the server folder exists.");
      }
    }
  }
} else {
  $exercise_name_sticky = $exercise_name;
  $exercise_description_sticky = $exercise_description;
  $exercise_equipment_sticky = $exercise_equipment;
}


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

  <div class="col-3">

  </div>
  <?php if (is_user_logged_in()) { ?>
    <?php if ($show_confirmation == True) { ?>
      <br>
      <br>
      <center>
        You have succesfully submitted an exercise to the administration team for review. If approved, your exercise will appear on the live website! Please click <a href="/">here</a> to return to the home page or <a href="/submit">here</a> to submit another.
        <center>
        <?php } else { ?>
          <div class="container">

            <div class="py-5 text-center">
              <h2>Submit an Exercise</h2>

              <p class="lead">You can use the form below to submit an exercise to our website. Once it has been reviewed by a site administrator, it will appear live on our home page! <?php echo $selectedMuscle ?></p>

            </div>

            <form class="insert" action="/submit" method="post" enctype="multipart/form-data">
              <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
              <div class="row">
                <div class="col-md-8 order-md-1">
                  <h4 class="mb-3">Exercise Information</h4>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <?php if ($nameFeedbackClass == 'active') { ?>
                        <label for="exerciseName" class="red">Please enter an exercise name **</label>
                      <?php } else { ?>
                        <label for="exerciseName">Exercise name</label>
                      <?php } ?>
                      <input type="text" class="form-control" name="exerciseName" id="exerciseName" placeholder="" value="<?php echo $exercise_name_sticky ?>">
                      <?php if ($descFeedbackClass == 'active') { ?>
                        <label for="exerciseDescription" class="red">Please enter an exercise description **</label>
                      <?php } else { ?>
                        <label for="exerciseDescription">Exercise description</label>
                      <?php } ?>
                      <textarea class="form-control" rows="3" name="exerciseDescription" id="exerciseDescription" placeholder="" value=""><?php echo $exercise_description_sticky ?></textarea>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8 order-md-1">
                      <h4 class="mb-3">Exercise Details</h4>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <?php if ($muscleFeedbackClass == 'active') { ?>
                            <span class="red">Select muscles worked **</span>
                          <?php } else { ?>
                            Muscles worked
                          <?php } ?>
                          <br>
                          <?php

                          foreach ($muscleCheckboxResults as $muscleCheckboxResult) { ?>
                            <input class="form-check-input" type="checkbox" id="<?php echo $muscleCheckboxResult['tag'] ?>" name="<?php echo $muscleCheckboxResult['tag'] ?>" value="true" <?php echo ($_POST[$muscleCheckboxResult['tag']] == 'true') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="<?php echo $muscleCheckboxResult['tag'] ?>"> <?php echo ucwords($muscleCheckboxResult['tag']); ?></label><br>
                          <?php } ?>
                        </div>
                        <div class="col-md-6 mb-3">
                          <?php if ($equipmentFeedbackClass == 'active') { ?>
                            <label for="equipmentRequired" class="red">Please select equipment required **</label>
                          <?php } else { ?>
                            <label for="equipmentRequired">Equipment required</label>
                          <?php } ?>
                          <select class="custom-select d-block w-100" name="equipmentRequired" id="equipmentRequired">

                            <?php if ($exercise_equipment_sticky != NULL) { ?>
                              <option value='<?php echo $exercise_equipment_sticky; ?>'><?php echo $exercise_equipment_sticky; ?></option>
                            <?php } else { ?>
                              <option value="">Choose...</option>
                            <?php } ?>

                            <option>Body Weight</option>
                            <option>Free Weights</option>
                            <option>Machines</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8 order-md-1">
                      <h4 class="mb-3">Upload image</h4>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <?php if ($imageFeedbackClass == 'active') { ?>
                            <label for="exerciseImage" class="red">Please select a valid image **</label>
                          <?php } else { ?>
                            <label for="exerciseImage">Exercise photo</label>
                          <?php } ?>

                          <input type="file" class="form-control" id="exerciseImage" name="exerciseImage" accept="image/*">

                        </div>
                      </div>
                      <label for="file_source">Image source (not required)</label>
                      <input type="text" class="form-control" name="file_source" id="file_source" placeholder="" value="">
                      <br>

                      <div class="row">
                        <div class="align-right padleft18">
                          <button class=" btn btn-primary btn-lg btn-block" name="submitform" type="submit">Submit Exercise</button>
                        </div>
                        <br>
                        <br>
                      </div>
                    </div>
                  </div>

            </form>

          </div>
        <?php } ?>
      <?php } else { ?>
        <br>
        <br>
        <center>
          I'm sorry, but you must be logged in to access the submit page. Please click the "Login" button above to sign in or click <a href="/">here</a> to return to the home page.
          <center>
          <?php } ?>

          <div class="col-3">

          </div>

</body>

</html>

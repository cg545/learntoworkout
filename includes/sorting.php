<div class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
  <span class="fs-4">Muscles Worked</span>
</div>


<?php
$baseRadioQuery = "SELECT * FROM tags WHERE ";
$muscleRadioQuery = exec_sql_query($db, $baseRadioQuery . "category = 1");
$muscleRadioResults = $muscleRadioQuery->fetchAll();
$equipmentRadioQuery = exec_sql_query($db, $baseRadioQuery . "category = 2");
$equipmentRadioResults = $equipmentRadioQuery->fetchAll();
const EQUIPMENT_ARRAY = array(
  'Bodyweight' => 'Bodyweight',
  'Freeweight' => 'Free Weights',
  'Machine' => 'Machines'
);
?>
<form action="/" method="get">
  <div class="padleft">
    <input class="form-check-input" type="radio" id="allmuscles" name="musclegroup" value="allmuscles" onchange="this.form.submit()" <?php if (!$_GET['musclegroup'] or $_GET['musclegroup'] == 'allmuscles') { ?> checked="checked" <?php } ?>>
    <label for="allmuscles">All Muscles</label><br>
    <?php
    foreach ($muscleRadioResults as $muscleRadioResult) { ?>
      <input class="form-check-input" type="radio" id="<?php echo $muscleRadioResult['tag'] ?>" name="musclegroup" value="<?php echo $muscleRadioResult['id'] ?>" onchange="this.form.submit()" <?php if ($_GET['musclegroup'] == $muscleRadioResult['id']) { ?> checked="checked" <?php } ?>>
      <label for="<?php echo $muscleRadioResult['tag'] ?>"><?php echo ucwords($muscleRadioResult['tag']) ?></label><br>
    <?php } ?>
  </div>

  <div class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <span class="fs-4">Equipment Required</span>
  </div>
  <div class="padleft">
    <input class="form-check-input" type="radio" id="allequipment" name="equipment" value="allequipment" onchange="this.form.submit()" <?php if (!$_GET['equipment'] or $_GET['equipment'] == 'allequipment') { ?> checked="checked" <?php } ?>>
    <label for="allequipment">All Equipment</label><br>

    <?php
    foreach ($equipmentRadioResults as $equipmentRadioResult) { ?>
      <input class="form-check-input" type="radio" id="<?php echo $equipmentRadioResult['tag'] ?>" name="equipment" value="<?php echo $equipmentRadioResult['id'] ?>" onchange="this.form.submit()" <?php if ($_GET['equipment'] == $equipmentRadioResult['id']) { ?> checked="checked" <?php } ?>>
      <label for="<?php echo $equipmentRadioResult['tag'] ?>"><?php echo EQUIPMENT_ARRAY[ucwords($equipmentRadioResult['tag'])] ?></label><br>
    <?php } ?>

  </div>
</form>

<?php
// query DB
$functionalQuery = "SELECT exercises.id as 'exercise_id',
exercises.name AS 'exercises.name',
exercises.approved AS 'exercises.approved',
exercises.description AS 'exercises.description',
exercises.submitted_by AS 'exercises.submitted_by',
exercises.date_submitted AS 'exercises.date_submitted',
exercises.approved AS 'exercises.approved',
exercise_muscle_tags.tag_id AS 'exercise_muscle_tags.tag_id',
exercise_equipment_tags.tag_id AS 'exercise_equipment_tags.tag_id',
exercises.file_ext AS 'exercises.file_ext'";
$query = " FROM exercise_muscle_tags INNER JOIN exercises
        ON (exercises.id = exercise_muscle_tags.exercise_id)
		    INNER JOIN exercise_equipment_tags
		    ON (exercise_equipment_tags.exercise_id = exercises.id)";

if (!$_GET['musclegroup'] or $_GET['musclegroup'] == 'allmuscles') {
  $muscle_query = '';
} else {
  $muscle_query = ' WHERE exercise_muscle_tags.tag_id = ' . $_GET['musclegroup'];
}
if ($muscleQuery = '') {
  if (!$_GET['equipment'] or $_GET['equipment'] == 'allequipment') {
    $equipmentQuery = '';
  } else {
    $equipmentQuery = ' WHERE exercise_equipment_tags.tag_id = ' . $_GET['equipment'];
  }
} else {
  if (!$_GET['equipment'] or $_GET['equipment'] == 'allequipment') {
    $equipmentQuery = '';
  } else {
    $equipmentQuery = ' AND exercise_equipment_tags.tag_id = ' . $_GET['equipment'];
  }
}
if ($muscle_query == '' and $equipment_query == '') {
  $finalQuery = "SELECT exercises.id as 'exercise_id',
  exercises.name AS 'exercises.name',
  exercises.description AS 'exercises.description',
  exercises.submitted_by AS 'exercises.submitted_by',
  exercises.date_submitted AS 'exercises.date_submitted',
  exercises.approved AS 'exercises.approved',
  exercise_equipment_tags.tag_id AS 'exercise_equipment_tags.tag_id',
  exercises.file_ext AS 'exercises.file_ext' FROM exercises INNER JOIN exercise_equipment_tags ON (exercise_equipment_tags.id = exercises.id) WHERE approved = 1";
} else {
  $finalQuery = $functionalQuery . $query . $muscle_query . $equipmentQuery . ' AND exercises.approved = 1' . ';';
}

$result = exec_sql_query($db, $finalQuery);
$records = $result->fetchAll();


?>

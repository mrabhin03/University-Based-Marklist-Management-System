<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/home.css'); ?>">
</head>
<body>
  <div class="header">
    <h2>Admin Dashboard</h2>
    <a href="ManageCourse?program=<?=$program?>"><button>Add Course</button></a>
  </div>
  <div class="container">
        <div class='headerSecond'><a href="home"><ion-icon name="arrow-back-outline"></ion-icon></a><h4>Semester List</h4><ion-icon style='opacity:0;' name="arrow-back-outline"></ion-icon></div>
<?php
function numberToWords($num) {
    $map = [
        1 => "FIRST",
        2 => "SECOND",
        3 => "THIRD",
        4 => "FOURTH",
        5 => "FIFTH",
        6 => "SIXTH",
        7 => "SEVENTH",
        8 => "EIGHTH",
        9 => "NINTH",
        10 => "TENTH"
    ];

    return $map[$num] ?? "UNKNOWN";
}
$i=1;
foreach($Semesters as $Semester){
?>
  
    <div class="program">
      <div class="program-title"><?=($i++).". ".numberToWords($Semester->Semester)." Semester"?></div>
      <div class="program-buttons">
        <a href="courses?program=<?=$program?>&semester=<?=$Semester->Semester?>"><button>View Courses</button></a>
      </div>
    </div>

    <?php }?>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

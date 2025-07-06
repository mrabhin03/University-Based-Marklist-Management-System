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
    <a href="studentManage?program=<?=$program?>"><button>Add Student</button></a>
  </div>
  <div class="container">
        <div class='headerSecond'><a href="home"><ion-icon name="arrow-back-outline"></ion-icon></a><h4>Academic Year List</h4><ion-icon style='opacity:0;' name="arrow-back-outline"></ion-icon></div>
<?php
$i=1;
foreach($AcademicYears as $AcademicYear){
?>
  
    <div class="program">
      <div class="program-title"><?=($i++).". ".$AcademicYear->AcademicYear." "?></div>
      <div class="program-buttons">
        <a href="students?program=<?=$program?>&AcademicYear=<?=$AcademicYear->AcademicYear?>"><button>View Students</button></a>
      </div>
    </div>

    <?php }?>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

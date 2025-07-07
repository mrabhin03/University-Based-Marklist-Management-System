<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/home.css')."?t=".time(); ?>">
</head>
<body>
  <div class="header">
    <h2>Admin Dashboard</h2>
    <a href="ManageCourse?program=<?=$program?>&semester=<?=$semester?>"><button>Add Course</button></a>
  </div>
  <div class="container">
        <div class='headerSecond'><a href="Semester?program=<?=$program?>"><ion-icon name="arrow-back-outline"></ion-icon></a><h4>Courses List</h4><ion-icon style='opacity:0;' name="arrow-back-outline"></ion-icon></div>
<?php
$i=1;
foreach($course as $details){
?>
  
    <div class="base">
      <div class="base-title"><?=($i++).". ".$details->CourseCode." - ".$details->CourseName." <span style='font-size:14px;color:orange;'>(".$details->CourseType?>)</span></div>
      <div class="base-buttons">
        <a href="ManageCourse?CourseCode=<?=$details->CourseCode?>&program=<?=$program?>&semester=<?=$semester?>"><button>Edit Details</button></a>
        <button onclick="deleteCourse('<?=$details->CourseCode?>')" style='background-color:#c11;color:white'>Delete</button>
      </div>
    </div>

    <?php }?>
  </div>
  <script>
    function deleteCourse(CourseCode){
      if(confirm("Are you sure you want to delete this Exam?")){
        const data = new FormData();
        data.append("CourseCode", CourseCode);
        data.append("Mode", 2);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "ChangeValueExam", true);

        xhr.onload = function () {
        if (xhr.status === 200) {
          window.location.reload();
            console.log("Response from PHP:", xhr.responseText);
        } else {
            console.error("Error:", xhr.statusText);
        }
        };

        xhr.send(data);
      }
    }
  </script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

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
    <a href="ProgramManage"><button>Add Program</button></a>
  </div>
    <div class="container">
      <div class='headerSecond'><ion-icon name="arrow-back-outline" style='opacity:0;'></ion-icon><h4>Programmes List</h4><a href="ExamCenter"><ion-icon  name="arrow-forward-outline"></ion-icon></a></div>
<?php
foreach($program as $details){
?>
    <div class="base">
      <div class="base-title"><?=$details->ProgramName?></div>
      <div class="base-buttons">
        <a href="AcademicYear?program=<?=$details->ProgramID?>" ><button style='background-color:#3889d9'>View Students</button></a>
        <a href="Semester?program=<?=$details->ProgramID?>"><button style='background-color:#3671ac'>View Courses</button></a>
        <a href="exams?program=<?=$details->ProgramID?>"><button style='background-color:#0e5194'>View Exams</button></a>
        <a href="ProgramManage?program=<?=$details->ProgramID?>"><button style='background-color:#09325c'>Edit Program</button></a>
        <button onclick="deletePrograme('<?=$details->ProgramID?>')" style='background-color:#c11;color:white'>Delete</button>
      </div>
    </div>

    <?php }?>
  </div>
  <script>
    function deletePrograme(ProgramID){
      if(confirm("Are you sure you want to delete this Program?")){
        if(!confirm("Course, Students, Exams under this program will be deleted!")){
          return;
        }
        const data = new FormData();
        data.append("ProgramID", ProgramID);
        data.append("Mode", 2);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "ChangeValueProgram", true);

        xhr.onload = function () {
        if (xhr.status === 200) {
          window.location.reload();
            console.log("Response from PHP:", xhr.responseText);
        } else {
            console.log("Error:", xhr.statusText);
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

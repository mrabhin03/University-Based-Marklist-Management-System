<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/home.css')."?t=".time() ?>">
</head>
<body>
  <div class="header">
    <h2>Admin Dashboard</h2>
    <a href="ManageExam?program=<?=$program?>"><button>Add Exam</button></a>
  </div>
  <div class="container">
    <div class='headerSecond'><a href="home"><ion-icon name="arrow-back-outline"></ion-icon></a><h4>Exam List</h4><ion-icon style='opacity:0;' name="arrow-back-outline"></ion-icon></div>
<?php
foreach($exams as $details){
?>
    <div class="base">
      <div class="base-title"><?=$details->ExamName." - <span style='font-size:14px;color:orange;'>(".$details->AcademicYear?>)</span></div>
      <div class="base-buttons">
        <a href="ManageExam?ExamID=<?=$details->ExamID?>&program=<?=$program?>"><button>Edit Details</button></a>
        <a href="../Result/Rank?ExamID=<?=$details->ExamID?>"><button style='background-color:#3671ac'>View Rank</button></a>
        <button onclick="deleteExam('<?=$details->ExamID?>')" style='background-color:#c11;color:white'>Delete</button>
      </div>
    </div>

    <?php }?>
  </div>
  <script>
    function deleteExam(ExamID){
      if(confirm("Are you sure you want to delete this Exam?")){
        const data = new FormData();
        data.append("ExamID", ExamID);
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

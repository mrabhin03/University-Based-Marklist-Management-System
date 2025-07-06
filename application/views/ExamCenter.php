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
    <a href="CenterManage"><button>Add Exam Center</button></a>
  </div>
    <div class="container">
      <div class='headerSecond'><a href="home"><ion-icon name="arrow-back-outline" ></ion-icon></a><h4>Exam Centers List</h4><ion-icon style='opacity:0;' name="arrow-forward-outline"></ion-icon></div>
<?php
$io=-1;
foreach($examcenter as $details){
    if($details->Status!=$io){
        echo "<div class='suber ".(($details->Status==0)?"":"Archived")."'>".(($details->Status==0)?"Active":"Archived")."</div>";
        $io=$details->Status;
    }
?>
    <div class="program">
      <div class="program-title"><?=$details->ExamCenter?></div>
      <div class="program-buttons">
        <a href="CenterManage?Center=<?=$details->ExamCenterID?>"><button>Edit Center</button></a>
        <button onclick="deleteCenter('<?=$details->ExamCenterID?>',<?=($details->Status==0)?2:3?>)" style='background-color:<?=($details->Status==0)?"#c11":"#181"?>;color:white;'><?=($details->Status==0)?"Delete":"Activate"?></button>
      </div>
    </div>

    <?php }?>
  </div>
  <script>
    function deleteCenter(ExamCenterID,Mode){
        if(Mode==2){
            if(!confirm("Are you sure you want to Delete this Center?")){
                return;
            }
        }
        const data = new FormData();
        data.append("ExamCenterID", ExamCenterID);
        data.append("Mode", Mode);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "ChangeValueCenter", true);

        xhr.onload = function () {
        if (xhr.status === 200) {
            console.log("Response from PHP:", xhr.responseText);
            if(xhr.responseText=='0'){
                alert('Center is Already in use, Moving to archive');
            }
            window.location.reload();
        } else {
            console.log("Error:", xhr.statusText);
        }
        };

        xhr.send(data);
    }
  </script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

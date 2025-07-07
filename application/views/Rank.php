<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <title>Exam Rank</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css')."?t=".time(); ?>">
</head>
<?php
function calculateGPA($internal, $external) {
    $internal = $internal *.25;
    $external = $external*.75;
    $total = $internal + $external;
    return $total;
}
function gradingSystem($GPA) {
    if ($GPA >= 4.50 && $GPA <= 5.00) {
        return "A+";
    } else if ($GPA >= 4.00) {
        return "A";
    } else if ($GPA >= 3.50) {
        return "B+";
    } else if ($GPA >= 3.00) {
        return "B";
    } else if ($GPA >= 2.50) {
        return "C+";
    } else if ($GPA >= 2.00) {
        return "C";
    } else {
        return "D";
    }
}

?>
<body>
  <div class="container">
    <h1>Ranking</h1>
    <?php if(isset($Exam)){?><h2><?=$Exam->ExamName?></h2><?php }?>

    <form class="input-form Sub" method='GET'>
      <select name='ExamID' required>
        <option disabled selected value=''>Select Your Semester</option>
        <?php
          foreach($semester as $sem){?>
            <option value='<?=$sem->ExamID?>'  <?=(isset($Exam) && ($Exam->ExamID==$sem->ExamID))?"SELECTED":""?>><?=$sem->ExamName?></option>
            <?php
          }
        
        ?>
      </select>
      <button>Search Result</button>
    </form>
    <?php if(isset($Exam) && isset($results)){?>

      <table style='font-size:14px'>
        <thead>
          <tr>
            <th>Rank</th>
            <th>Name</th>
            <th>GPA</th>
            <th>Grade</th>
            <th>Result</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i=1;
          if(count($results)==0){
            ?>
                <tr>
                    <td colspan='5'>No Data</td>
                </tr>
            <?php
          }else{
            foreach($results as $value){
          ?>
            <tr>
              <td data-label="Rank"><?=$i++?></td>
              <td data-label="Name" style='text-align:left;'><?=$value->Name?></td>
              <td data-label="GPA"><?=number_format($value->TotalGPA,2)?></td>
              <td data-label="Grade"><?=($value->Pass==1)?gradingSystem($value->TotalGPA):'---'?></td>
              <td data-label="Result" class='<?=($value->Pass==1)?'result-pass':'result-fail'?>'><?=($value->Pass==1)?"Passed":"Failed"?></td>
            </tr>
          <?php
                }
            }
          ?>
        </tbody>
      </table>
    </div>
  <?php }
  else{
    if(isset($Exam)){
      echo "<h2 style='color:red;'>Result Not Available !!</h2>";
    }
  }
  ?>
</body>
</html>

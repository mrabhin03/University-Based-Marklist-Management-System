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

function getGrade($percentage) {
    if ($percentage >= 95) {
        return "S";   // Outstanding
    } elseif ($percentage >= 85) {
        return "A+"; // Excellent
    } elseif ($percentage >= 75) {
        return "A";  // Very Good
    } elseif ($percentage >= 65) {
        return "B+"; // Good
    } elseif ($percentage >= 55) {
        return "B";  // Above Average
    } elseif ($percentage >= 45) {
        return "C";  // Satisfactory
    } elseif ($percentage >= 35) {
        return "D";  // Pass
    } else {
        return "F";  // Failure
    }
}
function getGradePoint($grade) {
    $grade = strtoupper(trim($grade));

    switch ($grade) {
        case "S":  return 10.0;
        case "A+": return 9.0;
        case "A":  return 8.0;
        case "B+": return 7.0;
        case "B":  return 6.0;
        case "C":  return 5.0;
        case "D":  return 4.0;
        case "F":
        case "AB":
            return 0.0;
        default:
            return 0.0; // Unknown grade
    }
}

function getOverallGrade($cgpa) {
    if ($cgpa >= 9.5) {
        return "S";
    } elseif ($cgpa >= 8.5) {
        return "A+";
    } elseif ($cgpa >= 7.5) {
        return "A";
    } elseif ($cgpa >= 6.5) {
        return "B+";
    } elseif ($cgpa >= 5.5) {
        return "B";
    } elseif ($cgpa >= 4.5) {
        return "C";
    } elseif ($cgpa >= 3.5) {
        return "D";
    } else {
        return "F";
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
            <th>PRN</th>
            <th>Name</th>
            <th><?=($Type=="PG")?"GPA":"SCPA"?></th>
            <th>Grade</th>
            <th>Result</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i=0;
          if(count($results)==0){
            ?>
                <tr>
                    <td colspan='5'>No Data</td>
                </tr>
            <?php
          }else{
            $Medals=['','🥇','🥈','🥉'];
            foreach($results as $value){
          ?>
            <tr>
              <td data-label="Rank" <?=(++$i<=3)?"style='font-size:20px;'":""?>><?=($i<=3)?$Medals[$i]:$i;?></td>
              <td data-label="Name" style='text-align:left;'><?=$value->PRN?></td>
              <td data-label="Name" style='text-align:left;'><?=$value->Name?></td>
              <td data-label="OUT"><?=number_format($value->TotalGPA,2)?></td>
                <td data-label="Grade"><?=($value->Pass==1)?($Type=="PG")?gradingSystem($value->TotalGPA):getOverallGrade($value->TotalGPA):'---'?></td>
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

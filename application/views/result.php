<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exam Result</title>
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
$current_type = $this->uri->segment(2);
?>
<body>
  <div class="container">
    <a href="../"><ion-icon style='font-size:20px' name="arrow-back-outline"></ion-icon></a>
    <h1>Results</h1>
    <?php if(isset($Exam)){?><h2><?=$Exam->ExamName?></h2><?php }?>

    <form class="input-form" method='POST'>
      <input type="text" placeholder="Enter PRN" name='PRN' value='<?=(isset($PRN))?$PRN:""?>' required/>
      <select name='Exam' required>
        <option disabled selected value=''>Select Your Semester</option>
        <?php
          foreach($semester as $sem){?>
            <option value='<?=$sem->ExamID?>'  <?=(isset($Exam) && ($Exam->ExamID==$sem->ExamID))?"SELECTED":""?>><?=$sem->ExamName?></option>
            <?php
          }
        
        ?>
      </select>
      <button>Search Result</button>
      <a href="<?= site_url("Result/$current_type/Rank"); ?>"><button type='button'>Show Rank</button></a>
    </form>
    <?php if(isset($Exam)&& isset($Student) && isset($result)){?>
      <div class="info">
        <p><strong>PRN:</strong> <?=$Student->PRN?><br>
        <strong>Name:</strong> <?=$Student->Name?><br>
        <strong>Program:</strong> <?=$Student->ProgramName?><br>
        <strong>Exam Center:</strong> <?=$Student->ExamCenter?></p>
      </div>

      <table>
        <thead>
          <tr>
            <th>Course Code</th>
            <th>Course</th>
            <th>INT (Theory)</th>
            <th>EXT (Theory)</th>
            <th>INT (Practical)</th>
            <th>EXT (Practical)</th>
            <th>GPA</th>
            <th>Grade</th>
            <th>Result</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $total=0;
            $totalCredits=0;
            $pass=true;
            foreach($result as $value){

              if($value->CourseType=='Elective' && $value->INTS==0){
                continue;
              }

              $totalCredits+=$value->Credit;
                if ($Student->Type=="PG"){
                  $GPA=calculateGPA($value->INTS,$value->EXT);
                  $GPA=($GPA>=2 && $value->EXT>=2 && $value->INTS>=2)?$GPA:0;
                  $total+=$GPA*$value->Credit;
                  
                  if($GPA==0){
                    $pass=false;
                  }
                }else{
                  $sum=$value->EXT+$value->INTS;
                  $CP=0;
                  if ($value->EXT>=24 || $value->INTS>20){
                    $CP=getGradePoint(getGrade((($sum)/100)*100));
                    $total+=($value->Credit*$CP);
                  }else{
                    $pass=false;
                  }
                }
          ?>
            <tr>
              <td data-label="Course Code"><?=$value->CourseCode?></td>
              <td data-label="Course"><?=$value->CourseName?></td>
              <td data-label="INT (Theory)"><?=($value->CourseType=='Theory'||$value->CourseType=='Elective')?$value->INTS:"---"?></td>
              <td data-label="EXT (Theory)"><?=($value->CourseType=='Theory'||$value->CourseType=='Elective')?$value->EXT:"---"?></td>
              <td data-label="INT (Practical)"><?=($value->CourseType=='Practical')?$value->INTS:"---"?></td>
              <td data-label="EXT (Practical)"><?=($value->CourseType=='Practical')?$value->EXT:"---"?></td>
              <?php if ($Student->Type=="PG"){?>
                  <td data-label="OutValue"><?=number_format($GPA,2)?></td>
                  <td data-label="Grade"><?=gradingSystem($GPA)?></td>
                  <td data-label="Result" id='Result' class="<?=($GPA>=2)?'result-pass':'result-fail'?>"><?=($GPA>=2)?"Passed":"Failed"?></td>
                <?php }else{ ?>
                  <td data-label="OutValue"><?=$CP?></td>
                  <td data-label="Grade"><?=getGrade((($value->EXT+$value->INTS)/100)*100)?></td>
                  <td data-label="Result" id='Result' class="<?=($CP>0)?'result-pass':'result-fail'?>"><?=($CP>0)?"Passed":"Failed"?></td>
                <?php } ?>
              
            </tr>
          <?php
            }
          ?>
        </tbody>
      </table>
      <?php
        if($pass){
          $total=$total/$totalCredits;
          
      ?>
        <h3 style="text-align:center; margin-top: 30px; color: var(--highlight-color);">Semester <?=($Student->Type=="PG")?"GPA":"SCPA"?>: <strong><?=number_format($total,2)?></strong> <span class="result-pass">&nbsp; | &nbsp; Grade: <?=($Student->Type=="PG")?gradingSystem($total):getOverallGrade($total)?></span> &nbsp; | &nbsp; <span class="result-pass">Result: Passed</span></h3>
      <?php
        }else{?>
          <h3 style="text-align:center; margin-top: 30px; color: red;"><span class="result-pass" style='color: red;'>Result: Failed</span></h3>
          <?php
        }
      ?>
    </div>
  <?php }
  else{
    if(isset($Exam)){
      echo "<h2 style='color:red;'>Result Not Available !!</h2>";
    }
  }
  ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

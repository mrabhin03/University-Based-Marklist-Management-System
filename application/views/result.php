<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Exam Result</title>
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
    <h1>Our Results</h1>
    <?php if(isset($Exam)){?><h2><?=$Exam->ExamName?></h2><?php }?>

    <form class="input-form" method='POST'>
      <input type="text" placeholder="Enter PRN" name='PRN' value='<?=(isset($PRN))?$PRN:""?>' required/>
      <select name='Exam' required>
        <option disabled selected value=''>Select Your Semester</option>
        <?php
          foreach($semester as $sem){?>
            <option value='<?=$sem->ExamID?>'  <?=(isset($Exam) && ($Exam->ExamID==$sem->ExamID))?"SELECTED":""?>><?=explode('PG',$sem->ExamName)[0]?></option>
            <?php
          }
        
        ?>
      </select>
      <button>Search Result</button>
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
            $pass=true;
            foreach($result as $value){
              $GPA=calculateGPA($value->INTS,$value->EXT);
              $GPA=($GPA>=2 && $value->EXT>=2 && $value->INTS>=2)?$GPA:0;
              $total+=$GPA;
              if($GPA==0){
                $pass=false;
              }
          ?>
            <tr>
              <td data-label="Course Code"><?=$value->CourseCode?></td>
              <td data-label="Course"><?=$value->CourseName?></td>
              <td data-label="INT (Theory)"><?=($value->CourseType=='Theory')?$value->INTS:"---"?></td>
              <td data-label="EXT (Theory)"><?=($value->CourseType=='Theory')?$value->EXT:"---"?></td>
              <td data-label="INT (Practical)"><?=($value->CourseType=='Practical')?$value->INTS:"---"?></td>
              <td data-label="EXT (Practical)"><?=($value->CourseType=='Practical')?$value->EXT:"---"?></td>
              <td data-label="GPA"><?=number_format($GPA,2)?></td>
              <td data-label="Grade"><?=gradingSystem($GPA)?></td>
              <td data-label="Result" class="<?=($GPA>=2)?'result-pass':'result-fail'?>"><?=($GPA>=2)?"Passed":"Failed"?></td>
            </tr>
          <?php
            }
          ?>
        </tbody>
      </table>
      <?php
        if($pass){
          $total=$total/count($result);
      ?>
        <h3 style="text-align:center; margin-top: 30px; color: var(--highlight-color);">Semester GPA: <strong><?=number_format($total,2)?></strong> &nbsp; | &nbsp; <span class="result-pass">Result: Passed</span></h3>
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
</body>
</html>

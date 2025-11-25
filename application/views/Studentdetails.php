<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exam Result</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css')."?t=".time() ?>">
</head>
<?php
function calculateGPA($internal, $external) {
    $internal = $internal *.25;
    $external = $external*.75;
    $total = $internal + $external;
    return $total;
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


?>
<body>
  <script>
    let credits=[];
  </script>
    
  <div class="container">
    <div class='headerSecond'><a href="students?program=<?=$program?>&AcademicYear=<?=$AcademicYear?>"><ion-icon style='text-decoration: none;font-size: 25px;' name="close-outline"></ion-icon></a></div>
    <?php if(count($semester)==0){die("<h1>No exams Found</h1>");}?>
    <h1>Results</h1>
    <?php if(isset($Exam)){?><h2><?=$Exam->ExamName?></h2><?php }?>

    <form class="input-form Sub" method='GET'>
      <input type="hidden" placeholder="Enter PRN" name='PRN' value='<?=(isset($PRN))?$PRN:""?>' required/>
      <input type="hidden" name='program' value='<?=$program?>'>
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
    </form>
    <?php if(isset($Exam)&& $Student){?>
      <div class="info">
        <p><strong>PRN:</strong> <?=$Student->PRN?><br>
        <strong>Name:</strong> <?=$Student->Name?><br>
        <strong>Program:</strong> <?=$Student->ProgramName?><br>
      </div>
      <form action="createAtts" method="POST">
        <input type="hidden" name='attID' value='<?=(isset($AttDetails))?$AttDetails->AttID:"0"?>'>
        <input type="hidden" name='PRN' value='<?=$Student->PRN?>'>
        <input type="hidden" name='ExamID' value='<?=$Exam->ExamID?>'>
        <input type="hidden" name='programID' value='<?=$program?>'>
        <input type="hidden" name='AcademicYear' value='<?=$AcademicYear?>'>
          <table>
            <tbody>
              <tr>
                <td data-label="Exam Center">Exam Center</td>
                <td data-label="">
                  <select name="ExamCenter" required style='width:100%'>
                        <?php
                            foreach($Centers as $Center){
                                ?>
                                <option value='<?=$Center->ExamCenterID ?>'  <?=(isset($AttDetails) && $AttDetails->ExamCenterID==$Center->ExamCenterID)?"SELECTED":""?>><?=$Center->ExamCenter?></option>
                                <?php
                            }
                        ?>
                    </select>
                </td>
              </tr>

              <td colspan='2'>
                <div class='submit-button'>
                  <button type="submit"><?=(isset($AttDetails))?"Change":"Add"?> Exam Center</button>
                </div>
              </td>
            </tbody>
          </table>
        </form>
      <?php
      if(isset($result)){
      ?>
        <table>
          <thead>
            <tr>
              <th>Course Code</th>
              <th>Course</th>
              <th>Type</th>
              <th>INT</th>
              <th>EXT</th>
              
              <th><?=($Student->Type=="PG")?"GPA":"CP"?></th>
              <th>Result</th>

              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $total=0;
              $pass=true;
              $totalCredits=0;
              $i=0;
              foreach($result as $value){
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
                  if ($value->EXT>=24){
                    $CP=getGradePoint(getGrade((($sum)/100)*100));
                    $total+=($value->Credit*$CP);
                  }else{
                    $pass=false;
                  }
                }
                echo "<script>credits[$i]=".$value->Credit.";</script>";
                
            ?>
              <tr>
                <td data-label="Course Code"><?=$value->CourseCode?></td>
                <td data-label="Course"><?=$value->CourseName?></td>
                <td data-label="Type"><?=$value->CourseType?></td>
                <td data-label="INT"><input style='width:80px' type="number" id='INTS' value='<?=$value->INTS?>'></td>
                <td data-label="EXT"><input style='width:80px' type="number" id='EXT' value='<?=$value->EXT?>'></td>
                <?php if ($Student->Type=="PG"){?>
                  <td data-label="OutValue" id='OutValue'><?=number_format($GPA,2)?></td>
                  <td data-label="Result" id='Result' class="<?=($GPA>=2)?'result-pass':'result-fail'?>"><?=($GPA>=2)?"Passed":"Failed"?></td>
                <?php }else{ ?>
                  <td data-label="OutValue" id='OutValue'><?=$CP?></td>
                  <td data-label="Result" id='Result' class="<?=($CP>0)?'result-pass':'result-fail'?>"><?=($CP>0)?"Passed":"Failed"?></td>
                <?php } ?>
                <td data-label="Action"><button onclick="saveChanges('<?=$value->CourseCode?>','<?=$AttDetails->AttID?>',<?=$value->MarkID?>,this,<?=$i?>,'<?=$Student->Type?>')" class='editCourse'>Edit</button></td>
              </tr>
            <?php
                $i++;
              }
            ?>
          </tbody>
        </table>
        <?php
          if($pass){
            $total=$total/$totalCredits;
        ?>
          <h3 style="text-align:center; margin-top: 30px; color: var(--highlight-color);" id='MainResult'>Semester <?=($Student->Type=="PG")?"GPA":"SCPA"?>: <strong><?=number_format($total,2)?></strong> &nbsp; | &nbsp; <span class="result-pass">Result: Passed</span></h3>
        <?php
          }else{?>
            <h3 style="text-align:center; margin-top: 30px; color: var(--highlight-color);" id='MainResult' ><span class="result-pass" style='color: red;'>Result: Failed</span></h3>
            <?php
          }
        ?>

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
  <script>
    function saveChanges(CourseCode,AttID,MarkID,obj,NO,Type){
        const par=obj.parentNode.parentNode;

        let  INTS=parseFloat(par.querySelector("#INTS").value);
        par.querySelector("#INTS").value=INTS.toFixed(2);


        let EXT=parseFloat(par.querySelector("#EXT").value);
        par.querySelector("#EXT").value=EXT.toFixed(2);


        outValue=0;
        passed=false
        if (Type=="PG"){
          INTS=(INTS>5)?5:INTS;
          EXT=(EXT>5)?5:EXT;
          outValue=((INTS*0.25)+(EXT*0.75)).toFixed(2);
          if (outValue>=2){
            passed=true
          }
        }else{
          let Sumer=INTS+EXT;
          let per=(Sumer*100)/100
          outValue=getGradePoint(getGrade(per))
          if(outValue>0 && EXT>=24){
            passed=true
          }
        }


        const Result=par.querySelector("#Result")
        Result.classList.remove("result-pass")
        Result.classList.remove("result-fail")
        if(passed){
              Result.innerHTML='Passed';
              Result.classList.add("result-pass")
          }else{
              Result.innerHTML='Failed';
              Result.classList.add("result-fail")
          }

        
        par.querySelector("#OutValue").innerHTML=outValue
        

        
        const MainResult=document.querySelector("#MainResult")

        const AllGPA=document.querySelectorAll("#OutValue");
        let Totalvalues=0;
        let pass=true;
        if(EXT<2){
          pass=false;
        }
        let TotalCredits=0;
        AllGPA.forEach((element,index) => {
            let value=parseFloat(element.innerHTML);
            Totalvalues+=value*credits[index];
            TotalCredits+=credits[index];
            if(value<2){
                pass=false;
            }
        });
        if(pass){
            MainResult.innerHTML=`Semester GPA: <strong>${(Totalvalues/TotalCredits).toFixed(2)}</strong> &nbsp; | &nbsp; <span class="result-pass">Result: Passed</span>`;
        }else{
            MainResult.innerHTML=`<span class="result-pass" style='color: red;'>Result: Failed</span>`
        }

        const data = new FormData();
        data.append("CourseCode", CourseCode);
        data.append("AttID", AttID);
        data.append("MarkID", MarkID);
        data.append("INTS", INTS);
        data.append("EXT", EXT);

        // Create AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "SaveMarks", true);

        xhr.onload = function () {
        if (xhr.status === 200) {
            console.log("Response :", xhr.responseText);
        } else {
            console.error("Error:", xhr.statusText);
        }
        };

        xhr.send(data);
    }



    function getGrade(percentage) {
      if (percentage >= 95) {
          return "S";   // Outstanding
      } else if (percentage >= 85) {
          return "A+"; // Excellent
      } else if (percentage >= 75) {
          return "A";  // Very Good
      } else if (percentage >= 65) {
          return "B+"; // Good
      } else if (percentage >= 55) {
          return "B";  // Above Average
      } else if (percentage >= 45) {
          return "C";  // Satisfactory
      } else if (percentage >= 35) {
          return "D";  // Pass
      } else {
          return "F";  // Failure
      }
  }
  function getGradePoint(grade) {
      grade = grade.trim().toUpperCase();

      switch (grade) {
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

  </script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

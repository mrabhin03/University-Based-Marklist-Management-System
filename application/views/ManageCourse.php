<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course Manage</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css')."?t=".time() ?>">
  <style>
    tbody>tr>td:first-child{
        text-align:right;
    }
  </style>
</head>
<body>
  <script>
    let CourseCode=[];
    <?php
    foreach($CourseCodes as $CourseCode){
      echo "CourseCode.push('{$CourseCode->CourseCode}');";
    }
    ?>
  </script>
  <div class="container">
        <div class='headerSecond'><a href="<?=(isset($semester))?"courses?program={$program->ProgramID}&semester={$semester}":"semester?program={$program->ProgramID}"?>"><ion-icon name="close-outline"></ion-icon></a></div>
    <h1>Course Manage</h1>
    <h1 style='font-size:15px;'><?=$program->ProgramName?></h1>
    <form  method="post" action='ChangeValue' onsubmit="return checkCourseCodeExist()">
        <input type="hidden" name="ProgramID" value='<?=$program->ProgramID?>' id="">
        <input type="hidden" name='Mode' value='<?=$Mode?>'>
      <table>
        <tbody>
            <tr>
              <td data-label="Course Code">Course Code</td>
              <td data-label="">
                <input type="text" name="CourseCode" onkeyup='checker(this)' id="" value='<?=(isset($CourseDetails))?$CourseDetails->CourseCode:''?>' placeholder='Enter the Course Code' <?=(isset($CourseDetails))?"readonly":""?> required>
                <br><span id='invalidCode' style='color:red'></span>
              </td>
            </tr>
            <tr>
              <td data-label="Course Name">Course Name</td>
              <td data-label=""><input type="text" name="CourseName" value='<?=(isset($CourseDetails))?$CourseDetails->CourseName:""?>' placeholder='Enter the Course Name' required></td>
            </tr>
            <tr>
              <td data-label="Credits">Credits</td>
              <td data-label=""><input type="text" name="Credits" value='<?=(isset($CourseDetails))?$CourseDetails->Credit:""?>' placeholder='Enter the Course Credits' required></td>
            </tr>
            <tr>
                <td data-label="Course Type">Course Type</td>
                <td data-label="">
                    <select name="CourseType" required>
                        <option value="Theory"  <?=(isset($CourseDetails) && $CourseDetails->CourseType=='Theory')?"SELECTED":""?>>Theory</option>
                        <option value="Practical" <?=(isset($CourseDetails) && $CourseDetails->CourseType=='Practical')?"SELECTED":""?>>Practical</option>
                        <option value="Elective" <?=(isset($CourseDetails) && $CourseDetails->CourseType=='Elective')?"SELECTED":""?>>Elective</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td data-label="Semester">Semester</td>
                <td data-label="">
                    <select name="SemesterNo" required>
                        <?php
                            for($i=1;$i<=$program->TotalSemesters;$i++){
                                ?>
                                <option value='<?=$i?>'  <?=(isset($CourseDetails) && $CourseDetails->Semester==$i)?"SELECTED":((isset($semester) && $semester==$i)?"SELECTED":"")?>><?=$i?></option>
                                <?php
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan='2'>
                    <div class='submit-button'>
                            <button type="submit">Submit</button>
                    </div>
                </td>
            </tr>
        </tbody>
      </table>
    </form>
    <script>
      let save=true;
      const invalidCode=document.getElementById("invalidCode");
      function checker(obj){
        let value=obj.value
        if(CourseCode.indexOf(value)>=0){
          save=false;
          invalidCode.innerHTML='Course Code Already Exists';
        }else{
          save=true;
          invalidCode.innerHTML='';
        }
      }
      function checkCourseCodeExist(){
        return save;
      }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

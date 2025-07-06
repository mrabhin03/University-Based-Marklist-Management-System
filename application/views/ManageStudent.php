<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Manage</title>
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
    let PRNs=[];
    <?php
    foreach($PRNs as $Roll){
      echo "PRNs.push('{$Roll->PRN}');";
    }
    ?>
  </script>
  <div class="container">
        <div class='headerSecond'><a href="<?=(isset($AcademicYear))?"students?program={$program->ProgramID}&AcademicYear={$AcademicYear}":"AcademicYear?program={$program->ProgramID}"?>"><ion-icon name="close-outline"></ion-icon></a></div>
    <h1>Student Manage</h1>
    <h1 style='font-size:15px;'><?=$program->ProgramName?></h1>
    <form  method="post" action='ChangeValueStudents' onsubmit="return checkPRNExist()">
        <input type="hidden" name="ProgramID" value='<?=$program->ProgramID?>' id="">
        <input type="hidden" name='Mode' value='<?=$Mode?>'>
      <table>
        <tbody>
            <tr>
              <td data-label="PRN">Student PRN</td>
              <td data-label="">
                <input type="text" name="PRN" onkeyup='checker(this)' value='<?=(isset($Studentdetails))?$Studentdetails->PRN:''?>' placeholder='Enter the PRN' <?=(isset($Studentdetails))?"readonly":""?> required>
                <br><span id='invalidPRN' style='color:red'></span>
              </td>
            </tr>

            <tr>
              <td data-label="Student Name">Student Name</td>
              <td data-label=""><input type="text" name="StudentName" value='<?=(isset($Studentdetails))?$Studentdetails->Name:""?>' placeholder='Enter the Student Name' required></td>
            </tr>

            <tr>
              <td data-label="Academic Year">Academic Year</td>
              <td data-label=""><input type="text" name="AcademicYear" value='<?=(isset($Studentdetails))?$Studentdetails->AcademicYear:((isset($AcademicYear))?$AcademicYear:"")?>' placeholder='Enter the Academic Year' <?=(isset($Studentdetails))?"readonly":""?> required></td>
            </tr>

            <tr>
              <td data-label="Program" required>Program Name</td>
        
              <td data-label="">
                <select name="" id="" disabled>
                <option value="">
                    <?=(isset($program))?$program->ProgramName:""?>
                </option>
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
      const invalidPRN=document.getElementById("invalidPRN");
      function checker(obj){
        let value=obj.value
        if(PRNs.indexOf(value)>=0){
          save=false;
          invalidPRN.innerHTML='PRN Already Exists';
        }else{
          save=true;
          invalidPRN.innerHTML='';
        }
      }
      function checkPRNExist(){
        return save;
      }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exam Manage</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css')."?t=".time() ?>">
  <style>
    tbody>tr>td:first-child{
        text-align:right;
    }
  </style>
</head>
<body>
  <div class="container">
        <div class='headerSecond'><a href="exams?program=<?=$program->ProgramID?>"><ion-icon name="close-outline"></ion-icon></a></div>
    <h1>Exam Manage</h1>
    <h1 style='font-size:15px;'><?=$program->ProgramName?></h1>
    <form  method="post" action='ChangeValueExam'>
        <input type="hidden" name="ProgramID" value='<?=$program->ProgramID?>' id="">
        <input type="hidden" name='Mode' value='<?=$Mode?>'>
        <input type="hidden" name='ExamID' value='<?=(isset($ExamsDetails))?$ExamsDetails->ExamID:'0'?>'>
      <table>
        <tbody>
             <tr>
              <td data-label="Exam Name">Exam Name</td>
              <td data-label=""><input type="text" name="ExamName" id="" value='<?=(isset($ExamsDetails))?$ExamsDetails->ExamName:''?>' placeholder='Enter the Exam Name' required></td>
            </tr>

            <tr>
              <td data-label="Academic Year">Academic Year</td>
              <td data-label=""><input type="text" name="AcademicYear" value='<?=(isset($ExamsDetails))?$ExamsDetails->AcademicYear:""?>' placeholder='Enter the Academic Year' required <?=(isset($ExamsDetails))?"readonly":""?>></td>
            </tr>

            <tr>
              <td data-label="Program">Program Name</td>
        
              <td data-label="">
                <select name="" id="" disabled>
                <option value="">
                    <?=(isset($program))?$program->ProgramName:""?>
                </option>
              </select>
              </td>
            </tr>
            <tr>
                <td data-label="Semester">Semester</td>
                <td data-label="">
                    <select name="SemesterNo" <?=(isset($ExamsDetails))?"disabled":""?> required>
                        <?php
                            for($i=1;$i<=$program->TotalSemesters;$i++){
                                ?>
                                <option value='<?=$i?>'  <?=(isset($ExamsDetails) && $ExamsDetails->Semester==$i)?"SELECTED":""?>><?=$i?></option>
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

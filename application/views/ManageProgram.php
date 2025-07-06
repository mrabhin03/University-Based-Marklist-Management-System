<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Program Manage</title>
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
        <div class='headerSecond'><a href="home"><ion-icon name="close-outline"></ion-icon></a></div>
    <h1>Program Manage</h1>
    <h1 style='font-size:15px;'><?=(isset($program))?$program->ProgramName:""?></h1>
    <form  method="post" action='ChangeValueProgram'>
        <input type="hidden" name='ProgramID' value='<?=(isset($program))?$program->ProgramID:'0'?>'>
        <input type="hidden" name='Mode' value='<?=(isset($program))?'1':'0'?>'>
      <table>
        <tbody>
             <tr>
              <td data-label="Program Name">Program Name</td>
              <td data-label=""><input type="text" name="ProgramName" id="" value='<?=(isset($program))?$program->ProgramName:''?>' placeholder='Enter the Program Name' required></td>
            </tr>
            <tr>
                <td data-label="Semester">Semester</td>
                <td data-label=""><input type="text" name="TotalSemesters" id="" value='<?=(isset($program))?$program->TotalSemesters:''?>' placeholder='Enter the Exam Name' required></td>
                
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

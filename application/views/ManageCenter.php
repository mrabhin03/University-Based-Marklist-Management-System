<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Center Manage</title>
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
        <div class='headerSecond'><a href="ExamCenter"><ion-icon name="close-outline"></ion-icon></a></div>
    <h1>Center Manage</h1>
    <h1 style='font-size:15px;'><?=(isset($program))?$program->ProgramName:""?></h1>
    <form  method="post" action='ChangeValueCenter'>
        <input type="hidden" name='ExamCenterID' value='<?=(isset($Center))?$Center->ExamCenterID :'0'?>'>
        <input type="hidden" name='Mode' value='<?=(isset($Center))?'1':'0'?>'>
      <table>
        <tbody>
             <tr>
              <td data-label="Center Name">Center Name</td>
              <td data-label=""><input type="text" name="ExamCenter" id="" value='<?=(isset($Center))?$Center->ExamCenter:''?>' placeholder='Enter the Center Name' required></td>
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

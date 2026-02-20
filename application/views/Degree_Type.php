<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <title>Exam Result</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    /* Base */
body {
  margin: 0;
  padding: 0;
  font-family: 'Inter', sans-serif;
  background: linear-gradient(135deg, #eef2ff, #dbeafe);
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

/* Main Container */
.container {
  background: #ffffff;
  width: 90%;
  max-width: 550px;
  padding: 40px 30px;
  border-radius: 20px;
  box-shadow: 0px 10px 35px rgba(0, 0, 0, 0.1);
  text-align: center;
  animation: fadeIn 0.6s ease;
}

/* Heading */
.container h1 {
  font-size: 32px;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 25px;
}

/* Button Section */
.info {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 10px;
}

/* Buttons */
.info button {
  background: #3b82f6;
  border: none;
  padding: 12px 25px;
  border-radius: 10px;
  font-size: 18px;
  color: white;
  cursor: pointer;
  transition: 0.25s ease;
  font-weight: 600;
}

.info button:hover {
  background: #2563eb;
  transform: translateY(-3px);
  box-shadow: 0px 6px 18px rgba(37, 99, 235, 0.25);
}

.info button:active {
  transform: scale(0.95);
}

/* Fade-in animation */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

  </style>
</head>
<body>
  <div class="container">
    <h1>Result</h1>
      <div class="info" style='font-size:20px'>
        <a href="<?=site_url("Result/UG")?>"><button>Undergraduate</button></a>
        <a href="<?=site_url("Result/PG")?>"><button>Postgraduate</button></a>
      </div>
</body>
</html>

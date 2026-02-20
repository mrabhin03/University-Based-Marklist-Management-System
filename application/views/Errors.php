<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Results</title>
    <style>
        :root {
            --primary-bg: #ffffff;
            --header-color: #2c3e50;
            --table-border: #e0e0e0;
            --text-muted: #888;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .no-result-container {
            background: var(--primary-bg);
            padding: 40px 60px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            max-width: 400px;
            border: 1px solid var(--table-border);
        }

        .icon-wrapper {
            background: #f8f9fa;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
        }

        .icon-wrapper svg {
            width: 40px;
            height: 40px;
            color: #bdc3c7;
        }

        h2 {
            color: var(--header-color);
            margin: 0 0 10px 0;
            font-size: 22px;
            letter-spacing: -0.5px;
        }

        p {
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.6;
            margin: 0 0 25px 0;
        }

        .btn-retry {
            background-color: var(--header-color);
            color: white;
            padding: 10px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: opacity 0.2s;
            display: inline-block;
        }

        .btn-retry:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <div class="no-result-container">
        <div class="icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <h2>No Results Found</h2>
        <p>We couldn't find any data matching your request. Please check the PRN or Exam ID and try again.</p>
        <a href="#" class="btn-retry" onclick="window.history.back();">Go Back</a>
    </div>

</body>
</html>
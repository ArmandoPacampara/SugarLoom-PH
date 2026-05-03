<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #ff4d6d 0%, #ff8fa3 100%);}
        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }
        .container:hover { transform: translateY(-5px); }
        h1 {
            color: #333;
            margin: 0;
        }
        p {
            color: #666;
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container" data-aos="zoom-in">
        <h1>Welcome to {{ $name ?? 'SugarLoom PH' }}!</h1>
        <p>We're glad to have you here.</p>
    </div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000, once: true });
    </script>
</body>

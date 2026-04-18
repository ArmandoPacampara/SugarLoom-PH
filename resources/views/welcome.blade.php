<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SugarLoom PH</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f8b4b4;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            background: #d95b7a;
            color: white;
        }

        .nav-links a {
            margin: 0 15px;
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .logo {
            font-weight: bold;
            font-size: 20px;
        }

        /* HERO */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 60px;
        }

        .hero-text {
            max-width: 50%;
        }

        .hero h1 {
            font-size: 60px;
            margin: 0;
            color: #2b2b2b;
        }

        .hero h1 span {
            color: #7a3e4d;
        }

        .hero p {
            margin-top: 20px;
            color: #555;
        }

        .buttons {
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 25px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }

        .btn-primary {
            background: #d95b7a;
            color: white;
        }

        .btn-secondary {
            background: #eee;
        }

        .hero img {
            width: 450px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="logo">SugarLoom PH</div>
        <div class="nav-links">
            <a href="#">Catalog</a>
            <a href="#">Track Order</a>
            <a href="#">Dashboard</a>
        </div>
    </div>

    <!-- HERO SECTION -->
    <div class="hero">
        <div class="hero-text">
            <h1>
                Where sweet dreams are <br>
                <span>woven!</span>
            </h1>

            <p>
                Indulge in our small-batch, handcrafted cookies baked daily
                with premium ingredients and a touch of artisanal magic.
            </p>

            <div class="buttons">
                <button class="btn btn-primary">Shop Now</button>
                <button class="btn btn-secondary">Our Story</button>
            </div>
        </div>

        <!-- IMAGE -->
        <div>
            <img src="{{ asset('images/cookies.png') }}" alt="Cookies">
        </div>
    </div>

</body>
</html>
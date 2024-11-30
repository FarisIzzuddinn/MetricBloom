<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: #fff;
            text-align: center;
            overflow: hidden;
        }

        /* Access Denied Container */
        .access-denied-container {
            max-width: 500px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
            background: linear-gradient(90deg, #ff9a8b, #ff6a88, #ff99ac);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        a {
            display: inline-block;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(90deg, #ff416c, #ff4b2b);
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease-in-out;
        }

        a:hover {
            transform: scale(1.1);
            background: linear-gradient(90deg, #ff4b2b, #ff416c);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6);
        }

        /* Keyframe Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Background Animation */
        .background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .background-animation span {
            position: absolute;
            display: block;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            animation: float 10s infinite ease-in-out;
            border-radius: 50%;
        }

        /* Float Animation for Background Bubbles */
        @keyframes float {
            0% {
                transform: translateY(0px) translateX(0px);
            }
            50% {
                transform: translateY(-300px) translateX(100px);
            }
            100% {
                transform: translateY(0px) translateX(0px);
            }
        }

        .background-animation span:nth-child(1) {
            top: 20%;
            left: 10%;
            width: 60px;
            height: 60px;
            animation-duration: 12s;
        }

        .background-animation span:nth-child(2) {
            top: 30%;
            left: 80%;
            width: 100px;
            height: 100px;
            animation-duration: 15s;
        }

        .background-animation span:nth-child(3) {
            top: 70%;
            left: 40%;
            animation-duration: 8s;
        }

        .background-animation span:nth-child(4) {
            top: 60%;
            left: 20%;
            width: 80px;
            height: 80px;
            animation-duration: 18s;
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="background-animation">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Access Denied Content -->
    <div class="access-denied-container">
        <h1>Access Denied</h1>
        <p>Oops! You don't have permission to access this page. If you think this is a mistake, contact your administrator.</p>
        <a href="/">Go Back to Home</a>
    </div>
</body>
</html>

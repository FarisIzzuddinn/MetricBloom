<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts (Poppins and Lora) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Lora&display=swap" rel="stylesheet">

    <!-- Custom Styling -->
    <style>
        body {
            background-color: #f8d7da;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            overflow: hidden;
        }

        .error-container {
            text-align: center;
            animation: slideIn 1.5s ease-out forwards;
        }

        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #f44336;
            text-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
            animation: zoomIn 1s ease-out;
        }

        .error-message {
            font-size: 20px;
            color: #333;
            font-family: 'Lora', serif;
            margin-bottom: 30px;
            opacity: 0;
            animation: fadeIn 2s ease-in forwards;
        }

        .btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }

        .back-home-icon {
            margin-right: 8px;
        }

        .icon-container {
            font-size: 120px;
            color: #f44336;
            margin-bottom: 20px;
            animation: bounceIn 1.5s ease-out;
        }

        /* Keyframes for animations */
        @keyframes slideIn {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.5);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            60% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .error-code {
                font-size: 100px;
            }

            .error-message {
                font-size: 18px;
            }

            .btn {
                padding: 8px 15px;
                font-size: 14px;
            }

            .icon-container {
                font-size: 100px;
            }
        }

        @media (max-width: 576px) {
            .error-code {
                font-size: 80px;
            }

            .error-message {
                font-size: 16px;
            }

            .btn {
                padding: 8px 12px;
                font-size: 14px;
            }

            .icon-container {
                font-size: 80px;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <!-- Icon section with animation -->
        <div class="icon-container">
            <i class="fas fa-ban"></i>
        </div>

        <!-- Error code with zoom-in animation -->
        <div class="error-code">
            403
        </div>

        <!-- Error message with fade-in animation -->
        <p class="error-message">
            Oops! You do not have permission to access this page.
        </p>

        <!-- Back Home button with hover effect -->
        <a href="{{ url('/') }}" class="btn">
            <i class="fas fa-home back-home-icon"></i>Go Back Home
        </a>
    </div>

    <!-- Optional: Add Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

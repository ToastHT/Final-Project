<!-- Aldrich Mira -->
<?php
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Insert into MySQL database
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $full_name, $email, $email, $password);

        if ($stmt->execute()) {
            // Save data to XML
            $xmlFile = 'users.xml';

            // Load the existing XML data or create a new XML structure
            if (file_exists($xmlFile)) {
                $xml = simplexml_load_file($xmlFile);
            } else {
                $xml = new SimpleXMLElement('<users>
                </users>'); 
            }

            // Create a new user entry in the XML
            $user = $xml->addChild('user');
            $user->addChild('id', $stmt->insert_id); // ID from the database
            $user->addChild('full_name', $full_name);
            $user->addChild('username', $email);
            $user->addChild('password', $password);

            // Save the XML to the file
            $xml->asXML($xmlFile);

            echo "<script>alert('Registration successful! Please log in.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            min-height: 100vh;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 1.5rem 4rem;
            background: transparent;
            transition: background-color 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(0, 0, 0, 0.9);
        }

        .navbar-brand {
            color: #dcdcdc;
            font-size: 1.8rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 20px;
            pointer-events: none; /* Disables clicking */
        }

        .navbar-brand .logo {
            width: 65px;
            height: auto;
            margin-right: 10px;
        }

        .navbar-nav {
            margin-left: auto;
            gap: 3rem;
            margin-top: 25px;
        }

        .main-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-container h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: 600;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.8);
        }

        .input-group input {
            width: 100%;
            padding: 12px 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            color: #fff;
            font-size: 1rem;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .input-group input:focus {
            outline: none;
            border-color: #f0f8ff;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .btn-signup {
            width: 100%;
            padding: 12px;
            background-color: #536878;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(128, 128, 128, 0.4);
        }

        .btn-signup:hover {
            background-color: #838996;
            transform: translateY(-2px);
        }

        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #fff;
        }

        .signup-link a {
            color: #f0f8ff;
            text-decoration: none;
            font-weight: 500;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .hero-section {
            height: 100vh;
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('BG.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 100px;
        }

        .hero-content {
            max-width: 800px;
            padding: 2rem;
        }

        .hero-title {
            font-size: 55px;
            font-weight: bold;
            color: #f0f8ff;
            margin-bottom: 20px;
        }

        .hero-text {
            color: #ffffff;
            font-size: 17px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .hero-content {
                text-align: center;
                padding: 1rem;
            }

            .hero-buttons {
                justify-content: center !important;
            }

            .form-container {
                margin: 2rem;
                padding: 1.5rem;
            }
        }
        .btn-custom {
                font-family: 'Arial', sans-serif;
                font-size: 16px;
                font-weight: bold;
                padding: 12px 24px;
                border: none;
                border-radius: 30px;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
            }

            /* Styling for Apply button */
            .btn-apply {
                background-color: #555555; /* Light azure for Apply button */
                color: #fff;
            }

            .btn-apply:hover {
                background-color: #91a3b0; /* Slightly darker light azure on hover */
                transform: translateY(-3px);
                box-shadow: 0 4px 6px rgba(128, 128, 128, 0.4);
            }

            /* Styling for Learn More button */
            .btn-learn {
                color: #f0f8ff; /* Light azure text for contrast */
                margin-left: 10px;
                border: 2px solid #536878; /* Ensure consistency */
            }

            .btn-learn:hover {
                background-color: #778899; /* Slightly darker light azure on hover */
                transform: translateY(-3px);
                box-shadow: 0 4px 6px rgba(240, 255, 255, 0.4);
            }
            a, button, input, .btn {
    transition: all 0.3s ease-out;
}

/* Enhanced button interactions */
.btn-custom {
    position: relative;
    overflow: hidden;
    transform-origin: center;
}

.btn-custom:active {
    transform: scale(0.95);
}

/* Ripple effect for buttons */
.btn-custom::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.3s ease-out, height 0.3s ease-out;
}

.btn-custom:active::after {
    width: 200px;
    height: 200px;
}

/* Enhanced form inputs */
.input-group input {
    transition: all 0.3s ease-out;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.input-group input:hover {
    background-color: rgba(255, 255, 255, 0.15);
}

.input-group input:focus {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Enhanced signup/signin links */
.signup-link a {
    position: relative;
    padding-bottom: 2px;
    color: #71a6d2;
}

.signup-link a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 1px;
    background-color: #f0f8ff;
    transition: width 0.3s ease-out;
    background-color: #71a6d2;
}

.signup-link a:hover::after {
    width: 100%;
}
/* Enhanced button styles */
.btn-signin, .btn-signup {
    position: relative;
    overflow: hidden;
}

.btn-signin:hover, .btn-signup:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.btn-signin:active, .btn-signup:active {
    transform: translateY(-1px);
}

/* Smooth navbar transition */
.navbar {
    transition: all 0.4s ease-out;
}

.navbar.scrolled {
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Enhanced learn more button */
.btn-learn {
    position: relative;
    z-index: 1;
    overflow: hidden;
}

.btn-learn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    transition: left 0.3s ease-out;
    z-index: -1;
}

.btn-learn:hover::before {
    left: 0;
}

/* Enhanced apply button */
.btn-apply {
    position: relative;
    z-index: 1;
    overflow: hidden;
}

.btn-apply::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    transition: left 0.3s ease-out;
    z-index: -1;
}

.btn-apply:hover::before {
    left: 0;
}
.input-group input:-webkit-autofill,
.input-group input:-webkit-autofill:hover,
.input-group input:-webkit-autofill:focus {
    -webkit-text-fill-color: white;
    -webkit-box-shadow: 0 0 0px 1000px transparent inset;
    transition: background-color 5000s ease-in-out 0s;
}

/* For Firefox and other browsers */
.input-group input:autofill {
    color: #126180;
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Logo" class="logo"> Barangay Darasa Scholarship Application System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-md-8 d-flex align-items-center">
                    <div class="hero-content text-start">
                        <h1 class="hero-title">EMPOWER YOUR FUTURE</h1>
                        <p class="hero-text">Scholarships open doors to a world of possibilities. Apply now and begin the journey to making your dreams a reality.</p>
                        <div class="hero-buttons justify-content-start">
                            <button class="btn btn-custom btn-apply" onclick="window.location.href='login.php';">APPLY NOW</button>
                            <button class="btn btn-custom btn-learn" onclick="window.location.href='signup-learn_more.php';">LEARN MORE</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <div class="main-container">
                        <div class="form-container">
                            <h2>Sign Up</h2>
                            <form action="signup.php" method="post">
                                <div class="input-group">
                                    <i class="fas fa-user"></i>
                                    <input type="text" name="full_name" placeholder="Full Name" required>
                                </div>
                                <div class="input-group">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" name="email" placeholder="Email" required>
                                </div>
                                <div class="input-group">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" name="password" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn-signup">Sign Up</button>
                            </form>
                            <p class="signup-link">Already have an account? <a href="login.php">Sign In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add background to navbar on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });
        // Smooth scroll behavior for all links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Add ripple effect to buttons
    document.querySelectorAll('.btn-custom, .btn-signin, .btn-signup').forEach(button => {
        button.addEventListener('click', function(e) {
            let x = e.clientX - e.target.offsetLeft;
            let y = e.clientY - e.target.offsetTop;
            
            let ripple = document.createElement('span');
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Enhanced scroll behavior for navbar
    let lastScroll = 0;
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        const navbar = document.querySelector('.navbar');
        
        if (currentScroll > lastScroll && currentScroll > 50) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
        
        if (currentScroll > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll; 
    });
    </script>
</body>
</html>

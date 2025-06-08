<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="./css/styles.css">
    <style>
    /* Notification Box Styles */
    .notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: fit-content;
        padding-left: 20px;
        padding-right: 20px;
        height: 50px;
        border-radius: 18px;
        text-align: center;
        line-height: 50px;
        /* Center text vertically */
        display: none;
        /* Hide by default */
        opacity: 0;
        transform: translateY(100px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .notification.show {
        display: block;
        opacity: 1;
        transform: translateY(-1000px);
    }

    .notification.success {
        background-color: #d4edda;
        /* Light green background */
        color: #155724;
        /* Dark green text */
    }

    .notification.error {
        background-color: #f8d7da;
        /* Light red background */
        color: #721c24;
        /* Dark red text */
    }
    </style>
</head>

<body>
    <div class="container" id="container">
        <!-- Registration Form -->
        <div class="form-container sign-up-container">
            <form id="registerForm" action="register.php" method="post">
                <h1>Create Account</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" name="name" placeholder="Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit">Sign Up</button>
            </form>


        </div>

        <!-- Sign-in Form -->
        <div class="form-container sign-in-container">
            <form action="login.php" method="post">
                <h1>Sign in</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your account</span>
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <a href="#">Forgot your password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>
                        To keep connected with us please login with your personal info
                    </p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start your journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Box -->
    <div id="notification" class="notification"></div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("registerForm");

        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", form.action, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    var notification = document.getElementById('notification');
                    if (xhr.status === 200) {
                        if (xhr.responseText.includes('success')) {
                            notification.className = 'notification success show';
                            notification.textContent = 'Registration successful!';
                            form.reset();
                            document.getElementById("signIn").click();
                            // Reset form only on success
                        } else {
                            notification.className = 'notification error show';
                            notification.textContent = 'Registration failed: ' + xhr.responseText;
                        }
                        setTimeout(function() {
                            notification.className = notification.className.replace('show',
                                '');
                            setTimeout(function() {
                                notification.className = notification.className
                                    .replace('success', '').replace('error', '');
                            }, 500);
                        }, 3000);
                    }
                }
            };
            xhr.send(formData);
        });
    });
    </script>
    <script src="main.js"></script>
</body>

</html>
<!DOCTYPE html>
<html>
<head>
    <title>Lab Technical Officer - Login / Signup</title>
    <!-- Styles have been reverted to the original green/teal color scheme -->
    <style>
        body { 
            font-family: Arial, sans-serif; 
            /* Original green/teal gradient restored */
            background: linear-gradient(to right, #2c3e50, #4ca1af); 
            margin: 0; 
            height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }
        .container { 
            background: #fff; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
            max-width: 400px; 
            width: 100%; 
        }
        h2 { text-align: center; color: #333; }
        input[type="text"], input[type="email"], input[type="password"] { 
            width: calc(100% - 24px);
            padding: 12px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 6px; 
        }
        label { 
            font-weight: bold; 
            display: block; 
            margin-bottom: 5px; 
        }
        .remember-me { 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            font-weight: normal; 
            margin-bottom: 20px; 
        }
        .remember-me input { width: auto; margin-bottom: 0; }
        button { 
            width: 100%; 
            padding: 12px; 
            /* Original button color restored */
            background: #4ca1af; 
            color: white; 
            font-weight: bold; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            transition: background 0.3s; 
        }
        button:hover { 
            background: #2c3e50; 
        }
        .switch-link { text-align: center; margin-top: 15px; }
        .switch-link a { text-decoration: none; font-weight: bold; color: #4ca1af; }
        .hidden { display: none; }
        .error { color: red; text-align: center; margin-bottom: 10px; }
        .message { color: green; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h2 id="form-title">Lab_TO Sign Up</h2>

    <?php if(isset($_GET['error'])) { echo '<p class="error">' . htmlspecialchars($_GET['error']) . '</p>'; } ?>
    <?php if(isset($_GET['message'])) { echo '<p class="message">' . htmlspecialchars($_GET['message']) . '</p>'; } ?>

    <!-- Sign Up Form -->
    <form id="signup-form" method="POST" action="labto_signup.php">
        <label for="signup-name">Full Name</label>
        <input id="signup-name" type="text" name="TO_name" required>
        <label for="signup-email">Email</label>
        <input id="signup-email" type="email" name="TO_Email" required>
        <label for="signup-password">Password</label>
        <input id="signup-password" type="password" name="password" required>
        <button type="submit">Sign Up</button>
        <div class="switch-link">
            Already have an account? <a href="#" onclick="toggleForms()">Login</a>
        </div>
    </form>

    <!-- Login Form -->
    <form id="login-form" class="hidden" method="POST" action="labto_login.php">
        <label for="login-email">Email</label>
        <input id="login-email" type="email" name="TO_Email" required>
        <label for="login-password">Password</label>
        <input id="login-password" type="password" name="password" required>
        <label class="remember-me">
            <input type="checkbox" name="remember_me"> Remember Me
        </label>
        <button type="submit">Login</button>
        <div class="switch-link">
            Don't have an account? <a href="#" onclick="toggleForms()">Sign Up</a>
        </div>
    </form>
</div>

<script>
// This JavaScript correctly toggles between the signup and login forms
function toggleForms() {
    document.getElementById('signup-form').classList.toggle('hidden');
    document.getElementById('login-form').classList.toggle('hidden');
    document.getElementById('form-title').textContent = 
        document.getElementById('login-form').classList.contains('hidden') ? 'Lab TO Sign Up' : 'Lab_TO Login';
}
</script>

</body>
</html>
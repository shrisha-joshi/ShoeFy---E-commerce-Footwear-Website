<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>particle_cursor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body, html {
            margin: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #app {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        #app canvas {
            display: block;
            position: absolute;
            z-index: 0;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .container {
            background-color: azure; /* Semi-transparent background */
            width: 450px;
            padding: 3rem;
            margin: 250px auto;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0, 0, 1, 0.9);
            position: relative;
            align-items: center;
            z-index: 2;
        }

        .container .header {
            font-weight: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2.5rem;
        }

        form {
            margin: 0 2rem;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            padding: 1.3rem;
            margin-bottom: 0.4rem;
        }

        input {
            color: inherit;
            width: 100%;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #757575;
            padding-left: 1.5rem;
            font-size: 15px;
        }

        .input-group {
            padding: 1% 0;
            position: relative;
        }

        .input-group i {
            position: absolute;
            color: black;
        }

        input:focus {
            background-color: transparent;
            outline: transparent;
            border-bottom: 2px solid hsl(327, 90%, 28%);
        }

        input::placeholder {
            color: transparent;
        }

        label {
            color: #757575;
            position: relative;
            left: 1.2em;
            top: -1.3em;
            cursor: auto;
            transition: 0.3s ease all;
        }

        input:focus ~ label,
        input:not(:placeholder-shown) ~ label {
            top: -3em;
            color: hsl(327, 90%, 28%);
            font-size: 15px;
        }

        .recover {
            text-align: right;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .recover a {
            text-decoration: none;
            color: rgb(125, 125, 235);
        }

        .recover a:hover {
            color: blue;
            text-decoration: underline;
        }

        .btn {
            font-size: 1.1rem;
            padding: 8px 0;
            border-radius: 5px;
            outline: none;
            border: none;
            width: 100%;
            background: rgb(125, 125, 235);
            color: white;
            cursor: pointer;
            transition: 0.9s;
        }

        .btn:hover {
            background: #07001f;
        }

        .links {
            display: flex;
            justify-content: space-around;
            padding: 0 4rem;
            margin-top: 0.9rem;
            font-weight: bold;
        }

        button {
            color: rgb(125, 125, 235);
            border: none;
            background-color: transparent;
            font-size: 1rem;
            font-weight: bold;
        }

        button:hover {
            text-decoration: underline;
            color: blue;
        }
    </style>
</head>
<body>
    
    <div id="app">
        <canvas></canvas>
        <div class="container" id="signup" style="display:none;">
            <div class="header"><i class="fa-solid fa-shoe-prints"></i> ShoeFy</div>
            <h1 class="form-title">Register</h1>
            <form method="post" action="register.php">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="fName" id="fName" placeholder="First Name" required>
                    <label for="fName">First Name</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="lName" id="lName" placeholder="Last Name" required>
                    <label for="lName">Last Name</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                <input type="submit" class="btn" value="Sign Up" name="signUp">
            </form>
            <div class="links">
                <p>Already Have Account ?</p>
                <button id="signInButton">Sign In</button>
            </div>
        </div>

        <div class="container" id="signIn">
            <div class="header"><i class="fa-solid fa-shoe-prints"></i> ShoeFy</div>
            <h1 class="form-title">Sign In</h1>
            <form method="post" action="register.php">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="signInEmail" placeholder="Email" required>
                    <label for="signInEmail">Email</label>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="signInPassword" placeholder="Password" required>
                    <label for="signInPassword">Password</label>
                </div>
                <p class="recover">
                    <a href="#">Recover Password</a>
                </p>
                <input type="submit" class="btn" value="Sign In" name="signIn">
            </form>
            <div class="links">
                <p>Don't have account yet?</p>
                <button id="signUpButton">Sign Up</button>
            </div>
        </div>
    </div>

    <script type="module">
        // Import the particle cursor
        import { particlesCursor } from 'https://unpkg.com/threejs-toys@0.0.8/build/threejs-toys.module.cdn.min.js'
                
        // Switch between sign-in and sign-up forms

        document.getElementById('signUpButton').addEventListener('click', () => {
            document.getElementById('signIn').style.display = 'none';
            document.getElementById('signup').style.display = 'block';
        });

        document.getElementById('signInButton').addEventListener('click', () => {
            document.getElementById('signup').style.display = 'none';
            document.getElementById('signIn').style.display = 'block';
        });

        const pc = particlesCursor({
            el: document.getElementById('app'),
            gpgpuSize: 512,
            colors: [0x00fffc, 0x0000ff], // Changed pink color to #00fffc and blue color
            color: 0xff0000,
            coordScale: 0.5,
            noiseIntensity: 0.005,
            noiseTimeCoef: 0.0001,
            pointSize: 1, // Lighter particle thickness
            pointDecay: 0.0025,
            sleepRadiusX: 250,
            sleepRadiusY: 250,
            sleepTimeCoefX: 0.001,
            sleepTimeCoefY: 0.002
        });

        let lastMouseMoveTime = 0;

        // Add event listener for cursor movement
        document.addEventListener('mousemove', () => {
            lastMouseMoveTime = Date.now();
            pc.material.visible = true; // Show particles when cursor is moving
        });

        // Update particle visibility and motion based on cursor movement
        function updateParticleState() {
            const currentTime = Date.now();
            if (currentTime - lastMouseMoveTime > 1000) { // 1 second of inactivity
                pc.material.visible = false; // Hide particles when cursor is not moving
            }
        }

        // Call the animate function periodically (e.g., requestAnimationFrame)
        function animate() {
            updateParticleState();
            requestAnimationFrame(animate);
        }

        animate(); // Start the animation loop
        
    </script>
</body>
</html>

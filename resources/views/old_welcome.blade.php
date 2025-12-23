

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden; /* Prevents scrolling */
        }
        .background {
            background-image: url('/img/main_logo.jpg'); /* Correct path without 'public' */
            background-repeat: no-repeat;
            background-size: contain; /* This ensures the image covers the entire area */
            background-position: center; /* This centers the image */
            height: 100vh; /* Adjust the height as necessary */
            width: 100%; /* Adjust the width as necessary */
        }
        .Header-wrap {
            display: flex;
            align-items: center;
            justify-content: end;
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
            padding-top: 30px;
        }
        .Header-wrap a {
            background-color: #000;
            padding: 10px 20px;
            margin-left: 10px;
            color: #E6C633 !important;
            text-decoration: none;
            font-size: 22px;
            font-family: system-ui;
            font-weight: 600;
            border-radius: 5px;
        }
    </style>

    <div class="background">
        <div class="Header-wrap">
            <a href="/login">Login</a>
            <a href="/business/register">Register</a>
        </div>
    </div>




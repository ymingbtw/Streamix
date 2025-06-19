<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Streamix API Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --primary: #8A2BE2;
            --secondary: #FF004F;
            --bg: #f3f4f6;
            --text: #111827;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            padding: 2rem;
        }

        .container {
            max-width: 768px;
            margin: auto;
            background: white;
            padding: 2rem 3rem;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        h1 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        h2 {
            color: var(--secondary);
            margin-top: 2rem;
        }

        code, pre {
            background-color: #f0f0f0;
            padding: 0.4rem 0.6rem;
            border-radius: 5px;
            font-family: 'Courier New', Courier, monospace;
        }

        ul {
            padding-left: 1.5rem;
        }

        li {
            margin-bottom: 0.5rem;
        }

        a {
            color: var(--primary);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .badge {
            background: var(--secondary);
            color: white;
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            margin-left: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Streamix API</h1>
        <p>Welcome to the backend API powering the <strong>Streamix</strong> platform — a modern streaming service built with Laravel and JWT authentication.</p>

        <h2>🌐 Base URL</h2>
        <p><code>https://yourdomain.com/api</code></p>

        <h2>🔐 Authentication</h2>
        <p>This API uses <strong>JWT (JSON Web Tokens)</strong> for stateless user authentication.</p>
        <p>Pass your token in the header like this:</p>
        <pre><code>Authorization: Bearer YOUR_TOKEN</code></pre>

        <h2>🧪 Sample Endpoints</h2>
        <ul>
            <li><code>POST /api/login</code> – Login and receive a JWT token <span class="badge">Public</span></li>
            <li><code>POST /api/register</code> – Create an account <span class="badge">Public</span></li>
            <li><code>GET /api/profile</code> – Get your user profile <span class="badge">Protected</span></li>
            <li><code>GET /api/videos</code> – Fetch all available streams <span class="badge">Protected</span></li>
        </ul>

        <h2>🛠 Tools</h2>
        <p>You can use <a href="https://www.postman.com/" target="_blank">Postman</a> or <a href="https://hoppscotch.io/" target="_blank">Hoppscotch</a> to test the API endpoints.</p>

        <h2>📈 Status</h2>
        <p

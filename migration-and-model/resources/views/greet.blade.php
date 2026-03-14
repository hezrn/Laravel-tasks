<!DOCTYPE html>
<html>
<head>
    <title>Greeting</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f3ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            color: #5b21b6;
            font-size: 40px;
        }
        p {
            color: #6d28d9;
            font-size: 18px;
        }
        a.button {
            margin-top: 20px;
            background-color: #7c3aed;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        a.button:hover {
            background-color: #6d28d9;
        }
    </style>
</head>
<body>

<h1>Hello, {{ $name }}!</h1>
<p>Welcome to Laravel!</p>

<a href="/tasks" class="button">Go to Tasks</a>

</body>
</html>
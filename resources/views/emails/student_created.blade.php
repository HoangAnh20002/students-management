<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        /* Reset CSS */
        body, h1, h2, h3, h4, h5, h6, p, ul, li {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .head{
            background-color: aliceblue;
            border-bottom: 1px solid;
            display: flex;
            padding: 10px 15px;
        }

        .img{
            width: 50px;
            height: 50px;
        }

        .name{
            font-size: 35px;
            font-weight: 600;
            padding-left: 12px;
        }

        .hello {
            font-size: 30px;
            margin-bottom: 20px;
        }

        .notice {
            font-size: 18px;
            margin-bottom: 10px;
        }

        ul {
            margin-left: 20px;
            margin-bottom: 20px;
        }

        li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="head">
        <img class="img" src="https://media.istockphoto.com/id/1334774891/vector/pineapple-fruit-icon-template-vector-illustration.jpg?s=612x612&w=0&k=20&c=pfKPp640PFSqDMy-j-HORlrOhCzi7aZGBRrQb7vYhfg=" alt="Logo">
        <div class="name">Apple University</div>
    </div>
    <p class="hello">Hello {{ $student_name }},</p>

    <p>Your student account has been created successfully.</p>

    <p class="notice">Your login credentials:</p>
    <ul>
        <li><strong>Login Mail:</strong> {{$email}}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>

    <p>Please use the above credentials to log in.</p>

    <p>Thank you!</p>
</div>
</body>
</html>

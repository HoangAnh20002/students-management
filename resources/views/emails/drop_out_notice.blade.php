<!DOCTYPE html>
<html lang="en">
<head>
    <style>
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
        .content{
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
        }
        .title{
            text-align: center;
            color: #333;
        }
        .end{
            font-size: 0.8em;
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="head">
        <img class="img" src="https://media.istockphoto.com/id/1334774891/vector/pineapple-fruit-icon-template-vector-illustration.jpg?s=612x612&w=0&k=20&c=pfKPp640PFSqDMy-j-HORlrOhCzi7aZGBRrQb7vYhfg=" alt="Logo">
        <div class="name">Apple University</div>
    </div>
    <div class="content">
        <h2 class="title">Notification: Drop out of university</h2>

        <p>Hello {{ $student_name }},</p>

        <p>Your final score was below average and you were dismissed</p>

        <p>Thank you.</p>

        <p class="end">This is an automated email. Please do not reply.</p>
    </div>
</div>
</body>
</html>

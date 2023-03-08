<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>verification notice</title>
        <style>
            *{
                box-sizing: border-box;
            }
            .container{
                width:500px;
                height:300px;
                padding:50px 10px;
                margin: 100px auto;
                background-color: whitesmoke;
            }
            .content{
                width: 80%;
                margin: auto;
                font-size: 26px;
                text-transform: capitalize;
                color: #666565;
            }
            .link{
                display: block;
                border-radius: 10px;
                padding: 10px;
                margin: 80px auto;
                width: 150px;
                background: brown;
                color: blanchedalmond;
                text-align: center;
                font-size: 20px;
                text-transform: capitalize;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <p class='content'>{{$content}}</p>
            <a class='link' href="{{route($homeRoute)}}">go back</a>
        </div>
    </body>
</html>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
<style>

    body{
        background-color: rgba(232, 231, 231, 0.949);
        font-family: Arial, Helvetica, sans-serif;
    }

    header{
        width: 100%;
        text-align: center;
        margin-bottom: 15px;
    }

    h2{
        width: 200px;
        margin: 0 auto;
        letter-spacing: 1px;
        font-size: 19px;
        padding: 15px;
        background-color:  #0d6efd;
        color: white;
        border-radius: 20px;
        text-align: center;
    }

    p{
        width: 100%;
        margin-top: 8px;
        text-align: center;
    }

</style>

</head>
<body>

        <header>
            <h2>Reset Password</h2>
        </header>
     
        <p> {{ $text_validate['message_email'] }} </p>
        
        <p> {{ $text_validate['return_email'] }} <a href="{{ route('password.reset', ['token'=>$token]) }}"> {{ $text_validate['here'] }} </a></p>

</body>
</html>  


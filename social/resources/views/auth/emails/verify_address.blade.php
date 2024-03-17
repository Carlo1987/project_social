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

    #main{
        width: 50%;
        margin: 0 auto;
        padding: 10px;
        padding-left: 15px;
        background-color: rgb(253, 244, 244);
        box-shadow: 1px 2px 8px rgb(160, 153, 153);
        border-radius: 20px;
    }

    .header{
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color:  #0d6efd;
        border-radius: 20px;
        color: white;
    }

    h2{
        letter-spacing: 1px;
        font-size: 19px;
    }

    p{
        margin-left: 10px;
    }

    .code{
        width: 40%;
        height: 35px;
        background-color:  #0d6efd;
        border-radius: 20px;
        margin: 0 auto;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .code a{
        text-decoration: none;
        color: white;
    }

    @media(max-width:500px){
        #main{
            width: 90%;
        }
    }

</style>

</head>
<body>

    <div id="main">
        <div class="header">
            <h2>Verifica Email</h2>
        </div>
     
        <p>Clicca nel link qui sotto per completare la registrazione:</p>

        <div class="code">
            <a href="{{ $url }}"> verifica </a>    
        </div>
        
     
    </div>
    </body>
</html>  


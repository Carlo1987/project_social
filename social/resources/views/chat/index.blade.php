<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <link rel="icon" type="image/jpeg" href="{{ asset('img/logo_facebook.jpeg') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.socket.io/4.7.5/socket.io.min.js" integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous"></script>
  <title>Progetto Social Chat</title>


  <style>
    body {
      background-color: rgba(222, 218, 218, 0.949);
    }

    h2 {
      margin-top: 15px;
      color: #0d6efd;
      text-align: center;
      font-size: 40px;
      letter-spacing: 1px;
      text-shadow: 1px 2px 2px rgb(48, 46, 46);
    }

    #messages {
      border: 2px solid rgb(23, 22, 22);
      box-shadow: 1px 1px 2px rgb(168, 161, 161);
      border-radius: 8px;
      width: 98%;
      overflow-y: visible;
      margin: 0 auto;
      min-height: 590px;
      background-color: white;
      list-style: none;
      display: flex;
      flex-direction: column;
    }

    #messages li {
      border: 1px solid black;
      border-radius: 10px;
      width: 85%;
      padding: 5px;
      margin-top: 6px;
      margin-bottom: 6px;
      display: flex;
      justify-content: space-between;
      box-shadow: 1px 1px 2px rgb(45, 44, 44);
    }

    .current_day {
      width: auto;
      padding: 10px;
      border: 1px solid black;
      border-radius: 10px;
      box-shadow: 1px 1px 2px rgb(45, 44, 44);
      background-color: rgba(232, 231, 231, 0.949);
      font-weight: bold;
      margin: 0 auto;
    }

    .message_friend {
      align-self: flex-start;
      background-color: rgba(232, 231, 231, 0.949);
    }

    .message_user {
      align-self: flex-end;
      margin-right: 40px;
      background-color: rgb(165, 209, 167);
    }

    form {
      width: 98%;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
    }

   #text_message {
      width: 90%;
      padding-left: 10px;
      border-radius: 5px;
      font-size: 30px;
    }

    img{
      width: 100%;
      height: 40px;
      border-radius: 900px;
    }

    @media(max-width:980px) {
      form input {
        width: 84%;
      }
    }

    @media(max-width:600px) {
      form input {
        width: 77%;
      }
    }
  </style>


</head>

<body>

  <div class="container">

    <?php
    $user_auth = $_GET['auth'];
    $user_friend = $_GET['friend'];
    ?>


    <h2> <i class="fa fa-facebook-square" aria-hidden="true"></i> Progetto Social - CHAT </h2>

    @if($user_auth == Auth::user()->id && $user_friend != '' || $user_friend == Auth::user()->id && $user_auth != '')

    <ul id="messages">
      <div class="current_day"> <!-- fatto con JS --> </div>
    </ul>

    <form action="" class="my-3">
      <input type="hidden" id="friend_id" data-friend_id="<?= $user_friend ?>">
      <input id="text_message" type="text" data-user_auth="<?= $user_auth ?>" />
      <button type="submit" class="btn btn-primary mb-2 px-4 fs-5">Invia</button>
    </form>

    @else
    <div class="alert alert-danger text-center fs-4" role="alert">
      Errore chat, chiudere e riprovare
    </div>
    @endif

  </div>




  <script>
    let socket = io.connect('http://localhost:3000');

    socket.on('connection');

    const messages = document.querySelector('#messages');
    const form = document.querySelector('form');
    const input_message = document.querySelector('#text_message');

    let newDate = new Date();

    let auth_id = input_message.getAttribute('data-user_auth');
    let friend_id = document.querySelector('#friend_id').getAttribute('data-friend_id');

    socket.emit('getMessages', {
      user1: auth_id,
      user2: friend_id
    });



    showMessages('getMessages');


    form.addEventListener('submit', (e) => {
      e.preventDefault();

      let message = input_message.value;
      let current_day = `${newDate.getDay()}/${newDate.getMonth()+1}/${newDate.getFullYear()}`;
      

      if (message != '') {

        let data = {
          user1: auth_id,
          user2: friend_id,
          text: message,
          day: current_day,
          hour: `${setNumberCalendary(newDate.getHours())}:${setNumberCalendary(newDate.getMinutes())}`
        };
 
        socket.emit("chat", data);
        message.innerHTML = ''; 

      }
    });


    showMessages('chat');




 


    function showMessages(url) {
      socket.on(url, (messages_users) => {

        let messages_list = "";

        messages_users.map(data => {
    
          if (auth_id == data.user1 && friend_id == data.user2 || auth_id == data.user2 && friend_id == data.user1) {
  
            let current_day = `${newDate.getDay()}/${newDate.getMonth()+1}/${newDate.getFullYear()}`;

            let style_message = "message_user";
            if (data.user1!= auth_id) style_message = "message_friend";
            const url_complete = `https://${document.location.hostname}/progetti/progetto_social/social/public/index.php/`;

            let li = `<li class="${style_message}"> 
            <div style="width:5%;"> <img src="${url_complete}user/getAvatar/1710855128deadpool.jpg"> </div>
                      <div style="width:80%;"> ${data.text} </div>
                      <div style="width:10%;"> ${data.hour} </div>
                      </li>`;
            messages_list += li;
          }
        })

        messages.innerHTML = messages_list;
        window.scrollTo(0, document.body.scrollHeight);

      })
    }



    function setNumberCalendary(number){
       let result = number;
       if(number < 10)   result = `0${number}`;
       return result;
    }




  </script>
</body>

</html>
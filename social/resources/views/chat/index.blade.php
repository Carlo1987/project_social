<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js" integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous"></script>
    <title>Chat Progetto Social</title>
</head>
<body>

<h2> Chat Progetto Social </h2>
    

<div class="container">

<div id="messages" class="d-flex flex-colums gap-2">
    @include('chat.receive', ['message' => 'Ora siamo amici'])
</div>


<div class="mt-2">
    <form id="form_chat">           <!--    method="POST" action="{{ route('sendMessage') }}" -->
      
      
        <input type="text" id="message" name="message" placeholder="Scrivi messaggio...">
        <input type="submit" value="Invia" id="buttonMessage">
    </form>
</div>

</div>



</body>


<script>
  // Pusher.logToConsole = true;
/* 
const pusher = new Pusher('8604a3dc2e69ed2ae97e', {  cluster: 'eu' });
const channel = pusher.subscribe('public');

channel.bind('chat', function(data){
    $.post("https://localhost/laravel/progetto_social/public/receive",{
        _token : '{{ csrf_token() }}',
        message : data.message,
    })
    .done(function(res){
        $(".messages > .message").last().after(res);
        $(document).scrollTop($(document).height());
    })
})


$('#form_chat').submit(function(e){
    e.preventDefault();
    
    $.ajax({
        url : 'https://localhost/laravel/progetto_social/public/broadcast',
        method : 'POST',
        headers : {
            'X-Socket-Id' : 1759524
        },
        data : {
            _token : '{{ csrf_token() }}',
            message : $('#message').val(),
        }
    }).done(function(res){
        $('.messages > .message').last().after(res);
        $('#message').val('');
        $(document).scrollTop($(document).height());
    })
})
 */


/*  $(function(){
    let ip_address = "192.168.1.51";
    let port = "3000";

    let socket = io(ip_address+":"+port);

    socket.on("connection");

    $('#buttonMessage').click(function(){
        let message = "messagio di testo";
        socket.emit("send_to_server",message);
    })

    socket.on("sent_to_client",function(message){
        console.log(message);
    })


 })  */

</script>


</html>














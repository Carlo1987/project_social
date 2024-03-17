<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <title>Document</title>
</head>
<body>
    

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


</script>


</html>














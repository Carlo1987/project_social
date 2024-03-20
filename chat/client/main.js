const ip = "192.168.1.51";
const port = '3000';

//const socket = io.connect('http://'+ip+":"+port, {'forceNew':true}); 
const socket = io(ip+":"+port);

//const socket = io();

socket.on('messages',function(data){
    show_messages(data);
});


function show_messages(messages){
    console.log(messages);
}


function add_message(e){

    let message = {
        user : 'utente',
        text : "testo dell'utente"
    }

    socket.emit('add-message',message);
    return false;
}
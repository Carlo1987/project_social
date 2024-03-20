const express = require('express');
const app = express();

const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors : {origin:"*"}
});

//const database = require('./database');

app.use(express.static('client'));

let messages = [{
    user : 'Carlo',
    text : "Ora siamo amici!!"
}];

io.on("connection", (socket)=>{
   /// console.log("L'utente con IP "+ socket.handshake.address + " si è connesso...");
   console.log('chat attiva');

    socket.emit('messages',messages);

    /* socket.on("send_to_server", (message)=>{
        console.log(message);
        io.sockets.emit("send_to_client", message);
    }) */
    socket.on("add-message", (message)=>{
        messages.push(message);
        socket.emit('messages',messages);
    })

 
})

const port = 3000;

server.listen(port, ()=>{
    console.log('Server attivo nella porta '+port);
})
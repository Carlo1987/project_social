const express = require('express');
const app = express();

const http = require('http');
const server = http.createServer(app);

const { Server } = require('socket.io');
const io = new Server(server);


io.on('connection', (socket) => {
    
    socket.on('chat',(message)=>{
        io.emit('chat',message);
    });

});



app.get('/Progetto_social-Chat',(req,res)=>{
    res.sendFile(`${__dirname}/client/index.html`);
})



//const database = require('./database');


const port = 3000;

server.listen(port, ()=>{
    console.log('Server attivo nella porta '+port);
})
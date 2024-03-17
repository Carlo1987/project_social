const express = require('express');
const app = express();

const server = require('http').Server(app);
const io = require('socket.io')(server);

const database = require('./database');


server.listen(3700, ()=>{
    console.log('Server della chat progetto_social in funzione');
})
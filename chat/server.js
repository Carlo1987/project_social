const express = require('express');
const app = express();

const executeQuery = require('./database');


const session = require('express-session');

app.use(session({
    secret : "Ilbacala",
    resave : false,
    saveUninitialized : false
}));



const http = require('http');
const server = http.createServer(app);

const io = require('socket.io')(server, {
    cors: {origin : "*"}
})



 let messages = [];


io.on('connection', (socket) => {    
    
    socket.on('getMessages', (data)=>{
        executeQuery(`SELECT * FROM chats WHERE user1='${data.user1}' AND user2='${data.user2}' OR user1='${data.user2}' AND user2='${data.user1}'`, function(error,result){
            if(error){
                console.log(error);
            }else{           
                messages = result;
                console.log(messages);
                io.emit('getMessages',messages);
            }
         
        })
    }) 
    
   
    
    socket.on('chat',(data)=>{
        executeQuery(`INSERT INTO chats VALUES(null,'${data.user1}','${data.user2}','${data.text}','${data.day}','${data.hour}')`, function(error){
            if(error){
                console.log(error);
            }else{
                messages.push(data);
                io.emit('chat',data);
                console.log(`Inviato da ${data.user1} a ${data.user2} messaggio : ${data.text}`);
            }
        });
    }); 

});



app.get('/',()=>{
    console.log('Utente connesso');
})


const port = 3000;

 server.listen(port, ()=>{
    console.log('Server attivo nella porta '+port);
}) 


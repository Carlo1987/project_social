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

const { Server } = require('socket.io');
const io = new Server(server); 



io.on('connection', (socket) => {     
    console.log('utente connesso');  
    
    socket.on('chat',(data)=>{
        io.emit('chat',data.message);
        console.log(`utente ${data.id} messaggio : ${data.message}`);
    });

});


app.get('/Progetto_Social-Chat',(req,res)=>{

    req.session.users = {
        user :  req.query.user,
        friend : req.query.friend
    }

    executeQuery("select * from users where id="+req.query.user, (error,result)=>{
        if(error){
          console.log('errore: '+error);
        }else{
            console.log(result[0].name);
        }
    }) 

     res.sendFile(`${__dirname}/client/index.html`);  
})



const port = 3000;

server.listen(port, ()=>{
    console.log('Server attivo nella porta '+port);
})
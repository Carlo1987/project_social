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




io.on('connection', (socket) => {      
    
    socket.on('chat',(data)=>{
        executeQuery(`INSERT INTO chats VALUES(null,'${data.user1}','${data.user2}','${data.text}','${data.day}','${data.hour}')`, function(error){
            if(error){
                console.log(error);
            }else{
              showMessages(data,'chat');
            }
        });
    }); 




    socket.on('deleteMessage',(data)=>{
        executeQuery(`DELETE FROM chats WHERE id = ${data.id}`,(error)=>{
            if(error){
                console.log(error);
            }else{
                showMessages(data,'deleteMessage');
            }
        })
    })
   
});



function showMessages(data,url){
    executeQuery(`select day from chats WHERE user1=${data.user1} AND user2=${data.user2} OR user1=${data.user2} AND user2=${data.user1}  group by day`, function(error,days){
        if(error){
            console.log(error);
        }else{
            executeQuery(`SELECT * FROM chats WHERE user1='${data.user1}' AND user2='${data.user2}' OR user1='${data.user2}' AND user2='${data.user1}'`, function(error,result){
                if(error){
                    console.log(error);
                }else{

                    let messages = {
                        days : days,
                        messages : result
                    }

                    io.emit(url,messages);
                    if(url =='chat'){
                        console.log(`Inviato da ${data.user1} a ${data.user2} messaggio : ${data.text}`);
                    }else{
                        console.log(`messaggio ${data.id} eliminato`);
                    }
                }
             });
        }
     })

}



const port = 3000;

 server.listen(port, ()=>{
    console.log('Server attivo nella porta '+port);
}) 


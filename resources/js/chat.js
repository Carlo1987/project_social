
import servers from "./servers";


export default function chat(){

const url_complete = servers().url_complete; 
const socket_server = servers().socket;


let buttons_chat = document.querySelectorAll('.button_chat');
let number_messages = document.querySelectorAll('.number_messages span');   

buttons_chat.forEach((button_chat,i)=>{

button_chat.onclick = function(){


    let friend = this.getAttribute('data-friend');
    let user = this.getAttribute('data-user');
    let friend_name = this.getAttribute('data-friend_name');



    if(user != friend){

        const messages = document.querySelectorAll('.container_chat');
        const form = document.querySelectorAll('.form_chat');
        const input_message = document.querySelectorAll('.auth_data');   
       
    

        let socket = io.connect(socket_server);

        socket.on('connection');

        let data = {
            user1 : user,
            user2 : friend
        }

        socket.emit('show_messages',data);
        socket.emit('update_views',data);
    
        let newDate = new Date();
  
       let auth_id = button_chat.getAttribute('data-user');
       let friend_id = button_chat.getAttribute('data-friend');     
    
        form[i].addEventListener('submit', (e) => {
          e.preventDefault();
    
          let current_day = `${newDate.getDate()}/${newDate.getMonth()+1}/${newDate.getFullYear()}`;
    
    
          if (input_message[i].value != '') {
    
            let data = {
              user1: auth_id,
              user2: friend_id,
              text: input_message[i].value,
              day: current_day,
              hour: `${setNumberCalendary(newDate.getHours())}:${setNumberCalendary(newDate.getMinutes())}`
            };
     
            socket.emit("chat", data);
          }
        });
    

        showMessages('show_messages');
        showMessages('chat');
        showMessages('deleteMessage');                
    
    
        function showMessages(url) {
              
          socket.on(url, (response) => {
      
            let days = response.days;
            let messages_data = response.messages;

    
            function getData(value){
              return button_chat.getAttribute(value);
            }
            let messages_list = "";
    
            days.map(day=>{

    
            messages_list += `<div class="day_chat"> ${setDay(day.day)}  </div> `;
    
            messages_data.map(data=>{
            
              if (auth_id == data.user1 && friend_id == data.user2 && day.day == data.day || auth_id == data.user2 && friend_id == data.user1 && day.day == data.day ) {
      
                let li = `
                <li class="d-flex flex-column p-2 message message_user"> 
                  <div class="ms-1 w-100  d-flex flex-row justify-content-between align-items-center">
                    <div  class="user_chat">
                       <img src="${url_complete}user/getAvatar/${getData('data-auth_img')}">
                       ${getData('data-auth_nick')}
                    </div>
                    <div class="d-flex flex-row justify-content-evenly hour_chat">
                       ${data.hour}
                       <i class="fa-regular fa-trash-can delete_chat" data-id="${data.id}"></i>
                    </div>
                  </div>
                  <div style="width: 100%; border-top:1px solid black; margin-top:3px;">
                    <div style="width: 90%; margin:0 auto;">
                    ${data.text}
                    </div>
                  </div>
               </li>
                `;
    
                if (data.user1 != auth_id){
                  
                 li = `
                <li class="d-flex flex-column p-2 message message_friend"> 
                  <div class="ms-1 w-100  d-flex flex-row justify-content-between align-items-center">
                    <div  class="user_chat">
                       <img src="${url_complete}user/getAvatar/${getData('data-friend_img')}">
                       ${getData('data-friend_nick')}
                    </div>
                    <div  class="hour_chat">
                    ${data.hour}
                    </div>
                  </div>
                  <div style="width: 100%; border-top:1px solid black; margin-top:3px;">
                    <div style="width: 90%; margin:0 auto;">
                    ${data.text}
                    </div>
                  </div>
               </li>
                `;
                }  
                messages_list += li;        
              }
             
              })
    
           })

           messages[i].innerHTML = messages_list;
           
         
      
           let li = document.querySelectorAll('.message');
           
           if(li.length == 0){
               let text = "Manda un messaggio a ";
               if(sessionStorage.getItem('lang'))  text = JSON.parse(sessionStorage.getItem('lang')).chat.friend;
               messages[i].innerHTML = `
               <div class="alert alert-success text-center fs-5" role="alert"> 
                   <span class="lang" data-section ="chat" data-article="friend"> ${text} </span> ${friend_name} 
               </div>
               `;
           }


 
           console.log(friend_id);
           
          number_messages.forEach(span=>{
            let id_span = span.getAttribute('data-friend');
            if(id_span == friend_id)   span.style.display = 'none';
          })
          
           

          

           input_message[i].innerHTML = '';
           location.href = "#form_chat";   

    
           let delete_chat = document.querySelectorAll('.delete_chat');

           delete_chat.forEach(button=>{
              button.onclick = function(){
                let id = this.getAttribute('data-id');

                let data = {
                    id : id,
                    user1 :  auth_id,
                    user2 :  friend_id
                  }
                  socket.emit('deleteMessage',data);
              }
           })
        
          })

    
        }

   
    
    
   
    
        function setNumberCalendary(number){
           let result = number;
           if(number < 10)   result = `0${number}`;
           return result;
        }
    
    
    
        function setDay(date){
          let dateSplit = date.split('/');
          let mounths = ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'];
          if(sessionStorage.getItem('lang'))  mounths = JSON.parse(sessionStorage.getItem('lang')).mounths;
          return `${dateSplit[0]} ${mounths[parseInt([dateSplit[1]])-1]} ${dateSplit[2]}`;
        }
    
    }     
}


})



}
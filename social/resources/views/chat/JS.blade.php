
<script>


        //////////////      CHAT    /////////////////////////  

        let socket = io.connect('http://localhost:3000');

        socket.on('connection');
    
        const messages = document.querySelector('.container_chat');
        const form = document.querySelector('.form_chat');
        const input_message = document.querySelector('.auth_data');
        const input_hidden =  document.querySelector('.friend_data');
    
    
        let newDate = new Date();
    
        let auth_id = input_message.getAttribute('data-auth_id');
        let friend_id = input_hidden.getAttribute('data-friend_id');
     
    
    
        form.addEventListener('submit', (e) => {
          e.preventDefault();
    
          let current_day = `${newDate.getDay()}/${newDate.getMonth()+1}/${newDate.getFullYear()}`;
    
    
          if (input_message.value != '') {
    
            let data = {
              user1: auth_id,
              user2: friend_id,
              text: input_message.value,
              day: current_day,
              hour: `${setNumberCalendary(newDate.getHours())}:${setNumberCalendary(newDate.getMinutes())}`
            };
     
            socket.emit("chat", data);
          }
        });
    
    
    
        showMessages('chat');
        showMessages('deleteMessage'); 
        location.href = "#form_chat";    
    


        function deleteChats(id){
    
            let data = {
             id : id,
             user1 :  auth_id,
             user2 :  friend_id
           }
           socket.emit('deleteMessage',data);
        }
       
    
    
        function showMessages(url) {
    
          socket.on(url, (response) => {
    
            let days = response.days;
            let messages_data = response.messages;
    
            let messages_list = "";
    
    
            days.map(day=>{
    
            messages_list += `<div class="day_chat"> ${setDay(day.day)}  </div> `;
    
            messages_data.map(data=>{
               
              if (auth_id == data.user1 && friend_id == data.user2 && day.day == data.day || auth_id == data.user2 && friend_id == data.user1 && day.day == data.day ) {
      
                const url_complete = `https://${document.location.hostname}/progetti/progetto_social/social/public/index.php/`;
    
                let li = `
                <li class="d-flex flex-column p-2 message_user"> 
                  <div class="ms-1 w-100  d-flex flex-row justify-content-between align-items-center">
                    <div  class="user_chat">
                       <img src="${url_complete}user/getAvatar/${input_message.getAttribute('data-auth_img')}">
                       ${input_message.getAttribute('data-auth_nick')}
                    </div>
                    <div class="d-flex flex-row justify-content-evenly hour_chat">
                       ${data.hour}
                       <i class="fa-regular fa-trash-can delete_chat" data-id="${data.id}" onclick="deleteChats(${data.id})"></i>
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
                <li class="d-flex flex-column p-2 message_friend"> 
                  <div class="ms-1 w-100  d-flex flex-row justify-content-between align-items-center">
                    <div  class="user_chat">
                       <img src="${url_complete}user/getAvatar/${input_hidden.getAttribute('data-friend_img')}">
                       ${input_hidden.getAttribute('data-friend_nick')}
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
    
                messages.innerHTML = messages_list;
                input_message.innerHTML = '';
                location.href = "#form_chat";
              
              }
    
            })
    
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
          const mounths = ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'];
          return `${dateSplit[0]} ${mounths[parseInt([1])-1]} ${dateSplit[2]}`;
        }
    




</script>
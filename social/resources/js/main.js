import { Axios } from "axios";

let project_name = "progetto_social";

const url = `https://${document.location.hostname}/progetti/${project_name}/social/public/`;
const url_complete = `https://${document.location.hostname}/progetti/${project_name}/social/public/index.php/`;
const url_files = `https://${document.location.hostname}/progetti/${project_name}/social/storage/app/`;

window.addEventListener("load", function () {






   //////////////      BOTTONI PER DOWNLOAD DELLA LISTA DEGLI UTENTI   /////////////////////////

    const download_button= document.querySelectorAll('.download');
    const downloadHover = this.document.querySelector('.downloadHover');

    downloadHover.addEventListener('mouseover', function(){
        let theme = downloadHover.getAttribute('data-theme');
        let div = document.createElement('div');
        div.className = 'button_download '+theme;

        let html = `<div>clicca qui per scaricare la lista degli utenti</div>`

        div.insertAdjacentHTML('afterbegin', html);
        downloadHover.insertAdjacentElement('afterend',div);

        downloadHover.addEventListener('mouseout', ()=>{
            div.remove();  
        })

       
    })

    
    download_button.forEach(download=>{
        download.onclick = function(){
            window.open(url_complete+'download');
         }
    })





    //////////////       LIKE  IMMAGINI E VIDEO    /////////////////////////   

    let likes = document.querySelectorAll("#heart");     //  immagini del "cuore", Like

    function like_function(index, class_removed, class_added , data){     
        let counts = document.querySelectorAll('.count');    // span che contiene numero totale likes           
        let like_users_menus = document.querySelectorAll('.likes_count ul');  // menù a tendina contenente gli utenti che hanno messo like
        let id = likes[index].getAttribute("data-id");

        likes[index].classList.remove(class_removed);
        likes[index].classList.add(class_added);
        counts[index].innerHTML = parseInt(counts[index].textContent) + 1;
        likes[index].setAttribute("src", url+"img/red_heart.png");

         fetch(url_complete + class_added + "/" + id)
            .then((response) => response.json())
            .then((dates) => {

                let li = `<li class="likes_users" ${data}="${id}" >
                <div> <img scr="${url_complete}user/getAvatar/${dates.user_img}" > </div>
                <div> <a href="${url_complete}users/${dates.user_id}">
                     @${dates.user_nick}
                 </a> </div> </li> `;

                 like_users_menus[index].insertAdjacentHTML('afterbegin', li);
                }); 
    }



    function dislike_function(index , class_removed , class_added , data_file){
        let counts = document.querySelectorAll('.count');    // span che contiene numero totale likes
        let like_users = document.querySelectorAll('.likes_users');  //  utenti che hanno messo il like
        let id = likes[index].getAttribute("data-id");
   
        likes[index].classList.remove(class_removed);
        likes[index].classList.add(class_added);
        counts[index].innerHTML = parseInt(counts[index].textContent) - 1;
        likes[index].setAttribute("src", url+"img/black_heart.png");

        fetch(url_complete + class_added + "/" + id)
            .then((response) => response.json())
            .then((data) =>{

                like_users.forEach((element,index)=>{
                  let nick = element.innerText;
                  nick = nick.trim().split('');
                  nick.shift();
                  nick = nick.join('');
           
                    let file_id = element.getAttribute(data_file);
                  
                    if(file_id == data.file && nick == data.nick){
                        like_users[index].style.display = "none";
                    }
            })
        });
    }
        

    likes.forEach((heart, index) => {
        heart.addEventListener("click", () => {
       

            if (likes[index].className == "dislike_image") {

                like_function(index , "dislike_image", "like_image" , "data-imageID");             

            } else if (likes[index].className == "like_image") {

               dislike_function(index , "like_image" , "dislike_image" , "data-imageID");

            } else if (likes[index].className == "dislike_video") {

                like_function(index , "dislike_video", "like_video" , "data-videoID");

            } else if (likes[index].className == "like_video") {

                dislike_function(index , "like_video" , "dislike_video" , "data-videoID");
       
            }
        });
    });



///////////////////////////////      CANCELLARE  IMMAGINI    /////////////////////////////////////////
let destroy_image = this.document.querySelectorAll('.destroy_image');

destroy_image.forEach((button)=>{
    button.addEventListener('click',()=>{
        let id = button.getAttribute("data-id");
        
        let div = document.createElement('div');
        div.className = 'confirm';
          
        let html = `
        <div class="text-danger "> Attenzione!! </div>
        <div>Cancellando l'immagine, cancellerai anche <strong>Likes</strong> e <strong>commenti</strong>. <br>
        Sei sicuro di voler continuare? </div> 
        <div class="confirm_choise">
           <div> <input type="submit" class="rejection btn btn-primary" value="Ho cambiato idea"> </div>
           <div> <input type="submit" class="accept btn btn-danger" value="Si, sono sicuro"> </div>
        </div>`

        div.insertAdjacentHTML('afterbegin', html);
        button.insertAdjacentElement('afterend',div);

        let rejection = document.querySelector('.rejection');
        let accept = document.querySelector('.accept');

        rejection.onclick = function(){
            div.remove();
        }

        accept.onclick = function(){
            fetch(url_complete + "image/delete/" + id)
            .then((response) => response.json())
            .then((dates) => window.location.href = url_complete+"image/detail/"+dates.last_image)
          
            div.remove(); 
        }
    });

})



///////////////////////////////      CANCELLARE  VIDEO    /////////////////////////////////////////
let destroy_video = this.document.querySelectorAll('.destroy_video');

destroy_video.forEach((button)=>{
    button.addEventListener('click',()=>{
        let id = button.getAttribute("data-id");
        
        let div = document.createElement('div');
        div.className = 'confirm';
          
        let html = `
        <div class="confirm_title text-danger "> Attenzione!! </div>
        <div class="confirm_test">Cancellando il video, cancellerai anche <strong>Likes</strong> e <strong>commenti</strong>. <br>
        Sei sicuro di voler continuare? </div> 
        <div class="confirm_choise">
           <div> <input type="submit" class="rejection btn btn-primary" value="Ho cambiato idea"> </div>
           <div> <input type="submit" class="accept btn btn-danger" value="Si, sono sicuro"> </div>
        </div>`

        div.insertAdjacentHTML('afterbegin', html);
        button.insertAdjacentElement('afterend',div);

        let rejection = document.querySelector('.rejection');
        let accept = document.querySelector('.accept');

        rejection.onclick = function(){
            div.remove();
        }

        accept.onclick = function(){
            fetch(url_complete + "video/delete/" + id)
            .then((response) => response.json())
            .then((dates) => window.location.href = url_complete+"video/detail/"+dates.last_video)
          
            div.remove(); 
        }
    });
})




/*    SCELTA MENU RESPONSIVE     */

const button_image = document.querySelector('#button_images_responsive');
const button_video = document.querySelector('#button_videos_responsive');
const container_images = document.querySelector('#images_responsive');
const container_videos = document.querySelector('#videos_responsive');

    button_video.onclick = function(){
        container_videos.style.display = "block";
        container_images.style.display = "none";
        button_video.style.textDecoration = "underline";
        button_video.style.border = "4px solid black";
        button_image.style.textDecoration = "none";
        button_image.style.border = "1px solid black";
    }

    button_image.onclick = function(){
        container_videos.style.display = "none";
        container_images.style.display = "block";
        button_video.style.textDecoration = "none";
        button_video.style.border = "1px solid black";
        button_image.style.textDecoration = "underline";
        button_image.style.border = "4px solid black";
    }




    
       //////////////      BOTTONE CHAT   /////////////////////////


       const buttonChat = this.document.querySelector('.buttonChat');

       buttonChat.onclick = function(e){
           e.preventDefault();
            let user_id = buttonChat.getAttribute('data-user_id');
           let friend_id = buttonChat.getAttribute('data-friend_id');

           localStorage.setItem('user_auth',user_id); 
           window.open(`${url_complete}chat?auth=${user_id}&friend=${friend_id}`);
       } 




///////////////////////////////     ALLERTE RICHIESTE DI AMICIZIA    /////////////////////////////////////////

let button = document.querySelector('.button_friendship');

button.addEventListener("mouseover", function(){
    let user = document.querySelector('.friend_ID');
    let user_ID = user.getAttribute('data-friend');

    let div = document.createElement('div');
    div.className = 'confirm_friedship';
     
    if(parseInt(user_ID) != 1 && parseInt(user_ID) <= 19){       //   utenti  fittizzi
            
        let html = `
        <div>
           Questo è un utente fittizzio quindi, in questo caso, <br>
           <u><span style="color: green;">la tua richiesta verrà automaticamente accettata</span> </u>
        </div> `
        
        div.insertAdjacentHTML('afterbegin', html);
        button.insertAdjacentElement('afterend',div);

    }else{      //  utenti  reali
                
        let html = `
        <div>
           Questo è un utente reale quindi, in questo caso, <br>
           <u><span style="color: green;">dovrai aspettare che la tua richiesta venga accettata</span> </u>
        </div> `

        div.insertAdjacentHTML('afterbegin', html);
        button.insertAdjacentElement('afterend',div);
    }

    button.addEventListener('mouseout', function(){
        div.remove();
    })

})




});

import { ita } from "./ita";
import { esp } from "./esp";

 let host = "localhost"; 
let project_name = "progetti/progetto_social/social/public";   

/* let host = "carloloidev.com"; 
let project_name = "Project_Social/public";   */
 

const url = `https://${host}/${project_name}/`;
const url_complete = `https://${host}/${project_name}/index.php/`; 



window.addEventListener("load", function () {

 //////////////      SCEGLIERE LA LINGUA      /////////////////////////

    const flag = document.querySelector('#flag_language');
    let language = ita;

       
    function getLanguage(language){
        let sectiones = document.querySelectorAll('.lang');

        sectiones.forEach(section=>{
            let argument = section.getAttribute('data-section');
            let article = section.getAttribute('data-article');
            
            section.innerHTML = language[argument][article];
        })
    }



     function setFlag(language){
         if(language.language == 'esp'){
            flag.setAttribute('src', url+'img/bandiera_spagna.png');
        }else if(language.language == 'ita'){
            flag.setAttribute('src', url+'img/bandiera_italia.png');
        }
    }
 


    function setValidate(language){
        setFlag(language);
        setPlaceholder(language);
        let inputs_validate = document.querySelectorAll('.lang_validate');
        inputs_validate.forEach(input=>{
            input.setAttribute('value',JSON.stringify(language.validate));
           }) 
    }


    function setPlaceholder(language){
        let placeholders = document.querySelectorAll('.lang_placeholder');
        placeholders.forEach(placeholder=>{
            let argument = placeholder.getAttribute('data-section');
            let article = placeholder.getAttribute('data-article');
            placeholder.setAttribute('placeholder', language[argument][article]);
        })
       
    }


    function setLanguage(input){
        let data_language = input.getAttribute('data-language');

        if(data_language == 'esp'){
            language = esp; 
        }else if(data_language == 'ita'){
            language = ita; 
        }

        sessionStorage.setItem('lang',JSON.stringify(language));

        getLanguage(language);

        setValidate(language);
    }



    if(sessionStorage.getItem('lang')){
        let language = JSON.parse(sessionStorage.getItem('lang'));
        getLanguage(language);
        setValidate(language); 
    }else{
        setValidate(ita);
    }



    const flag_ita = document.querySelector('#ita');
    const flag_esp = document.querySelector('#esp');

    flag_ita.onclick = function(e){
        e.preventDefault();
        setLanguage(flag_ita);
    }

    flag_esp.onclick = function(e){
        e.preventDefault();
        setLanguage(flag_esp);
    }





   //////////////      BOTTONI PER DOWNLOAD DELLA LISTA DEGLI UTENTI   /////////////////////////

    const download_button= document.querySelectorAll('.download');
    const downloadHover = this.document.querySelector('.downloadHover');

    downloadHover.addEventListener('mouseover', function(){
        let theme = downloadHover.getAttribute('data-theme');
        let div = document.createElement('div');
        div.className = 'button_download '+theme;

        let text = ita.nav.download;;

        if(sessionStorage.getItem('lang')){
            text = JSON.parse(sessionStorage.getItem('lang')).nav.download;
        }

        let html = `<div>${text}</div>`

        div.insertAdjacentHTML('afterbegin', html);
        downloadHover.insertAdjacentElement('afterend',div);

        downloadHover.addEventListener('mouseout', ()=>{
            div.remove();  
        })

       
    })

    
    download_button.forEach(download=>{
        download.onclick = function(){
            let lang = "ita";      
            if(sessionStorage.getItem('lang'))   lang = JSON.parse(sessionStorage.getItem('lang')).language; 
            window.open(url_complete+'download?lang='+lang);
         }
    })
    




    //////////////      MENU CARICAMENTO FILES (immagini e video)  /////////////////////////

          const upload_file = document.querySelector('#upload_files');
          const menu_files = document.querySelector('.menu_files');
     
          function upload_files(div,event,action){
             div.addEventListener(event,()=>{
                 menu_files.style.display = action;
              });
          }
       
          upload_files(upload_file,'mouseover','block');
          upload_files(menu_files,'mouseover','block');
          upload_files(menu_files,'mouseout','none');
      

   



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
        likes[index].setAttribute("src",url+ "img/black_heart.png");

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



///////////////////////////////      CANCELLARE  IMMAGINI E VIDEO    /////////////////////////////////////////


if(window.location.href.indexOf('detail') > -1){

    const container_menu_detail = document.querySelector('.container_menu_detail');
    const menu_detail = document.querySelector('.menu_detail_image');

    let click_menu_detail = false;

    function animation_detail(color,translate,opacity){
      container_menu_detail.style.backgroundColor = color;
      if(color != 'transparent'){
        container_menu_detail.style.borderRadius = "100px";
        container_menu_detail.style.boxShadow = "1px 2px 8px rgb(160, 153, 153)";
      }else{
        container_menu_detail.style.borderRadius = "transparent";
        container_menu_detail.style.boxShadow = "none";
      }
      gsap.to('.menu_detail',{                  
            duration : 1,                      
            y : translate,  
            opacity : opacity                                               
      }); 
    }

    menu_detail.onclick = function(){
        if(!click_menu_detail){
            animation_detail("rgba(232, 231, 231, 0.949)",100,1);
            click_menu_detail = true;
        }else{
            animation_detail("transparent",0,0);
            click_menu_detail = false;
        }
    
    }




let destroyFile = this.document.querySelectorAll('.destroy_file');

destroyFile.forEach((button)=>{
    button.addEventListener('click',()=>{
        let id = button.getAttribute("data-id");
        let type = button.getAttribute('data-type');
        
        let div = document.createElement('div');

        let type_text = ita.files.image;   
        let type_file = "image";

       if(type == 'video'){
        type_file = ita.files.video;
        type_file = "video";
       }

       let text = ita.delete_files;

       if(sessionStorage.getItem('lang')){
        let lang = JSON.parse(sessionStorage.getItem('lang'));
        text = lang.delete_files;
        type_text = lang.files.image;
        if(type == 'video'){
            type_text = lang.files.video;
        }
       }
 
          
        let html = `<div class="confirm">
        <h3> ${text.warning} </h3>
        <div>${text.deleting} ${type_text}, ${text.delete} <strong class="text-danger">Likes</strong> ${text.and} <strong class="text-danger">${text.comments}</strong>. <br>
        ${text.sure}? </div> 
        <div class="confirm_choise">
           <div> <input type="submit" class="rejection btn btn-primary" value="${text.no}"> </div>
           <div> <input type="submit" class="accept btn btn-danger" value="${text.yes}"> </div>
        </div>
        </div>`

        div.insertAdjacentHTML('afterbegin', html);
        button.insertAdjacentElement('afterend',div);

        let rejection = document.querySelector('.rejection');
        let accept = document.querySelector('.accept');

        rejection.onclick = function(){
            div.remove();
        }

        accept.onclick = function(){
            fetch(url_complete + `${type_file}/delete/` + id)
            .then((response) => response.json())
            .then((dates) => window.location.href = url_complete+`${type_file}/detail/${dates.last_file}`)
          
            div.remove(); 
        }
    });
})

}


////////////////////////////////////    AGGIUNGERE IMMAGINI , VIDEO E AVATAR   //////////////////////////  

if(window.location.href.indexOf('create') > -1 || window.location.href.indexOf('avatar') > -1 ){
    let input_files = document.querySelector('.change_file');

    input_files.addEventListener('change',(input)=>{
        let file = input.target.files[0];
        let input_name = document.querySelector('.name_file');
        input_name.innerHTML = ` <i class="fa fa-picture-o fa-lg me-1" aria-hidden="true"></i>  ${file.name}`; 
     });
}



///////////////////////////////////////    SCELTA FILES CON MENU RESPONSIVE   ///////////////////////////////

const arrow_files = document.querySelector('.arrow_files');   
const button_image = document.querySelector('#button_images_responsive');
const button_video = document.querySelector('#button_videos_responsive');
const container_images = document.querySelector('.content_images');
const container_videos = document.querySelector('.content_videos');


const mqLarge = window.matchMedia( '(min-width: 993px)' ); 
mqLarge.addEventListener('change', mqHandler);


function responsiveFiles(display , display_images , display_arrow){
    const titles = document.querySelectorAll('.titles');
    titles.forEach(title=>{
        title.style.display = display;
        title.style.marginBottom = "18px";
    })
    container_videos.style.display = display;
    container_images.style.display = display_images;

    if(window.location.href.indexOf('users') > -1){
          arrow_files.style.display = display_arrow;
    }
}


function mqHandler(e) {
    if(e.matches){
        responsiveFiles('block','block','none');
    }else{
        responsiveFiles('none','block','block');
    }
}

mqHandler(mqLarge);

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



    function animation_responsive(rotacion , translateY){
        let tl = gsap.timeline({  
            duration : 0.7,               
            repeat : 0,                             
       });

        tl.to('.arrow_image',{                                         
            rotate : rotacion                                                 
       },'-=0.6');

        tl.to('.nav_responsive',{                                         
            y : translateY,
            opacity : 1                                                    
       },'-=0.6');
    }

    let move_animation = false;

    arrow_files.onclick = function(){
        if(!move_animation){
          animation_responsive(180,70);
          move_animation = true;
        
        }else{
           animation_responsive(0,-10);
           move_animation = false;
        }
    }




  //////////////       NASCONDERE MENU UTENTI FITTIZZI     /////////////////////////   


    const menu_hidden = document.querySelectorAll('.menu_hidden');
  
    menu_hidden.forEach(element=>{
        let id = element.getAttribute('data-user');
        if(id != 1 || id <= 18){
            element.style.display = 'none';
        }else{
            element.style.display = 'block';
        }
        
    })




     //////////////       COLLEGAMENTO RISPOSTA AMICIZIA    /////////////////////////   


     if(window.location.href.indexOf('users') > -1){

        let answer = document.querySelector('.answer_friend');
  
        answer.onclick = function(){
            window.location.href = `${url_complete}friendships`;
        }
    }





    








});

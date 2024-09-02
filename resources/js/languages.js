
import { ita } from "./ita";
import { esp } from "./esp";
import servers from "./servers";


const url = servers().url;


export default function languages(){


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

}
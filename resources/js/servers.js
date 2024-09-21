/*  
const host = "localhost"; 
const project_name = "progetti/progetto_social/social/public";   
const socket_server = 'http://localhost:3000';
    */

const host = "carloloidev.com"; 
const project_name = "Project_Social/public";  
const socket_server = 'https://carloloiweb.com:3800';
   



export default function servers() {

    return {

        url : `https://${host}/${project_name}/`,

        url_complete : `https://${host}/${project_name}/index.php/`,
     
        socket : socket_server
     
    }

}









 

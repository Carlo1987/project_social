const mysql = require('mysql');
const database = 'progetto_facebook';

let connection = mysql.createConnection({
    host : 'localhost',
    database : database,
    user : 'root',
    password : ''
})

connection.connect(function(error){
    if(error){
        throw error;
    }else{
        console.log('Collegamento al database '+ database + ' avvenuto con successo');
    }
})

connection.end();
'use strict';

const mysql = require('mysql');
const database = 'progetto_facebook';

let connection = mysql.createConnection({
    host : 'localhost',
    database : database,
    user : 'root',
    password : ''
})



function executeQuery(sql,callback){
    //connection.connect();
    connection.query(sql,callback);
   // connection.end();
}


module.exports = executeQuery;
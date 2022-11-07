const http = require('http');

http.createServer(function (req, res) {
    res.writeHead(200, {'Content-Type': 'text/plain'});
    res.end('Hello World!');
}).listen(3000);


const express = require('express');
const mysql = require('mysql2'); // this version works with MySQL 8 (caching_sha2_password)
const bodyParser = require('body-parser');
const cors = require('cors');
const app = express();
const port = 9229;

// used to read the request body req.*
app.use(bodyParser.json());

// adds the HTTP header: Access-Control-Allow-Origin: *
// indicating that API requests from any other domain are allowed
app.use(cors());

const connection = mysql.createConnection({
    host: 'mysqldb',
    user: 'root',
    password: 'Azerty123',
    database: 'demo-webapi',
    charset : 'utf8mb4'
});

connection.connect();


// get all products from the database
app.get('/products', function (req, res) {
    connection.query('SELECT * FROM products', function (err, rows, fields) {
        if (err) {
            console.log(err);
            res.sendStatus(500);
        }
        else {
            res.status(200).json({
                products: rows
            });
        }
    });
});

// make sure to run the app with `node index.js` command
app.listen(port, function() {
    console.log(`Example app listening on port ${port}!`)
});
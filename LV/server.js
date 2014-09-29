var fs = require('fs');
var options = {
  key: fs.readFileSync('/root/doyouagree.co.uk.ssl/doyouagree.co.uk.key'),
  cert: fs.readFileSync('/root/doyouagree.co.uk.ssl/doyouagree.co.uk.crt')
};

var app					= require('https').createServer(options,handler),
	io					= require('socket.io').listen(app),
	util					= require('util'),
	url					= require('url'),
	mysql				= require('mysql'),
	connectionsArray	= [],
	code 				= {},
	param				= [],
	pool = mysql.createPool({
        host		: '2340d350c269f9aa5de101d9842d904fc1aa3c82.rackspaceclouddb.com',
		user		: 'atdesign',
		password	: 'TLdjdACu6R69',
		database	: 'dya',
		multipleStatements: true
    }),
	POLLING_INTERVAL = 5000,
	pollingTimer;


io.set('log level', 0);

pool.on("close", function (err) {
    console.log("SQL CONNECTION CLOSED.");
});
pool.on("error", function (err) {
    console.log("SQL CONNECTION ERROR: " + err);
});

//conn = dbconn.getConnection();

// creating the server ( localhost:8000 )
app.listen(8000);

// on server started we can load our client.html page
function handler ( req, res ) {

//var url_parts = url.parse(req.url, true);
//tmp = url_parts.query['code'];
//console.log("tmp : " + tmp);
//if(typeof tmp === "undefined"){}
//else {
//param.push(tmp);
//}

	fs.readFile( __dirname + '/client.html' , function ( err, data ) {
		if ( err ) {
			console.log( err );
			res.writeHead(500);
			return res.end( 'Error loading client.html' );
		}
		
		res.writeHead( 200 );
		res.end( data );
	});
}


/*
*
* HERE IT IS THE COOL PART
* This function loops on itself since there are sockets connected to the page
* sending the result of the database query after a constant interval
*
*/

var pollingLoop = function () {
	for (var ec in code) {
		// console.log(code[ec][0]['slider']);
		// console.log(code[ec].length);
		if(code[ec].length > 0) {
			loadTotalsForCode(ec,code[ec][0]['slider']);
		}
	}
};




function loadTotalsForCode(ec,slider) {
	
	pool.getConnection(function(err, conn) {
	
	// console.log(conn);
	
	
	var qry = "SELECT questions.question,questions.qType,questions.agreeNext,questions.options,questions.colours,AVG(responses.response),COUNT(*) FROM `dya`.questions JOIN `dya`.responses ON questions.code = responses.eventCode WHERE `eventcode` = '"+ec+"' LIMIT 1;";
	if(!slider){
	qry += "SELECT response,COUNT(*) as count FROM `dya`.responses WHERE `eventcode` ='"+ec+"' GROUP BY `response` ORDER BY `response` ASC;";
	}


	var query = conn.query(qry);
	var users = []; // this array will contain the result of our db query
	if(conn && conn != null) {conn.release();}
	// setting the query listeners
	query
		.on('error', function(err) {
			// Handle error, and 'end' event will be emitted after this as well
			console.log("query .on error");
			console.log( err );
			//code[ec].forEach(function (connection) {
			//	connection.volatile.emit( 'notification' , err );
			//});
		})
		.on('result', function( user ) {
			// it fills our array looping on each user row inside the db
					users.push( user );
			
		})
		.on('end',function(){
			// loop on itself only if there are sockets still connected
			code[ec].forEach(function (connection) {
				connection.volatile.emit( 'notification' , {users:users} );
			});
			
		});
	});

}

pollingTimer = setInterval( pollingLoop, POLLING_INTERVAL );

// creating a new websocket to keep the content updated without any AJAX request
io.sockets.on( 'connection', function ( socket ) {
	connectionsArray.push( socket );
	console.log( 'A new socket is connected!' );
	console.log('Number of connections:' + connectionsArray.length);

	socket.dyaPath = 0;

	socket.on('url', function(data) {
		//console.log(data);
		//code.push(data);
		if(code[data] == null) {
			code[data] = [];
		}
		code[data].push(socket);
		socket.dyaPath = data;
		
		pollingLoop();	
	});
	// new code
	socket.on('slider', function(dat){
		socket.slider = dat;
		
	});
	
	socket.on('error', function(err) {
		console.log("Socket error");
		console.log( err );
	});
	
	socket.on('disconnect', function () {
		var socketIndex = connectionsArray.indexOf( socket );
		console.log('socket = ' + socketIndex + ' disconnected');
		if (socketIndex >= 0) {
			var path = socket.dyaPath;
			if (path === 0) {
				console.log("Disconnect before 'url' event sent.")
			}
			else if(code[path] !== undefined) {
				var codeIndex = code[path].indexOf(socket);
				code[path].splice(codeIndex, 1);
				// newcode	
			}
			else {
				console.log("unknown path: ", path);
			}
		
			connectionsArray.splice( socketIndex, 1 );
		}
		
	});
});




var updateSocket = function ( data, sckt ) {
		connectionsArray[sckt].volatile.emit( 'notification' , data );
};

var updateSockets = function ( data ) {
	// adding the time of the last update
	data.time = new Date();
	// sending new data to all the sockets connected
	connectionsArray.forEach(function( tmpSocket ){
		tmpSocket.volatile.emit( 'notification' , data );
	});
};






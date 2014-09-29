var mysql = require("mysql");


module.exports.getConnection = function() {
    // Test connection health before returning it to caller.
    if ((module.exports.connection) && (module.exports.connection._socket)
            && (module.exports.connection._socket.readable)
            && (module.exports.connection._socket.writable)) {
        return module.exports.connection;
    }
    console.log(((module.exports.connection) ?
            "UNHEALTHY SQL CONNECTION; RE" : "") + "CONNECTING TO SQL.");
    var pool = mysql.createPool({
        host		: '2340d350c269f9aa5de101d9842d904fc1aa3c82.rackspaceclouddb.com',
		user		: 'atdesign',
		password	: 'TLdjdACu6R69',
		database	: 'dya'
    });

	
    
    pool.on("close", function (err) {
        console.log("SQL CONNECTION CLOSED.");
    });
    pool.on("error", function (err) {
        console.log("SQL CONNECTION ERROR: " + err);
    });
    
	return pool.getConnection(function(err, connection) {
	  	if (err) {
            console.log("SQL CONNECT ERROR: " + err);
			return err; 
        } else {
            console.log("SQL CONNECT SUCCESSFUL.");
			return connection;
        }
	});

}

// Open a connection automatically at app startup.
//module.exports.getConnection();
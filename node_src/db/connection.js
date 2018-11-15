var mysql = require('mysql');

function Connection() {
  this.pool = null;

  this.init = function() {
    this.pool = mysql.createPool({
      connectionLimit: 30,
      host: '127.0.0.1',
      user: 'root',
      password: '',
      database: 'gamedb',
	    charset : 'utf8'
    });

  };

  this.acquire = function(callback) {
    this.pool.getConnection(function(err, connection) {
      callback(err, connection);
    });
  };
}

module.exports = new Connection();
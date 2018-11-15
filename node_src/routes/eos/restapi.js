var express = require('express');
var router = express.Router();

var dbConnection = require('../../db/connection');
const Eos = require('eosjs');
const eosWallet = require('eos-wallet');
const configure = require('../../config/eos.json');
var http = require('request');

const _eos = Eos((configure.net=="test") ? configure.jungle_testnet : configure.mainnet);

/***  DB connection init */
dbConnection.init();

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('eos/index', { title: 'EOS Rest API', eosObj: "address"});
  
});
router.get('/exchange_address/address', function(req, res, next){
  var uid = req.query['uid'];
  var path = 'address/'+uid;
  var options = {
    url: configure.core_http+path,
    method: 'POST',
    json: {uid: uid}
  };
  http(options, function(err, result, body) {
    if ( err ) res.send(err);
    res.send(body);
  });
});
router.post('/exchange_address/account', function(req, res, next){
  var uid = req.body.uid;
  var email = req.body.email;
  var path = 'account';
  var options = {
    url: configure.core_http+path,
    method: 'POST',
    json: {uid: uid, email: email}
  };
  http(options, function(err, result, body) {
    if ( err ) res.send(err);
    res.send(body);
  });
});
router.get('/exchange_address/balance', function(req, res, next){
  var uid = req.query['uid'];
  var path = 'balance/'+uid;
  var options = {
    url: configure.core_http+path,
    method: 'POST',
    json: {uid: uid}
  };
  http(options, function(err, result, body) {
    if ( err ) res.send(err);
    res.send(body);
  });
});
router.get('/exchange_address/bankroll', function(req, res, next){
  var path = 'bankroll';
  var options = {
    url: configure.core_http+path,
    method: 'POST'
  };
  http(options, function(err, result, body) {
    if ( err ) res.send(err);
    res.send(body);
  });
});

module.exports = router;
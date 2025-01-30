'use strict';

const net = require('net');
const PORT = 8210;
const ADDRESS = '202.10.40.122';
const http = require('http');

const options = {
  hostname: '202.10.40.122',
  port: 8080,
  path: '/',
  method: 'GET',
};

var data = '';

let server = net.createServer(onClientConnected);
server.listen(PORT, ADDRESS);

console.log(`Server started at: ${ADDRESS}:${PORT}`);

function onClientConnected(socket) {
	const req = http.request(options, (res) => {

	  res.on('data', (chunk) => {
		data += chunk;
	  });

	  res.on('end', () => {
		
	  });
	});
	
	req.on('error', function(err) {
		data = '';
		console.log("HTTP request err");
	});

	req.end();
	
	let clientName = `${socket.remoteAddress}:${socket.remotePort}`;
	
	console.log(`${clientName} connected.`);
	socket.write(data.trim());

	socket.on('end', () => {
		console.log(`${clientName} disconnected.`);
	});
	
	socket.on('error', () => {
		console.log('Socket err');
	});
	
	data = '';
	socket.destroy();
}

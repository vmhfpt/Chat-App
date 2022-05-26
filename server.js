const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
var online = 0;
app.get('/', (req, res) => {
  res.send('<h1>Hello worlfdfd d</h1>');
});

const  io = require("socket.io")(server, {
    cors: {origin : "*"}
});
io.on('connection', (socket) => {
  online ++;
    console.log('Một người dùng online');
    socket.on('manageChatServer', (user_id, content, avatar, name, date ) => {
      io.sockets.emit('manageChatClient',user_id, content, avatar, name, date);
    });
    socket.on('disconnect', () => {
      console.log('! Người dùng đã ngắt kết nối');
     
      if(online !== 0){
        online --;
      }
      io.sockets.emit('chatOnline',online);
    });
    io.sockets.emit('chatOnline',online);
  });


server.listen(3000, () => {
  console.log('serve is run');
});
/*
 emit là gửi đến nhiều client
     on là lắng nghe sự kiện phía client
*/
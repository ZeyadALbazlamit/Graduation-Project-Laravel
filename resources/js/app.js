/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */
require('./bootstrap');
require('./components/Example');
require('./components/comment');
require('./components/recipient');
require('./components/DashBoard');

console.log("app");

window.Echo.channel('channel').listen('.message', (data) => {
    console.log(data);
    });
    
window.Echo.channel('puplic-channel').listen('.comment', (data) => {
  //  console.log(data);
});


/*
var pusher = new Pusher('8626767e4a961d9424bb', {
    cluster: 'ap2',
    forceTLS: false
});
var channel = pusher.subscribe('puplic-channel');
channel.bind('comment', function (data) {
console.log("comment->"+data);
});
 */


/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



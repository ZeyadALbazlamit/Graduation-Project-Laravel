import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import './comment.css';
const Recipient = () => {
   Pusher.logToConsole = false;

    var pusher = new Pusher('8626767e4a961d9424bb', {
        cluster: 'ap2',
        forceTLS: false,


    });

    var channel = pusher.subscribe('private-channel'+ localStorage.getItem('uid'));

    channel.bind('message', function (data) {
        console.log(data+"this"+'id='+localStorage.getItem('uid'));
    }

    )

    return (
        <div>

           waiting...
        </div>
    );
}

export default Recipient;
if (document.getElementById('recipient')) {
    ReactDOM.render(<Recipient />, document.getElementById('recipient'));
}

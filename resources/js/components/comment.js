import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import './comment.css';
import axios from 'axios';
import ReactHtmlParser from 'react-html-parser';

import { TextEditor } from './textEditor';
const Comment = () => {
    const [comments, setComments] = useState([{}]);
    function addComment(e) {//add Comment and make comment() event
        if (e){
        const data = e;
        setComments([...comments, {
            "post_id": "1",
            "body": data,
            "user_id": 1
        }]);
        axios.post(`http://127.0.0.1:8000/api/Message`, { "data":data }).then(res => { console.log(res);})//event
    }
    }
    useEffect(() => {
        axios.get(`http://127.0.0.1:8000/api/Comment/1`)
            .then(res => {
                setComments(() => [...res.data]);
                console.log("Firt request");
            })
    }, []);




    var pusher = new Pusher('8626767e4a961d9424bb',
        { cluster: 'ap2', forceTLS: false });
    var channel = pusher.subscribe('puplic-channel');
    useEffect(() => {
        //  Pusher.logToConsole = true;
        channel.bind('comment', function (data) {
            axios.post(`http://127.0.0.1:8000/api/Comment`, { //use comment store after listin from addComment
                "post_id": "1",
                "body": data.comment,
                "user_id": 1
            })
                .then(res => {
                    if (comments[comments.length - 1].hasOwnProperty('created_at')) {
                        setComments((comments) => [...comments, res.data]);
                    } else {
                        setComments((comments) => [...comments.filter((el) => el != comments[comments.length - 1]), res.data]);
                    }
                    console.log(res.data);
                })
        });
    }, []);
    const img = [
        "https://www.flaticon.com/premium-icon/icons/svg/2202/2202112.svg",
        "https://www.flaticon.com/svg/static/icons/svg/3658/3658958.svg",
        "https://www.flaticon.com/svg/static/icons/svg/3532/3532381.svg"
    ]
    return (
        <div className="comment-component">

            <div className="color-comment">
                {comments.map((text, index) =>
                    <div className="main-comment-div"
                        key={text.id} >
                        <a  ><img src={text.id % 2 == 0 ? img[0] : text.id % 3 == 0 ? img[1] : img[2]} className="avatar" /></a>
                        <div className="comment comment_bubble">
                            <p className="mt-3">{text.id}{text.UserName}</p>
                            <p>{ReactHtmlParser(text.body)}</p>
                            <p className=" timeBorder">
                                {text.created_at}
                            </p>
                        </div>
                    </div>
                )}
                <TextEditor
                    addComment={(count) => addComment(count)}
                />
            </div>
        </div>
    );
}
export default Comment;
if (document.getElementById('comment')) {
    ReactDOM.render(<Comment />, document.getElementById('comment'));
}

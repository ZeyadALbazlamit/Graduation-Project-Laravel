import React from 'react';
import ReactDOM from 'react-dom';

function DashBoard() {
    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Example Component</div>

                        <div className="card-body">I'm an DashBoard component!</div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default DashBoard;

if (document.getElementById('DashBoard')) {
    ReactDOM.render(<DashBoard />, document.getElementById('DashBoard'));
}

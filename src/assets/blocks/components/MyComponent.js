import React from 'react';

import './MyComponent.scss'


class MyComponent extends React.Component {
    render() {
        console.log('hello world');
        //return <h1>{this.props.title}</h1>
        //return React.createElement('h1', null, `title: ${this.props.title}`)

        return <div className="x">
                {[1,2,3].map(item => <div>{item}</div>)}
            </div>

    }
}

export default MyComponent;
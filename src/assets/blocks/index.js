import React from 'react';
import ReactDom from 'react-dom'
import MyComponent from './components/MyComponent';

import './index.scss';

ReactDom.render(React.createElement(MyComponent, {title: 'hello'}),document.getElementById('root'))
/**
 * @file simple skeleton
 * @author panyuqi <pyqiverson@gmail.com>
 */

import React from 'react';
import ReactDOMServer from 'react-dom/server';
import Skeleton1 from './Skeleton1';
import Skeleton2 from './Skeleton2';

let html = ReactDOMServer.renderToStaticMarkup((
    <React.Fragment>
        <div id='skeleton1' style={{display: 'none'}}>
            <Skeleton1 />
        </div>
        <div id='skeleton2' style={{display: 'none'}}>
            <Skeleton2 />
        </div>
    </React.Fragment>
));

export default html;

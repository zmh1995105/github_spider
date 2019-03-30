import React, { Component } from 'react';
import {BrowserRouter as Router, Route} from 'react-router-dom'
import ContainerList from './ContainerList'
import XTerm from './XTerm'

class App extends Component {
  render() {
    return (
      <Router>
        <>
          <Route exact path='/' component={ContainerList} />
          <Route path='/shell/:containerId' component={XTerm} />
        </>
      </Router>
    );
  }
}

export default App;

/**
 * Imports of dependencies
 */
import React from "react";
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";

/**
 * Local imports
 */
// React Components
import Header from "src/components/Header";
import Home from "src/components/Home";
import Footer from "src/components/Footer";

// Data

/**
 * Code
 */
const App = () => {
  return (
    <div id="app">
      <Header />
      <Router>
        <Switch>
          <Route exact path="/">
            <Home />
          </Route>
        </Switch>
      </Router>
      <Footer />;
    </div>
  );
};

/**
 * Export
 */
export default App;

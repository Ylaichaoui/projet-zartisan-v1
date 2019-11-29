/**
 * Imports de dépendances
 */
import React from "react";

/**
 * Imports locaux
 */
// Composants React
import Header from "src/components/Header";
import Home from "src/components/Home";
import Footer from "src/components/Footer";

// Données

/**
 * Code
 */
const App = () => {
  return (
    <div id="app">
      <Header />
      <Home />
      <Footer />
    </div>
  );
};

/**
 * Export
 */
export default App;

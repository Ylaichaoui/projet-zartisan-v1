/**
 * Imports of dependencies
 */
import React from 'react';

/**
 * Local imports
 */
// React Components
import Header from 'src/components/Header';
import Home from 'src/components/Home';
import Footer from 'src/components/Footer';

// Data

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

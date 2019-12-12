/**
 * Imports of dependencies
 */
import React from 'react';
import { BrowserRouter as Router, Switch, Route, Redirect } from 'react-router-dom';
import { useSelector } from 'react-redux';
/**
 * Local imports
 */
// React Components
import Header from 'src/components/Header';
import Home from 'src/components/Home';
import Footer from 'src/components/Footer';
import ListArtisan from 'src/components/ListArtisan';
import PageArtisan from 'src/components/PageArtisan';
import LegalNotices from 'src/components/LegalNotices';
import PageError from 'src/components/PageError';
import FormRegisterUser from 'src/components/FormRegisterUser';
import FormRegisterArtisan from 'src/components/FormRegisterArtisan';

/**
 * Code
 */
const App = () => {
	const connect = useSelector((state) => state.connect);
	//console.log(connect);

	return (
		<div id="app">
			<Router>
				<Header />
				<Switch>
					<Route exact path="/">
						<Home />
					</Route>
					<Route exact path="/inscription/particulier">
						{connect == true ? <Redirect to="/" /> : <FormRegisterUser />}
					</Route>
					<Route exact path="/inscription/professionnel">
						{connect == true ? <Redirect to="/" /> : <FormRegisterArtisan />}
					</Route>
					<Route exact path="/liste-artisan">
						<ListArtisan />
					</Route>
					<Route exact path="/page-artisan/:id">
						<PageArtisan />
					</Route>
					<Route exact path="/mentions-legal">
						<LegalNotices />
					</Route>
					<Route>
						<PageError />
					</Route>
				</Switch>
				<Footer />
			</Router>
		</div>
	);
};

/**
 * Export
 */
export default App;

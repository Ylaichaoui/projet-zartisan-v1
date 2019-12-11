import { createStore, compose, applyMiddleware } from 'redux';

import reducer from './reducer';
import middlewareRegister from 'src/store/register/middleware';
import middlewareRegions from 'src/store/regions/middleware';
import middlewareJobs from 'src/store/jobs/middleware';

const withReduxDevTools = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const middlewares = applyMiddleware(middlewareRegister, middlewareRegions, middlewareJobs);
// Création du store de l'application, avec son state privé.
const reactModelStore = createStore(reducer, withReduxDevTools(middlewares));

// Juste pour debugguer, ne pas laisser en production.
console.log('Store', reactModelStore);
window.store = reactModelStore;

export default reactModelStore;

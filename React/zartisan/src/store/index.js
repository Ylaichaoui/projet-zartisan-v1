
import { createStore, compose } from 'redux';


// Logique de stockage et de manipulation des données de l'application.
import reducer from './reducer';


const withReduxDevTools = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

// Création du store de l'application, avec son state privé.
const reactModelStore = createStore(
  reducer,
  withReduxDevTools()
);

// Juste pour debugguer, ne pas laisser en production.
console.log('Store', reactModelStore);
window.store = reactModelStore;

export default reactModelStore;

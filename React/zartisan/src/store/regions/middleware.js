import axios from 'axios';
import { GET_REGIONS } from 'src/store/regions/actions';
import { regions } from 'src/store/regions/actions';
/**
 * NAME SERVER
 */
import { NAME_SERVER } from 'src/store/register/actions';

export default (store) => (next) => (action) => {
	switch (action.type) {
		/**
     * Connexion
     */
		/**
     * Artisan register
     */
		case GET_REGIONS: {
			return axios({
				method: 'get',
				url: `${NAME_SERVER}/v1/region/list`
			})
				.then((response) => {
					//console.log(response);
					if (response.status === 200) {
						//console.log("region");
						//console.log(response.data);
						store.dispatch(regions(response.data));
						// store.getState();
						// store.storeReducer();
						// store.liftedStore();
					}
				})
				.catch(function(error) {
					// handle error
					//console.log(error);
				})
				.finally(function() {
					// always executed
				});
		}
	}
	next(action);
};

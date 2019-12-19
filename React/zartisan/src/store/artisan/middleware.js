import { ARTISAN_DATA } from 'src/store/artisan/actions';
import { artisanInfo } from 'src/store/artisan/actions';
/**
 * NAME SERVER
 */
import { NAME_SERVER } from 'src/store/register/actions';

import axios from 'axios';

export default (store) => (next) => (action) => {
	switch (action.type) {
		case ARTISAN_DATA: {
			//console.log('middleware artisan');
			//console.log(action.id, action.email);

			return axios({
				method: 'post',
				url: `${NAME_SERVER}/v1/artisan/single`,
				data: {
					email: action.email
				}
			})
				.then((response) => {
					//console.log(response);
					if (response.status === 200) {
						//console.log('ok artisan');
						//console.log('response', response.data);

						store.dispatch(artisanInfo(response.data));
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

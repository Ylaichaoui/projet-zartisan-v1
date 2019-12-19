import axios from 'axios';
import { GET_JOBS } from 'src/store/jobs/actions';
import { jobs } from 'src/store/jobs/actions';
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
		case GET_JOBS: {
			return axios({
				method: 'post',
				url: `${NAME_SERVER}/v1/job/category/listV2`,
				data: {
					region: action.region
				}
			})
				.then((response) => {
					//console.log(response);
					if (response.status === 200) {
						//console.log('jobs');
						console.log('jobs middleware data ', response.data);
						store.dispatch(jobs(response.data));
					}
				})
				.catch(function(error) {
					// handle error
					console.log(error);
				})
				.finally(function() {
					// always executed
				});
		}
	}
	next(action);
};

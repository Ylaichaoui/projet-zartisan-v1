import axios from 'axios';
import { GET_JOBS } from 'src/store/jobs/actions';
import { jobs } from 'src/store/jobs/actions';
import { error } from 'src/store/jobs/actions';
import middleware from '../artisan/middleware';

export default (store) => (next) => (action) => {
	switch (action.type) {
		/**
       * Connexion
       */
		/**
       * Artisan register
       */
		case GET_JOBS: {
			// return axios({
			// 	method: 'get',
			// 	url: 'http://localhost:8001/v1/job/category/list'
			// })
			// 	.then((response) => {
			// 		//console.log(response);
			// 		if (response.status === 200) {
			// 			//console.log('jobs');
			// 			//console.log(response.data);
			// 			store.dispatch(jobs(response.data));
			// 		}
			// 	})
			// 	.catch(function(error) {
			// 		// handle error
			// 		console.log(error);
			// 	})
			// 	.finally(function() {
			// 		// always executed
			// 	});
			let errorRequest = false;
			console.log('hello', action.region);
			return axios({
				method: 'post',
				async: false,
				url: 'http://localhost:8001/v1/job/category/listV2',
				data: {
					region: action.region
				}
			})
				.then((response) => {
					//console.log(response);
					if (response.status === 200) {
						//console.log('jobs');
						//console.log('reponse', response.data);
						store.dispatch(jobs(response.data));
					}
				})
				.catch(function(error) {
					errorRequest = true;
					//console.log(error);
				})
				.finally(function() {
					// always executed
					console.log(errorRequest);
					store.dispatch(error(errorRequest));
				});
		}
	}
	next(action);
};

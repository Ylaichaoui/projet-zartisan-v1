import { POST_HOME_SEARCH } from 'src/store/search/actions';
import { homeSearch } from 'src/store/search/actions';
import axios from 'axios';
export default (store) => (next) => (action) => {
	switch (action.type) {
		/**
       * Search artisan list by region and job from home
       */
		case POST_HOME_SEARCH: {
			console.log(action.region, action.job);
			return axios({
				method: 'post',
				url: 'http://localhost:8001/v1/artisan/recherche',
				data: {
					idJob: action.job,
					nameRegion: action.region
				}
			})
				.then((response) => {
					//console.log(response);
					if (response.status === 200) {
						console.log('filtre les artisans', response.data);
						store.dispatch(homeSearch(response.data));
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

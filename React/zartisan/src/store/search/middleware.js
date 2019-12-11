import { POST_HOME_SEARCH } from 'src/store/search/actions';

export default (store) => (next) => (action) => {
	switch (action.type) {
		/**
       * Search artisan list by region and job from home
       */
		case POST_HOME_SEARCH: {
			console.log(action.region, action.job);
			return console.log('hello ici middleware search home');
		}
	}
	next(action);
};

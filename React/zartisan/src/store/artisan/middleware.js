import { ARTISAN_DATA } from 'src/store/artisan/actions';

export default (store) => (next) => (action) => {
	switch (action.type) {
		case ARTISAN_DATA: {
			console.log('middleware artisan');
			console.log(action.id);
			/*
			return axios({
				method: 'get',
				url: `http://localhost:8001/v1/artisan/single?id=${action.id}`
			})
				.then((response) => {
					//console.log(response);
					if (response.status === 200) {
						console.log('ok artisan');
						//console.log(response.data);
					}
				})
				.catch(function(error) {
					// handle error
					console.log(error);
				})
				.finally(function() {
					// always executed
				}); */
		}
	}
	next(action);
};

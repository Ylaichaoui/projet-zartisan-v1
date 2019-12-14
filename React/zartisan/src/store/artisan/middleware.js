import { ARTISAN_DATA } from 'src/store/artisan/actions';
import { artisanInfo } from 'src/store/artisan/actions';

import axios from 'axios';

export default (store) => (next) => (action) => {
	switch (action.type) {
		case ARTISAN_DATA: {
			console.log('middleware artisan');
			console.log(action.id, action.email);

			return axios({
				method: 'post',
				url: `http://localhost:8001/v1/artisan/single?id=${action.id}`,
				data: {
					email: action.email
				}
			})
				.then((response) => {
					//console.log(response);
					if (response.status === 200) {
						//console.log('ok artisan');
						//console.log(response.data);

						store.dispatch(artisanInfo(response.data));
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

/*
  nc
  asy function asyncFunc() {
	// fetch data from a url endpoint
	const response = await axios.post("/some_url_endpoint");
	const data = await response.json();
  
	return data;
  }*/

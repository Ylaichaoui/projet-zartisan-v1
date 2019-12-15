import { SEND_RATE } from 'src/store/rate/actions';
import axios from 'axios';

export default (store) => (next) => (action) => {
	switch (action.type) {
		/**
     * rate
     */
		case SEND_RATE: {
			console.log('middleware rate');
			return axios({
				method: 'post',
				url: 'http://localhost:8001/api/v1/rate',
				data: {
					id: action.id,
					email: action.mail,
					value: action.value
				}
			})
				.then((response) => {
					//console.log(response);
					if (response.status === 200) {
						console.log(response.data);
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

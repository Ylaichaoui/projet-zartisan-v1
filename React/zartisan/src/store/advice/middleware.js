import { ALERT_ADVICE } from 'src/store/advice/actions';
import { artisanInfo } from 'src/store/advice/actions';

import axios from 'axios';

export default (store) => (next) => (action) => {
	switch (action.type) {
		case ALERT_ADVICE: {
			console.log('middleware advice');
			/*
			return axios({
				method: 'post',
				url: 'http://localhost:8001/api/v1/advice/report',
				data: {
					id: action.id,
					email: action.mail,
					value: action.value
				},
				headers: { Authorization: `Bearer ${token}` }
			})
				.then((response) => {
					//console.log(response);
					if (response.status === 200) {
						console.log(response.data);
						store.dispatch(rate(response.data));
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

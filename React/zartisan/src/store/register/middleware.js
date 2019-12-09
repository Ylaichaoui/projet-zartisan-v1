/**
 * Imports of dependencies
 */
import axios from 'axios';

/**
 * Local imports
 */
import { SEND_REGISTER_USER } from 'src/store/register/actions';

export default (store) => (next) => (action) => {
	switch (action.type) {
		case SEND_REGISTER_USER: {
			const data = {
				email: action.email,
				password: action.password
			};
			console.log(data);

			axios({
				method: 'post',
				url: 'http://localhost:8001/register/user', // first check with static home page
				data
			})
				.then((response) => {
					console.log(response);
					if (response.status === 200) {
						console.log('login');
						axios({
							method: 'post',
							url: 'http://localhost:8001/api/login_check', // first check with static home page
							data: {
								username: action.email,
								password: action.password
							}
						})
							.then((response) => {
								console.log(response);
								if (response.status === 200) {
									console.log('ok');
									store.dispatch({ type: 'register/actions/CONNECT' });
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
				})
				.catch(function(error) {
					// handle error
					// console.log(error);
				})
				.finally(function() {
					// always executed
				});
		}
	}
	next(action);
};

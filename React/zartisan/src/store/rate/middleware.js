import { SEND_RATE } from 'src/store/rate/actions';
import { rate } from 'src/store/rate/actions';
import axios from 'axios';
import cookies from 'js-cookie';
/**
 * NAME SERVER
 */
import { NAME_SERVER } from 'src/store/register/actions';

export default (store) => (next) => (action) => {
	switch (action.type) {
		/**
     * rate
     */
		case SEND_RATE: {
			//console.log('middleware rate');
			const token = cookies.get('TOKEN');
			return axios({
				method: 'post',
				url: `${NAME_SERVER}/api/v1/rate/add`,
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
						//console.log(response.data);
						store.dispatch(rate(response.data));
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

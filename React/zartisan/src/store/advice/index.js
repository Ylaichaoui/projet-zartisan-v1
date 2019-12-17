import { ALERT_SUCCESS } from 'src/store/advice/actions';

const initialState = {
	report: null
};

export default (state = initialState, action) => {
	// console.log('reducer >>', action);

	switch (action.type) {
		case ALERT_SUCCESS: {
			//console.log('store advice');
			console.log(action.response);
			return { report: action.response };
		}
		default: {
			return state;
		}
	}
};

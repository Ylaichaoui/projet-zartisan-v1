import { ALERT_SUCCESS } from 'src/store/advice/actions';
import { ADVICE } from 'src/store/advice/actions';
const initialState = null;

export default (state = initialState, action) => {
	// console.log('reducer >>', action);

	switch (action.type) {
		case ALERT_SUCCESS: {
			//console.log('store advice');
			//console.log(action.response);
			return (state = action.response);
		}
		default: {
			return state;
		}
	}
};

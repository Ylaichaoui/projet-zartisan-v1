import { RATE } from 'src/store/rate/actions';

const initialState = null;

export default (state = initialState, action) => {
	// console.log('reducer >>', action);

	switch (action.type) {
		case RATE: {
			//console.log(action.averageRate);
			//console.log('store rate');
			state = action.averageRate;
		}
		default: {
			return state;
		}
	}
};

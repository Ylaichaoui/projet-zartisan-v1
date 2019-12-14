import { ARTISAN_INFO } from 'src/store/artisan/actions';

const initialState = {};

export default (state = initialState, action) => {
	// console.log('reducer >>', action);

	switch (action.type) {
		case ARTISAN_INFO: {
			//console.log('hello ici state artisan');
			state = { ...action.data };
			//console.log(state);
			return state;
		}
		default: {
			return state;
		}
	}
};

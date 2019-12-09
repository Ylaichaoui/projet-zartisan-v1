import { CONNECT } from 'src/store/register/actions';

const initialState = false;

export default (state = initialState, action) => {
	console.log('reducer - connexion >>', action);

	switch (action.type) {
		case CONNECT: {
			state = true;
			console.log(state);
		}
		default: {
			return state;
		}
	}
};

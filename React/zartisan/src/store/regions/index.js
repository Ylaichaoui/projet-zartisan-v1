import { REGIONS } from 'src/store/regions/actions';

const initialState = [];

export default (state = initialState, action) => {
	console.log('reducer >>', action);

	switch (action.type) {
		case REGIONS: {
			console.log(action.regions);
			return (state = [ action.regions ]);
		}
		default: {
			return state;
		}
	}
};

import { JOBS } from 'src/store/jobs/actions';

const initialState = [];

export default (state = initialState, action) => {
	console.log('reducer >>', action);

	switch (action.type) {
		case JOBS: {
			//console.log(action.jobs);
			return (state = [ action.jobs ]);
		}
		default: {
			return state;
		}
	}
};

import { combineReducers } from 'redux';

import jobs from 'src/store/jobs';
import regions from 'src/store/regions';

export default combineReducers({
	jobs,
	regions
});

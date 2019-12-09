import { combineReducers } from 'redux';

import jobs from 'src/store/jobs';
import regions from 'src/store/regions';
import connect from 'src/store/register';

export default combineReducers({
	jobs,
	regions,
	connect
});

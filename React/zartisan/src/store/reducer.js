import { combineReducers } from 'redux';

import jobs from 'src/store/jobs';
import regions from 'src/store/regions';
import connect from 'src/store/register';
import search from 'src/store/search';
import artisan from 'src/store/artisan';
import rate from 'src/store/rate';
import advice from 'src/store/advice';

export default combineReducers({
	jobs,
	regions,
	connect,
	search,
	artisan,
	rate,
	advice
});

export const POST_HOME_SEARCH = 'search/actions/POST_HOME_SEARCH';

export const postHomeSearch = (region, job) => ({
	type: POST_HOME_SEARCH,
	region,
	job
});

export const HOME_SEARCH = 'search/actions/HOME_SEARCH';

export const homeSearch = () => ({
	type: HOME_SEARCH
});

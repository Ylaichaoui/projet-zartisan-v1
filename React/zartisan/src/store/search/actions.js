export const POST_HOME_SEARCH = 'search/actions/POST_HOME_SEARCH';

export const postHomeSearch = (region, job) => ({
	type: POST_HOME_SEARCH,
	region,
	job
});

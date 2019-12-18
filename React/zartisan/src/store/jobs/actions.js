export const GET_JOBS = 'jobs/actions/GET_JOBS';

export const getJobs = () => ({
	type: GET_JOBS
});

export const JOBS = 'jobs/actions/JOBS';

export const jobs = (jobs) => ({
	type: JOBS,
	jobs
});

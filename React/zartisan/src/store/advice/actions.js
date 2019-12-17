export const ALERT_ADVICE = 'advice/actions/ALERT_ADVICE';

export const alertAdvice = (id) => ({
	type: ALERT_ADVICE,
	id
});

export const ALERT_SUCCESS = 'advice/actions/ALERT_SUCCESS';

export const alertSuccess = (response) => ({
	type: ALERT_SUCCESS,
	response
});

export const SEND_RATE = 'rate/actions/SEND_RATE';

export const sendRate = (id, mail, value) => ({
	type: SEND_RATE,
	id,
	mail,
	value
});

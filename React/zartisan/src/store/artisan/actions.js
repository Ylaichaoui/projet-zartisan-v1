export const ARTISAN_DATA = 'artisan/actions/ARTISAN_DATA';

export const artisanData = (id, email) => ({
	type: ARTISAN_DATA,
	id,
	email
});

export const ARTISAN_INFO = 'artisan/actions/ARTISAN_INFO';

export const artisanInfo = (data) => ({
	type: ARTISAN_INFO,
	data
});

export const ARTISAN_DATA = 'artisan/actions/ARTISAN_DATA';

export const artisanData = (email) => ({
	type: ARTISAN_DATA,
	email
});

export const ARTISAN_INFO = 'artisan/actions/ARTISAN_INFO';

export const artisanInfo = (data) => ({
	type: ARTISAN_INFO,
	data
});

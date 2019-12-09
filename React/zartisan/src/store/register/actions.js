export const SEND_REGISTER_USER = 'register/actions/SEND_REGISTER_USER';

export const sendRegisterUser = (email, password) => ({
	type: SEND_REGISTER_USER,
	email,
	password
});

export const CONNECT = 'register/actions/CONNECT';

export const connect = () => ({
	type: 'CONNECT'
});

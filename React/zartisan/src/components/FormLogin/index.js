import React, { useState } from 'react';
import { Form, Icon, Input, Button } from 'antd';
import 'antd/dist/antd.css';

const FormLogin = ({ handleSubmitLogin }) => {
	const [ email, setEmail ] = useState('');
	const [ password, setPassword ] = useState('');

	const mailChangeValue = (event) => {
		console.log(event.target.value);
		setEmail(event.target.value);
	};
	//console.log(email);
	const passwordChangeValue = (event) => {
		//	console.log(event.target.value);
		setPassword(event.target.value);
	};

	return (
		<div>
			<Form method="POST" onSubmit={handleSubmitLogin(email, password)}>
				<Form.Item>
					<Input
						onChange={mailChangeValue}
						prefix={<Icon type="mail" style={{ color: 'rgba(0,0,0,.25)' }} />}
						placeholder="Email"
						required
					/>
					<Input
						onChange={passwordChangeValue}
						prefix={<Icon type="lock" style={{ color: 'rgba(0,0,0,.25)' }} />}
						type="password"
						placeholder="Mot de passe"
						required
					/>
					<a className="login-form-forgot" href="">
						Mot de passe oublié
					</a>
				</Form.Item>
				<Button type="primary" htmlType="submit" className="login-form-button">
					Se connecter
				</Button>
			</Form>
		</div>
	);
};

export default FormLogin;

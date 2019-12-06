import React, { useState } from 'react';
import { Form, Icon, Input, Button } from 'antd';
import 'antd/dist/antd.css';

const FormLogin = ({ handleSubmitLogin }) => {
	return (
		<div>
			<Form method="POST" onSubmit={handleSubmitLogin}>
				<Form.Item>
					<Input
						prefix={<Icon type="mail" style={{ color: 'rgba(0,0,0,.25)' }} />}
						placeholder="Email"
						required
					/>
					<Input
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

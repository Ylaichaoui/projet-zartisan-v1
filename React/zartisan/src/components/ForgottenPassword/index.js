import React, { useState } from 'react';
import { Form, Input, Row, Button } from 'antd';
import { useDispatch } from 'react-redux';
import { sendPasswordForget } from 'src/store/register/actions';

const ForgettenPassword = () => {
	const dispatch = useDispatch();

	const handleFormUser = (email, password) => {
		return (event) => {
			//console.log(email, password);
			event.preventDefault();
			dispatch(sendPasswordForget(email, password));
		};
	};

	const [ email, setEmail ] = useState('');
	const [ password, setPassword ] = useState('');
	const emailChangeValue = (event) => {
		setEmail(event.target.value);
	};

	const passwordChangeValue = (event) => {
		setPassword(event.target.value);
	};

	return (
		<div className="register-user">
			{/* <Form method="POST" onSubmit={handleSubmitLogin(email, password)} /> */}
			<Row type="flex" justify="space-around" align="middle" onSubmit={handleFormUser(email, password)}>
				<Form className="user-form">
					<Form.Item label="E-mail">
						<Input onChange={emailChangeValue} />
					</Form.Item>
					<Form.Item label="Nouveau mot de passe" hasFeedback>
						<Input.Password onChange={passwordChangeValue} />
					</Form.Item>
					<Form.Item>
						<Button type="primary" id="buttons" htmlType="submit">
							Confirmer
						</Button>
					</Form.Item>
				</Form>
			</Row>
		</div>
	);
};

export default ForgettenPassword;

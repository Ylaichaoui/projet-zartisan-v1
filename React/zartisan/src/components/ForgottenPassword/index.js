import React, { useState } from 'react';
import { Form, Input, Row, Button } from 'antd';
import { useDispatch } from 'react-redux';
import { sendPasswordForget } from 'src/store/register/actions';
import { withRouter } from 'react-router-dom';

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

	const ButtonGoToUserForm = withRouter(({ history }) => {
		return (
			<Button
				id="buttons"
				htmlType="submit"
				onClick={(e) => {
					e.preventDefault();
					return history.push('/');
				}}
			>
				Confirmer
			</Button>
		);
	});

	return (
		<div className="register-user">
			{/* <Form method="POST" onSubmit={handleSubmitLogin(email, password)} /> */}
			<Row type="flex" justify="space-around" align="middle" onSubmit={handleFormUser(email, password)}>
				<Form className="user-form">
					<h6>Mot de passe oublié</h6>
					<Form.Item label="E-mail">
						<Input onChange={emailChangeValue} required />
					</Form.Item>
					<Form.Item label="Nouveau mot de passe" hasFeedback>
						<Input.Password onChange={passwordChangeValue} required />
					</Form.Item>
					<ButtonGoToUserForm />
				</Form>
			</Row>
		</div>
	);
};

export default ForgettenPassword;

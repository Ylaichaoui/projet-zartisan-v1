import React, { useState } from 'react';
import { Form, Input, Row, Button, Modal } from 'antd';
import { useDispatch } from 'react-redux';
import { sendPasswordForget } from 'src/store/register/actions';
import { useHistory } from 'react-router-dom';
import './style.sass';

const ForgettenPassword = () => {
	const dispatch = useDispatch();
	const [ email, setEmail ] = useState('');
	const [ password, setPassword ] = useState('');
	const [ passwordCheck, setPasswordCheck ] = useState('');

	const handleFormUser = (email, password, passwordCheck) => {
		return (event) => {
			//console.log(email, password);
			event.preventDefault();
			if (password === passwordCheck && password !== '') {
				//console.log('mots est correct');
				dispatch(sendPasswordForget(email, password));
			}
		};
	};

	const emailChangeValue = (event) => {
		setEmail(event.target.value);
		//console.log(event.target.value);
	};

	const passwordChangeValue = (event) => {
		setPassword(event.target.value);
		//console.log(event.target.value);
	};
	const passwordCheckChangeValue = () => {
		setPasswordCheck(event.target.value);
		//console.log(event.target.value);
	};

	let history = useHistory();

	const timeoutHist = () => {
		setTimeout(() => history.push('/'), 4000);
	};

	return (
		<div className="forgottenPassword">
			<Row type="flex" justify="space-around" align="middle">
				<Form className="user-form" onSubmit={handleFormUser(email, password, passwordCheck)}>
					<h6>Mot de passe oublié</h6>
					<Form.Item label="E-mail">
						<Input onChange={emailChangeValue} required />
					</Form.Item>
					<Form.Item label="Nouveau mot de passe" hasFeedback>
						<Input.Password onChange={passwordChangeValue} required />
					</Form.Item>
					<Form.Item label="Confirmer votre mot de passe" hasFeedback>
						<Input.Password onChange={passwordCheckChangeValue} />
					</Form.Item>
					<Form.Item>
						<Button type="primary" id="buttons" htmlType="submit" onClick={timeoutHist}>
							Confirmer
						</Button>
					</Form.Item>
				</Form>
			</Row>
		</div>
	);
};

export default ForgettenPassword;

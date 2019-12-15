/**
 * Imports of dependencies
 */
import React, { useState } from 'react';
import { Form, Input, Row, Button } from 'antd';
import { useDispatch } from 'react-redux';

/**
 * Local imports
 */
import { sendRegisterUser } from 'src/store/register/actions';
import './style.sass';

const FormRegisterUser = () => {
	const dispatch = useDispatch();

	const [ email, setEmail ] = useState('');
	const [ password, setPassword ] = useState('');
	const [ passwordCheck, setPasswordCheck ] = useState('');

	//submit of form
	const handleFormUser = (email, password, passwordCheck) => {
		return (event) => {
			//console.log(email, password, passwordCheck);
			event.preventDefault();
			if (password === passwordCheck && password !== '') {
				// console.log('mots est correct');
				dispatch(sendRegisterUser(email, password));
			}
		};
	};

	const emailChangeValue = (event) => {
		setEmail(event.target.value);
	};

	const passwordChangeValue = (event) => {
		setPassword(event.target.value);
	};

	const passwordCheckChangeValue = () => {
		setPasswordCheck(event.target.value);
	};

	return (
		<div className="register-user">
			<Row type="flex" justify="space-around" align="middle">
				<Form className="user-form" onSubmit={handleFormUser(email, password, passwordCheck)}>
					<Form.Item label="E-mail">
						<Input onChange={emailChangeValue} />
					</Form.Item>
					<Form.Item label="Mot de passe" hasFeedback>
						<Input.Password onChange={passwordChangeValue} />
					</Form.Item>
					<Form.Item label="Confirmer votre mot de passe" hasFeedback>
						<Input.Password onChange={passwordCheckChangeValue} />
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

export default FormRegisterUser;

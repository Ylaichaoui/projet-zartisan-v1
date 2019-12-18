import React, { useState, useEffect } from 'react';
import { Form, Icon, Input, Button } from 'antd';
import 'antd/dist/antd.css';
import './style.sass';
import { Link } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import { withRouter } from 'react-router-dom';

const FormLogin = ({ handleSubmitLogin, handleCancel, artisanSelector }) => {
	console.log('data artisan ', artisanSelector);
	let dataArtisan = artisanSelector[0].company;
	console.log('madata', artisanSelector[0].company);

	console.log('daaaaata', dataArtisan);

	const [ email, setEmail ] = useState('');
	const [ password, setPassword ] = useState('');

	const mailChangeValue = (event) => {
		// console.log(event.target.value);
		setEmail(event.target.value);
	};
	//console.log(email);
	const passwordChangeValue = (event) => {
		//	console.log(event.target.value);
		setPassword(event.target.value);
	};

	const ButtonLogin = withRouter(({ history }) => {
		return (
			<Button
				type="default"
				id="buttons"
				onClick={() => {
					console.log('ok');
					history.push(`/page-artisan/${dataArtisan}`);
				}}
				htmlType="submit"
				className="login-form-button"
				style={{ color: 'white', background: '#bb9574' }}
			>
				Se connecter
			</Button>
		);
	});

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
					<Link className="login-form-forgot" to="/mot-de-passe-oublié" onClick={handleCancel}>
						Mot de passe oublié
					</Link>
				</Form.Item>
				<ButtonLogin />
			</Form>
		</div>
	);
};

export default FormLogin;

/**
 * Imports of dependencies
 */
import React, { useState } from 'react';
import { Row, Col, Button, Icon, Drawer, Typography, Modal } from 'antd';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Link, withRouter } from 'react-router-dom';
/**
 * Local imports
 */
import './style.sass';
import logo from './picture/logo-zartisan.svg';
import FormLogin from 'src/components/FormLogin';

/**
 * Code
 */
const { Text } = Typography;

const Header = () => {
	/**Hooks for display or not menu burger */
	const [ visible, setVisible ] = useState(false);

	/**Hooks for display or not modal login */
	const [ modalLogin, setModalLogin ] = useState(false);

	/**Hooks for display or not modal register */
	const [ modalRegister, setModalRegister ] = useState(false);

	/**Hooks authentification */
	const [ authentification, setAuthentification ] = useState(false);

	/**
	 * open menu burger
	 */
	const showDrawer = () => {
		setVisible(true);
	};

	/**
	 * close menu burger
	 */
	const onClose = () => {
		setVisible(false);
	};
	/**
	 * open form login popup and close menu burger
	 */
	const showModalLogin = () => {
		setModalLogin(true);
		onClose();
	};
	/**
	 * open form register popup and close menu burger
	 */
	const showModalRegister = () => {
		setModalRegister(true);
		onClose();
	};
	/**
	 * close form popup
	 */
	const handleCancel = () => {
		setModalRegister(false);
		setModalLogin(false);
	};

	/**
	 * user authentification
	 */
	const authValide = () => {
		setAuthentification(true);
	};

	const deconnexion = () => {
		setAuthentification(false);
		onClose();
	};

	function onChange(value) {
		//console.log(value);
	}
	/**
	 * button for navigate towards form register artisan (use withRouter for manage history url)
	 */
	const ButtonGoToArtisanForm = withRouter(({ history }) => {
		return (
			<Button
				onClick={() => {
					handleCancel();
					return history.push('/inscription/professionnel');
				}}
				style={{ width: '40%', margin: '1.5em' }}
			>
				Professionnel
			</Button>
		);
	});

	/**
	 * button for navigate towards form register user (use withRouter for manage history url)
	 */
	const ButtonGoToUserForm = withRouter(({ history }) => {
		return (
			<Button
				onClick={() => {
					handleCancel();
					return history.push('/inscription/particulier');
				}}
				style={{ width: '40%' }}
			>
				Particulier
			</Button>
		);
	});

	//const handleSubmitLogin allows to send an axios request
	const handleSubmitLogin = (email, password) => {
		const data = {
			username: email,
			password
		};

		return (event) => {
			event.preventDefault();
			console.log(data);
			axios({
				method: 'post',
				url: 'http://localhost:8001/api/login_check', // first check with static home page
				data
			})
				.then((response) => {
					console.log(response);
					if (response.status === 200) {
						console.log('ok');
						authValide();
						handleCancel();
					}
				})
				.catch(function(error) {
					// handle error
					//console.log(error);
				})
				.finally(function() {
					// always executed
				});
		};
	};

	return (
		<div>
			<Row className="header" type="flex" justify="space-around">
				<Col span={6}>
					{/** Button Burger */}
					<Button className="header-burger-button" onClick={showDrawer}>
						<Icon type="menu" />
					</Button>

					{/** Menu of Burger */}
					<Drawer placement="top" closable={true} onClose={onClose} visible={visible}>
						<Row type="flex" justify="center" align="top">
							<img src={logo} alt="zartisan image" className="logo-zartisan" />
						</Row>
						<Row type="flex" justify="center" style={{ margin: '1.5em' }} align="top">
							<Text>
								{authentification === false && (
									<a href="#" onClick={showModalLogin}>
										Connexion
									</a>
								)}
								<Modal footer={null} title="Connexion" visible={modalLogin} onCancel={handleCancel}>
									<FormLogin handleSubmitLogin={handleSubmitLogin} />
								</Modal>

								{authentification === true && <a href="#">Profil</a>}
							</Text>
						</Row>
						<Row type="flex" justify="center" align="top">
							{authentification === false && (
								<a href="#" onClick={showModalRegister}>
									Inscription
								</a>
							)}
							{authentification === true && <a onClick={deconnexion}>Deconnexion</a>}

							<Modal footer={null} title="Inscription" visible={modalRegister} onCancel={handleCancel}>
								<Row type="flex" justify="center" align="top">
									<ButtonGoToUserForm />
								</Row>
								<Row type="flex" justify="center" align="top">
									<ButtonGoToArtisanForm />
								</Row>
							</Modal>
						</Row>
					</Drawer>
				</Col>

				{/** logo header */}
				<Col span={18}>
					<Link to="/">
						<img src={logo} alt="zartisan image" className="logo-zartisan" />
					</Link>
				</Col>
			</Row>
		</div>
	);
};

export default Header;

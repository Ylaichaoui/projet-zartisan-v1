/**
 * Imports of dependencies
 */

import React, { useState, useEffect } from 'react';
import { Row, Col, Button, Icon, Drawer, Typography, Modal } from 'antd';
import 'antd/dist/antd.css';
import { Link, withRouter } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import { sendLogin, deconnect } from 'src/store/register/actions';
import cookies from 'js-cookie';
import { artisanData } from 'src/store/artisan/actions';
/**
 * Local imports
 */
import './style.sass';
import logo from './picture/logo-zartisan.svg';
import FormLogin from 'src/components/FormLogin';
import FormRegisterArtisan from 'src/components/FormRegisterArtisan';
import { sendRegisterArtisan } from 'src/store/register/actions';

/**
 * Code
 */
const { Text } = Typography;

const Header = () => {
	const connect = useSelector((state) => state.connect);
	const dispatch = useDispatch();
	//console.log(connect);

	/**Hooks for display or not menu burger */
	const [ visible, setVisible ] = useState(false);

	/**Hooks for display or not modal login */
	const [ modalLogin, setModalLogin ] = useState(false);

	/**Hooks for display or not modal register */
	const [ modalRegister, setModalRegister ] = useState(false);

	/**Hooks welcome */
	const [ connectVisible, setConnectVisible ] = useState(false);

	/**
   * open menu burger
   */

	let artisanSelector = useSelector((state) => state.artisan);
	console.log('burger', artisanSelector);

	const showDrawer = () => {
		setVisible(true);
		dispatch(artisanData(tokenEmail));
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
		onClose();
		setTimeout(() => {
			setModalLogin(true);
		}, 1000);
	};

	const connectModalVisible = () => {
		setConnectVisible(true);
	};

	/**
   * open form register popup and close menu burger
   */
	const showModalRegister = () => {
		onClose();
		setTimeout(() => {
			setModalRegister(true);
		}, 1000);
	};
	/**
   * close form popup
   */
	const handleCancel = () => {
		setModalRegister(false);
		setModalLogin(false);
	};

	const closeModalWelcome = () => {
		setConnectVisible(false);
	};

	const deconnexion = () => {
		onClose();
		dispatch(deconnect());
	};

	//const handleSubmitLogin allows to send an axios request
	const handleSubmitLogin = (email, password) => {
		return (event) => {
			event.preventDefault();
			dispatch(sendLogin(email, password));
		};
	};

	// Close modalFormLogin after check_login valid, and value connect:true

	useEffect(
		() => {
			if (connect === true) {
				handleCancel();
				hideModalRegisterArtisan();
				connectModalVisible();
				setTimeout(closeModalWelcome, 2000);
			}
		},
		[ connect ]
	);

	/**
   * button for navigate towards form register artisan (use withRouter for manage history url)
   */
	// const ButtonGoToArtisanForm = withRouter(({ history }) => {
	//   return (
	//     <Button
	//       id="buttons"
	//       onClick={() => {
	//         handleCancel();
	//         //return history.push("/inscription/professionnel");
	//       }}
	//       style={{ width: "40%", margin: "1.5em" }}
	//     >
	//       Professionnel
	//     </Button>
	//   );
	// });

	const ButtonGoToArtisanForm = () => {
		return (
			<Button
				id="buttons"
				onClick={() => {
					handleCancel();
					showModalRegisterArtisan();
				}}
				style={{ width: '40%', margin: '1.5em' }}
			>
				Professionnel
			</Button>
		);
	};

	/**
   * button for navigate towards form register user (use withRouter for manage history url)
   */

	const ButtonGoToUserForm = withRouter(({ history }) => {
		return (
			<Button
				id="buttons"
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

	/**
   * admin connection
   */

	let token = cookies.get('TOKEN');

	let parseJwt = (token) => {
		try {
			return JSON.parse(atob(token.split('.')[1]));
		} catch (e) {
			return null;
		}
	};

	let tokenEmail = '';
	let admin = '';
	if (token != null) {
		admin = parseJwt(token).roles[0];
		tokenEmail = parseJwt(token).username;
		console.log(tokenEmail);
		console.log(parseJwt(token).roles[0]);
	}

	/**
 * register artisan modal
 */
	const [ registerVisibleArtisan, setRegisterVisibleArtisan ] = useState(false);

	const showModalRegisterArtisan = () => {
		setRegisterVisibleArtisan(true);
	};

	const hideModalRegisterArtisan = () => {
		setTimeout(() => {
			setRegisterVisibleArtisan(false), 2000;
		});
		console.log('handle cancel');
	};

	//submit of form
	const handleFormArtisan = (email, password, passwordCheck, siret) => {
		return (event) => {
			// console.log(email, password, passwordCheck);
			event.preventDefault();
			if (password === passwordCheck && password !== '') {
				// console.log('mots est correct');
				dispatch(sendRegisterArtisan(email, password, siret));
			}
		};
	};

	return (
		<div id="zheader">
			<Row className="header" type="flex" justify="space-around">
				<Col span={24}>
					<Col span={6}>
						{/** Button Burger */}
						<Button className="header-burger-button" id="burger" onClick={showDrawer}>
							<Icon type="menu" />
						</Button>

						{/** Menu of Burger */}
						<Drawer placement="top" onClose={onClose} visible={visible} closable={true}>
							<Row type="flex" justify="center" align="top">
								<img src={logo} alt="zartisan image" className="logo-zartisan" />
							</Row>
							<Row type="flex" justify="center" align="top">
								<Text>
									{connect === false && (
										<a href="#" onClick={showModalLogin}>
											Connexion
										</a>
									)}
									<Modal footer={null} title="Connexion" visible={modalLogin} onCancel={handleCancel}>
										<FormLogin
											artisanSelector={artisanSelector}
											handleSubmitLogin={handleSubmitLogin}
											handleCancel={handleCancel}
										/>
									</Modal>
									<Modal visible={connectVisible} onCancel={closeModalWelcome} footer={null}>
										<p>Bonjour vous êtes connecté</p>
									</Modal>

									{connect === true && admin !== 'ROLE_ADMIN' ? <a href="#">Profil</a> : ''}
									{connect === true && admin === 'ROLE_ADMIN' ? (
										<a href="http://localhost:8001/admin">Admin</a>
									) : (
										''
									)}
								</Text>
							</Row>
							<Row type="flex" justify="center" align="top">
								{connect === false && (
									<a href="#" onClick={showModalRegister}>
										Inscription
									</a>
								)}
								{connect === true && <a onClick={deconnexion}>Deconnexion</a>}

								<Modal
									footer={null}
									title="Inscription"
									visible={modalRegister}
									onCancel={handleCancel}
								>
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
				</Col>
			</Row>
			<Modal
				footer={null}
				title="Inscription Artisan"
				visible={registerVisibleArtisan}
				onCancel={hideModalRegisterArtisan}
			>
				<FormRegisterArtisan handleFormArtisan={handleFormArtisan} />
			</Modal>
		</div>
	);
};

export default Header;

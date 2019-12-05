/**
 * Imports of dependencies
 */
import React, { useState } from 'react';
import { Row, Col, Button, Icon, Drawer, Typography, Modal } from 'antd';
import 'antd/dist/antd.css';

/**
 * Local imports
 */
import './style.sass';
import logo from './picture/logo-zartisan.svg';

/**
 * Code
 */
const { Text } = Typography;

const Header = () => {
	const [ visible, setVisible ] = useState(false);
	const [ modalLogin, setModalLogin ] = useState(false);
	const [ modalRegister, setModalRegister ] = useState(false);
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

	const showModalLogin = () => {
		setModalLogin(true);
	};

	const showModalRegister = () => {
		setModalRegister(true);
	};
	const handleCancel = () => {
		setModalRegister(false);
		setModalLogin(false);
	};

	return (
		<div>
			<Row type="flex" justify="space-around" className="header">
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
								<a href="#" onClick={showModalLogin}>
									Connexion
								</a>
								<Modal footer={null} title="Connexion" visible={modalLogin} onCancel={handleCancel}>
									<FormLogin />
								</Modal>
							</Text>
						</Row>
						<Row type="flex" justify="center" align="top">
							<a href="#" onClick={showModalRegister}>
								Inscription
							</a>
							<Modal footer={null} title="Inscription" visible={modalRegister} onCancel={handleCancel}>
								<Row type="flex" justify="center" align="top">
									<Button style={{ width: '40%' }}>Particulier</Button>
								</Row>
								<Row type="flex" justify="center" align="top">
									<Button style={{ width: '40%', margin: '1.5em' }}>Professionnel</Button>
								</Row>
							</Modal>
						</Row>
					</Drawer>
				</Col>

				{/** logo header */}
				<Col span={18}>
					<img src={logo} alt="zartisan image" className="logo-zartisan" />
				</Col>
			</Row>
		</div>
	);
};

export default Header;

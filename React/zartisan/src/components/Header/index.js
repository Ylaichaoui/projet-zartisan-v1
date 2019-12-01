/**
 * Imports of dependencies
 */
import React, { useState } from 'react';
import { Row, Col, Button, Icon, Drawer, Typography } from 'antd';
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

	const showDrawer = () => {
		setVisible(true);
	};

	const onClose = () => {
		setVisible(false);
	};

	return (
		<div>
			<Row className="header">
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
						<Row type="flex" justify="center" align="top">
							<Text>
								<a href="#">Connection</a>
							</Text>
						</Row>
						<Row type="flex" justify="center" align="top">
							<a href="#">Inscription</a>
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

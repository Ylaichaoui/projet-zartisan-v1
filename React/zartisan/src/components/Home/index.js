/**
 * Imports of dependencies
 */
import React from 'react';
import { Row, Button, Icon, Menu, Dropdown } from 'antd';

/**
 * Local imports
 */
import './style.sass';
import france from './picture/france.svg';

/**
 * Code
 */

const { SubMenu } = Menu;

const Home = () => {
	/**
	 * menu of dropdown region
	 */
	const menuRegion = (
		<Menu>
			<Menu.Item key="1">Haut de france</Menu.Item>
			<Menu.Item key="2">Bretagne</Menu.Item>
			<Menu.Item key="3">Normandie</Menu.Item>
		</Menu>
	);
	/**
		 * menu of dropdown jobs
		 */
	const menuJobs = (
		<Menu style={{ width: '55%' }}>
			<SubMenu title="Batiment">
				<Menu.Item>Maçon</Menu.Item>
				<Menu.Item>Electricien</Menu.Item>
				<Menu.Item>Plombier</Menu.Item>
			</SubMenu>
			<SubMenu title="Alimentaire">
				<Menu.Item>Boulanger</Menu.Item>
				<Menu.Item>Charcutier</Menu.Item>
			</SubMenu>
			<SubMenu title="Aménagement d'intérieur">
				<Menu.Item>Designer d'intérieur</Menu.Item>
				<Menu.Item>Menuisier</Menu.Item>
			</SubMenu>
		</Menu>
	);
	return (
		<div className="home">
			<Row className="home-france">
				<img src={france} className="france-picture" />
			</Row>
			<Row type="flex" justify="space-around" align="middle">
				<Dropdown overlay={menuRegion} placement="topLeft">
					<Button className="home-button-region" style={{ backgroundColor: '#ad2102', color: 'white' }}>
						Choisissez une Région <Icon type="up" />
					</Button>
				</Dropdown>

				<Dropdown overlay={menuJobs} placement="topLeft">
					<Button
						className="ant-dropdown-link home-button-jobs"
						style={{ color: '#ad2102', fontWeight: 'bold' }}
						href="#"
					>
						Choisissez un métier <Icon type="up" />
					</Button>
				</Dropdown>

				<Button style={{ color: 'white', backgroundColor: '#595959', border: 'none' }}>Recherche</Button>
			</Row>
		</div>
	);
};

export default Home;

/**
 * Imports of dependencies
 */
import React, { useState } from 'react';
import { useSelector } from 'react-redux';
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
	const changeRegion = (event) => {
		setRegion(event.item.props.value);
	};

	const regions = useSelector((state) => state.regions);
	console.log(regions);

	const itemRegions = regions.map((region) => {
		return (
			<Menu.Item onClick={changeRegion} key={region.id} value={region.name}>
				{region.name}
			</Menu.Item>
		);
	});
	console.log(itemRegions);

	const menuRegion = <Menu>{itemRegions}</Menu>;
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

	const [ regionChange, setRegion ] = useState('Choisissez une Région');

	return (
		<div className="home">
			<Row type="flex" justify="space-around" align="middle">
				<Dropdown overlay={menuRegion} placement="bottomLeft">
					<Button className="home-button-region" style={{ backgroundColor: '#ad2102', color: 'white' }}>
						{regionChange} <Icon type="down" />
					</Button>
				</Dropdown>

				<Dropdown overlay={menuJobs} placement="bottomLeft">
					<Button
						className="ant-dropdown-link home-button-jobs"
						style={{ color: '#ad2102', fontWeight: 'bold' }}
						href="#"
					>
						Choisissez un métier <Icon type="down" />
					</Button>
				</Dropdown>

				<Button style={{ color: 'white', backgroundColor: '#595959', border: 'none' }}>Recherche</Button>
			</Row>
			<Row className="home-france">
				<img src={france} className="france-picture" />
			</Row>
		</div>
	);
};

export default Home;

/**
 * Imports of dependencies
 */
import React from 'react';
import { Row, Button, Icon } from 'antd';

/**
 * Local imports
 */
import './style.sass';
import france from './picture/france.svg';

/**
 * Code
 */
const Home = () => (
	<div className="home">
		<Row className="home-france">
			<img src={france} className="france-picture" />
		</Row>
		<Row type="flex" justify="space-around" align="middle">
			<Button className="home-button-region" style={{ backgroundColor: '#ad2102', color: 'white' }}>
				Choisissez une Région <Icon type="up" />
			</Button>
			<Button
				className="ant-dropdown-link home-button-jobs"
				style={{ color: '#ad2102', fontWeight: 'bold' }}
				href="#"
			>
				Choisissez un métier <Icon type="up" />
			</Button>
			<Button style={{ color: 'white', backgroundColor: '#595959', border: 'none' }}>Recherche</Button>
		</Row>
	</div>
);
export default Home;

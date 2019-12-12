/**
 * Imports of dependencies
 */
import React from 'react';
import { Row, Typography } from 'antd';
import { Link } from 'react-router-dom';

/**
 * Local imports
 */
import './style.sass';

/**
 * Code
 */
const { Text } = Typography;
const Footer = () => (
	<Row type="flex" justify="space-around" align="middle" className="footer">
		<Text className="footer-text">- Z'artisan 2019</Text>
		<Link to="/mentions-legal">Mentions légales</Link>
	</Row>
);
export default Footer;

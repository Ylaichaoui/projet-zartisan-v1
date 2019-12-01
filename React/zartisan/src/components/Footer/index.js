/**
 * Imports of dependencies
 */
import React from 'react';
import { Row, Typography } from 'antd';

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
		<a href="#">Mentions légales</a>
	</Row>
);
export default Footer;

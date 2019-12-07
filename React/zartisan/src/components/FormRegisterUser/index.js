/**
 * Imports of dependencies
 */
import React from 'react';
import { Form, Input, Row, Button } from 'antd';

/**
 * Local imports
 */
import './style.sass';

const FormRegisterUser = () => {
	return (
		<div className="register-user">
			<Row type="flex" justify="space-around" align="middle">
				<Form className="user-form">
					<Form.Item label="E-mail">
						<Input />
					</Form.Item>
					<Form.Item label="Mot de passe" hasFeedback>
						<Input.Password />
					</Form.Item>
					<Form.Item label="Confirmer votre mot de passe" hasFeedback>
						<Input.Password />
					</Form.Item>
					<Form.Item>
						<Button type="primary" htmlType="submit">
							Confirmer
						</Button>
					</Form.Item>
				</Form>
			</Row>
		</div>
	);
};

export default FormRegisterUser;

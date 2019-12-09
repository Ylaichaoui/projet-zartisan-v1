/**
 * Imports of dependencies
 */
import React from 'react';
import { Form, Input, Row, Button } from 'antd';

/**
 * Local imports
 */
import './style.sass';

const FormRegisterArtisan = () => {
	return (
		<div className="register-artisan">
			<Row type="flex" justify="space-around" align="middle">
				<Form className="artisan-form">
					<Form.Item label="E-mail">
						<Input />
					</Form.Item>
					<Form.Item label="Mot de passe" hasFeedback>
						<Input.Password />
					</Form.Item>
					<Form.Item label="Confirmer votre mots de passe" hasFeedback>
						<Input.Password />
					</Form.Item>
					<Form.Item label="Siret">
						<Input />
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

export default FormRegisterArtisan;

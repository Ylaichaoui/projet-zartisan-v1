import React from 'react';
import { Row, Col, List, Avatar, Icon, Dropdown, Menu, Button } from 'antd';
import 'antd/dist/antd.css';
import './style.sass';

const ListArtisan = () => {
	const listData = [];
	for (let i = 0; i < 23; i++) {
		listData.push({
			href: 'http://ant.design',
			title: `ant design part ${i}`,
			avatar: 'https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png',
			description: 'Ant Design, a design language for background applications, is refined by Ant UED Team.',
			content:
				'We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people create their product prototypes beautifully and efficiently.'
		});
	}

	const menu = (
		<Menu>
			<Menu.Item key="0">
				<a href="http://www.alipay.com/">1st menu item</a>
			</Menu.Item>
			<Menu.Item key="1">
				<a href="http://www.taobao.com/">2nd menu item</a>
			</Menu.Item>
			<Menu.Divider />
			<Menu.Item key="3">3rd menu item</Menu.Item>
		</Menu>
	);

	return (
		<div>
			<Row id="menu">
				<Col span={24}>
					<Dropdown overlay={menu} trigger={[ 'click' ]}>
						<Button>
							<a className="ant-dropdown-link" href="#">
								REGION<Icon type="down" />
							</a>
						</Button>
					</Dropdown>
					<Dropdown overlay={menu} trigger={[ 'click' ]}>
						<Button>
							<a className="ant-dropdown-link" href="#">
								CATEGORIE <Icon type="down" />
							</a>
						</Button>
					</Dropdown>
					<Dropdown overlay={menu} trigger={[ 'click' ]}>
						<Button>
							<a className="ant-dropdown-link" href="#">
								NOTE <Icon type="down" />
							</a>
						</Button>
					</Dropdown>
				</Col>
			</Row>

			<List
				itemLayout="vertical"
				size="small"
				pagination={{
					onChange: (page) => {
						console.log(page);
					},
					pageSize: 3
				}}
				dataSource={listData}
				renderItem={(item) => (
					<List.Item>
						<List.Item.Meta
							avatar={<Avatar src={item.avatar} />}
							title={<a href={item.href}>{item.title}</a>}
							description={item.description}
						/>
						{item.content}
					</List.Item>
				)}
			/>
		</div>
	);
};
export default ListArtisan;

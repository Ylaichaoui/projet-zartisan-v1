import React from 'react';
import 'antd/dist/antd.css';
import { Row, Col, Carousel, Button, Rate, List, Comment, Tooltip } from 'antd';

import img from 'src/components/Header/picture/logo-zartisan.svg';
import './style.sass';
import moment from 'moment';

const PageArtisan = () => {
	const data = [
		{
			actions: [ <span key="comment-list-reply-to-0">Reply to</span> ],
			author: 'Han Solo',
			avatar: 'https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png',
			content: (
				<p>
					We supply a series of design principles, practical patterns and high quality design resources
					(Sketch and Axure), to help people create their product prototypes beautifully and efficiently.
				</p>
			),
			datetime: (
				<Tooltip title={moment().subtract(1, 'days').format('YYYY-MM-DD HH:mm:ss')}>
					<span>{moment().subtract(1, 'days').fromNow()}</span>
				</Tooltip>
			)
		},
		{
			actions: [ <span key="comment-list-reply-to-0">Reply to</span> ],
			author: 'Han Solo',
			avatar: 'https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png',
			content: (
				<p>
					We supply a series of design principles, practical patterns and high quality design resources
					(Sketch and Axure), to help people create their product prototypes beautifully and efficiently.
				</p>
			),
			datetime: (
				<Tooltip title={moment().subtract(2, 'days').format('YYYY-MM-DD HH:mm:ss')}>
					<span>{moment().subtract(2, 'days').fromNow()}</span>
				</Tooltip>
			)
		}
	];
	return (
		<div id="pageArtisan">
			<Row>
				<Col span={9}>
					<img src={img} alt="image artisan" className="imgArtisan" />
					<Rate disabled defaultValue={4} />
				</Col>
				<Col span={15}>
					<div>Nom artisan</div>
				</Col>
			</Row>
			<Row>
				<Col span={24}>
					<div>adresse</div>
					<div>
						code postal <span> Ville</span>
					</div>
					<Button id="buttons">CONTACTER</Button>
				</Col>
			</Row>

			<Row>
				<Carousel autoplay>
					<div>
						<h3>
							<img className="imgCarousel" src={img} alt="" /> 1
						</h3>
					</div>
					<div>
						<h3>
							<img className="imgCarousel" src={img} alt="" /> 2
						</h3>
					</div>
					<div>
						<h3>
							<img className="imgCarousel" src={img} alt="" /> 3
						</h3>
					</div>
				</Carousel>
			</Row>
			<Row>
				<Button id="buttons">COMMENTER</Button>
				<List
					className="comment-list"
					header={`${data.length} replies`}
					itemLayout="horizontal"
					dataSource={data}
					renderItem={(item) => (
						<li>
							<Comment
								actions={item.actions}
								author={item.author}
								avatar={item.avatar}
								content={item.content}
								datetime={item.datetime}
							/>
						</li>
					)}
				/>
			</Row>
		</div>
	);
};
export default PageArtisan;

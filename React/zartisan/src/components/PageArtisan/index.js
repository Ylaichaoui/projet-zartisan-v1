import React, { useEffect } from 'react';
import 'antd/dist/antd.css';
import { Row, Col, Carousel, Button, Rate, List, Comment, Tooltip, Link } from 'antd';
import { useSelector } from 'react-redux';

import img from 'src/components/Header/picture/logo-zartisan.svg';
import './style.sass';
import moment from 'moment';
import { artisanInfo } from '../../store/artisan/actions';

const PageArtisan = () => {
	const artisanObject = useSelector((state) => state.artisan);
	console.log(artisanObject);

	const dataArtisan = [];
	dataArtisan.push(artisanObject);

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

	console.log('picture: ', artisanObject.picture, 'note : ', artisanObject.averageRate);

	const Rating = () => {
		return <Rate style={{ fontSize: '1em' }} disabled defaultValue={artisanObject.averageRate} />;
	};
	return (
		<div id="page-artisan">
			<div className="page-artisan-description">
				<div>
					<Col span={14}>
						<div>{artisanObject.company}</div>
					</Col>
					<Col span={14}>
						<img
							style={{ width: '60px' }}
							src={`../src/styles/pictures/company/${artisanObject.picture}`}
						/>
						<Rating />
					</Col>
				</div>
				<Row>
					<Col>
						<div>
							{artisanObject.numberWay}
							<span>{artisanObject.way}</span>
						</div>
						<div>
							{artisanObject.postalCode} <span>{artisanObject.city}</span>
						</div>
						<h1>Contacter</h1>
						<p>{artisanObject.phone}</p>
						<p>{artisanObject.email}</p>
					</Col>
				</Row>
			</div>

			<Row>
				<Carousel autoplay>
					<div>
						<h3>
							<img
								className="imgCarousel"
								src={`src/styles/pictures/company/${artisanObject.picture}`}
								alt=""
							/>{' '}
							1
						</h3>
					</div>
					<div>
						<h3>
							<img
								className="imgCarousel"
								src={`src/styles/pictures/company/${artisanObject.picture}`}
								alt=""
							/>
							2
						</h3>
					</div>
					<div>
						<h3>
							<img
								className="imgCarousel"
								src={`src/styles/pictures/company/${artisanObject.picture}`}
								alt=""
							/>{' '}
							3
						</h3>
					</div>
				</Carousel>
			</Row>

			<Row>
				<Button>COMMENTER</Button>
				{
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
				}{' '}
			</Row>
		</div>
	);
};
export default PageArtisan;

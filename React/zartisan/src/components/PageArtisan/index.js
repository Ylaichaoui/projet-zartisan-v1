import React, { useState } from 'react';
import 'antd/dist/antd.css';
import { Row, Col, Carousel, Button, Rate, List, Comment, Tooltip, Link, Popover } from 'antd';
import { useSelector, useDispatch } from 'react-redux';

import './style.sass';
import moment from 'moment';
import { artisanInfo } from '../../store/artisan/actions';
import cookies from 'js-cookie';
import { sendRate } from 'src/store/rate/actions';

const PageArtisan = () => {
	const artisanSelector = useSelector((state) => state.artisan);
	let artisanObject = {};
	for (let artisan in artisanSelector) {
		console.log(artisanSelector[artisan]);
		artisanObject = artisanSelector[artisan];
	}

	console.log(artisanObject);

	const connect = useSelector((state) => state.connect);
	let token = '';
	if (connect === true) {
		console.log('je suis connecté');
		token = cookies.get('TOKEN');
	}

	let parseJwt = (token) => {
		try {
			return JSON.parse(atob(token.split('.')[1]));
		} catch (e) {
			return null;
		}
	};

	console.log(parseJwt(token));

	let user = 'ROLE_UNDEFINED';
	let mail = '';
	if (parseJwt(token) != null) {
		user = parseJwt(token).roles[0];
		mail = parseJwt(token).username;
	}

	//console.log(user);
	//console.log(email);
	const dataArtisan = [];
	dataArtisan.push(artisanObject);

	let phone = '';
	artisanObject.phone != undefined ? (phone = artisanObject.phone.slice(1)) : phone;

	//console.log(phone);
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

	//console.log('picture: ', artisanObject.picture, 'note : ', artisanObject.averageRate);

	const Rating = () => {
		return <Rate style={{ fontSize: '1em' }} disabled defaultValue={artisanObject.averageRate} />;
	};

	/**
	 * Rate a artisan
	 */

	/**Hooks for display popover of rate link */
	const [ visible, setVisible ] = useState(false);
	const [ value, setValue ] = useState(null);

	/**
	 * open popover
	 */
	const handleVisibleChange = () => {
		setVisible(true);
	};

	/**
   	* close popover
	   */
	const dispatch = useDispatch();
	const idArtisan = artisanObject.id;
	const hide = () => {
		setVisible(false);
		console.log('vote', value, 'mail', mail, 'id', idArtisan);
		dispatch(sendRate(idArtisan, mail, value));
	};

	/**
 *  rate value
 */

	const handleChange = (event) => {
		console.log(event);
		setValue(event);
	};

	const content = (
		<div>
			<p>Evaluer votre artisan :</p>
			<Rate onChange={handleChange} value={value} />
			<Button onClick={hide}>Valider</Button>
		</div>
	);

	return (
		<div id="page-artisan">
			<Row>
				<div className="page-artisan-description">
					<Row>
						<div>
							<div>{artisanObject.company}</div>
						</div>
					</Row>
					<div className="artisan-description">
						<Row>
							<Col span={15}>
								<div>
									<img
										className="description-picture"
										src={`../src/styles/pictures/company/${artisanObject.picture}`}
									/>
									<Rating />
								</div>
							</Col>
							<Col span={9}>
								<div className="description-info">
									<div>
										{artisanObject.numberWay} <span>{artisanObject.way}</span>
									</div>
									<div>
										{artisanObject.postalCode} <span>{artisanObject.city}</span>
									</div>
									{user != 'ROLE_UNDEFINED' && (
										<div>
											<h1>Contacter</h1>
											<a href={`mailto:${artisanObject.email}`}>{artisanObject.email}</a>
											<a href={`tel:+33${phone}`}>{artisanObject.phone}</a>
										</div>
									)}
								</div>
							</Col>
						</Row>
					</div>
				</div>
			</Row>

			<div>
				{user != 'ROLE_UNDEFINED' && (
					<Popover
						placement="top"
						trigger="click"
						onVisibleChange={handleVisibleChange}
						visible={visible}
						content={content}
					>
						<a>Evaluation</a>
					</Popover>
				)}
			</div>

			<div className="page-artisan-caroussel">
				<Carousel autoplay>
					<div>
						<h3>
							<img className="imgCarousel" src="../src/styles/pictures/caroussel/artisan2.jpg" alt="" />
						</h3>
					</div>
					<div>
						<h3>
							<img className="imgCarousel" src="../src/styles/pictures/caroussel/artisan4.jpeg" alt="" />
						</h3>
					</div>
					<div>
						<h3>
							<img
								className="imgCarousel"
								src="../src/styles/pictures/caroussel/artisan3.jpeg"
								alt=""
							/>{' '}
						</h3>
					</div>
				</Carousel>
			</div>

			<div className="page-artisan-commentary">
				<Button id="buttons">COMMENTER</Button>
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
			</div>
		</div>
	);
};
export default PageArtisan;

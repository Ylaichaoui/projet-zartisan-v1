import React, { useState, useEffect } from 'react';
import 'antd/dist/antd.css';
import { Row, Col, Carousel, Button, Rate, List, Comment, Tooltip, Link, Popover, Icon, Form, Input } from 'antd';
import { useSelector, useDispatch } from 'react-redux';
import { withRouter } from 'react-router-dom';
import classNames from 'classnames';

import './style.sass';
import moment from 'moment';
import cookies from 'js-cookie';
import { sendRate } from 'src/store/rate/actions';
import { alertAdvice } from 'src/store/advice/actions';

const { TextArea } = Input;
const PageArtisan = () => {
	const artisanSelector = useSelector((state) => state.artisan);
	console.log('big object', artisanSelector);
	const averageRate = useSelector((state) => state.rate);
	//console.log('note moyenne', averageRate);

	const advice = useSelector((state) => state.advice);
	console.log('object advice', advice.report);

	let artisanObject = {};
	for (let artisan in artisanSelector) {
		//console.log(artisanSelector[artisan]);
		artisanObject = artisanSelector[artisan];
	}

	if (averageRate != null) {
		artisanObject.averageRate = averageRate;
	}

	//console.log(artisanObject);

	const connect = useSelector((state) => state.connect);
	let token = '';
	if (connect === true) {
		//console.log('je suis connecté');
		token = cookies.get('TOKEN');
	}

	let parseJwt = (token) => {
		try {
			return JSON.parse(atob(token.split('.')[1]));
		} catch (e) {
			return null;
		}
	};

	//console.log(parseJwt(token));

	let user = -1;
	let artisanUser = -1;
	let mail = '';
	if (parseJwt(token) != null) {
		user = parseJwt(token).roles.indexOf('ROLE_USER');
		artisanUser = parseJwt(token).roles.indexOf('ROLE_ARTISAN');
		mail = parseJwt(token).username;
	}

	//console.log(user);
	//console.log(artisanUser);
	//console.log(email);
	const dataArtisan = [];
	dataArtisan.push(artisanObject);

	let phone = '';
	artisanObject.phone != undefined ? (phone = artisanObject.phone.slice(1)) : phone;
	//console.log(phone);

	console.log(artisanObject.advice);
	let arrayAdvice = [];
	if (artisanObject.advice !== undefined) {
		arrayAdvice = artisanObject.advice;
	}

	console.log(arrayAdvice);
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
	const [ visibleRate, setVisibleRate ] = useState(false);
	const [ value, setValue ] = useState(null);

	/**
   * open popover
   */
	const handleVisibleChange = () => {
		setVisibleRate(true);
	};

	/**
   * close popover
   */
	const dispatch = useDispatch();
	const idArtisan = artisanObject.id;

	const hide = () => {
		setVisibleRate(false);
	};

	/**
   *  rate value
   */

	const handleChange = (event) => {
		console.log(event);
		setValue(event);
		console.log('vote', event, 'mail', mail, 'id', idArtisan);
		dispatch(sendRate(idArtisan, mail, event));
	};

	const content = (
		<div onClick={hide}>
			<p>Evaluer votre artisan :</p>
			<Rate onChange={handleChange} value={value} />
		</div>
	);

	/**
   * redirect to register user onClick Contacter
   */

	/**
   * button for navigate towards form register user (use withRouter for manage history url)
   */
	const ButtonContact = withRouter(({ history }) => {
		return (
			<Button
				onClick={() => {
					return history.push('/inscription/particulier');
				}}
				id="buttons"
			>
				Contacter
			</Button>
		);
	});

	/**
   * button advice
   */

	const [ visibleSendAdvice, setVisibleSendAdivce ] = useState(false);
	const [ changeAdvice, setChangeAdivce ] = useState('');

	const visiblePopAdvice = () => {
		setVisibleSendAdivce(true);
	};

	const hidePopAdvice = () => {
		setVisibleSendAdivce(false);
	};

	const handleAreaComment = (event) => {
		event.preventDefault();

		hidePopAdvice();
		return console.log('send advice');
	};

	const changeArea = (value) => {
		() => {
			setChangeAdivce(value.target.textContent);
		};
		console.log(changeAdvice);
	};

	const areaComment = (
		<div>
			<Form onSubmit={handleAreaComment}>
				<Form.Item>
					<TextArea rows={4} onChange={changeArea} />
				</Form.Item>
				<Form.Item>
					<Button htmlType="submit" id="buttons">
						Envoyer
					</Button>
				</Form.Item>
			</Form>
		</div>
	);

	const ButtonAdvice = withRouter(({ history }) => {
		const handleAdvice = () => {
			if (user !== -1 || artisanUser !== -1) {
				console.log('commentaire');
			} else {
				history.push('/inscription/particulier');
			}
		};

		return (
			<div>
				<Popover
					placement="bottom"
					content={areaComment}
					onVisibleChange={visiblePopAdvice}
					visible={visibleSendAdvice}
					trigger="click"
				>
					<Button onClick={handleAdvice} id="buttons">
						Donnez votre avis
					</Button>
				</Popover>
			</div>
		);
  });
  
  

	/**
   * report a advice
   */

	const [ idAdvice, setIdAdvice ] = useState(null);

	const handleAlert = (event) => {
		//console.log(event.target.value);
		//console.log('hello');
		dispatch(alertAdvice(event.target.value));
		setIdAdvice(event.target.value);
	};

	return (
		<div id="page-artisan">
			<Row>
				<div className="page-artisan-description">
					<Row>
						<div>
							<div><h4>{artisanObject.company}</h4></div>
						</div>
					</Row>
					<div className="artisan-description">
						<Row>
							<Col span={12}>
								<div>
									<img
										className="description-picture"
										src={`../src/styles/pictures/company/${artisanObject.picture}`}
									/>
									<Rating />
								</div>
							</Col>
							<Col span={12}>
								<div className="description-info">
									<div>
										{artisanObject.numberWay} {artisanObject.typeWay} {artisanObject.way}{' '}
										{artisanObject.postalCode} {artisanObject.city}
									</div>
								</div>
							</Col>

							{user !== -1 || artisanUser !== -1 ? (
								<Col span={24}>
									<div>
										<p>
											Email : <a href={`mailto:${artisanObject.email}`}>{artisanObject.email}</a>
										</p>
										<p>
											Téléphone : <a href={`tel:+33${phone}`}>{artisanObject.phone}</a>
										</p>
									</div>
								</Col>
							) : (
								<ButtonContact />
              )}
              <Col span={24}>
									<div>
										<p>
											{artisanObject.companyDescription}
                    </p>
									</div>
								</Col>
						</Row>
					</div>
				</div>
			</Row>

			<div className="page-artisan-caroussel">
				<Carousel autoplay>
					<div>
						<h3>
							<img className="imgCarousel" src="../src/styles/pictures/caroussel/artisan2.jpeg" alt="" />
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

			<div className="page-artisan-commentary" />
			<Row>
				<Col span={24}>
					<ButtonAdvice />
					{user !== -1 || artisanUser !== -1 ? (
						<div>
							<Popover
								placement="bottom"
								trigger="click"
								onVisibleChange={handleVisibleChange}
								visible={visibleRate}
								content={content}
							>
								<Button id="buttons">Evaluez</Button>
							</Popover>
						</div>
					) : (
						''
					)}
				</Col>
			</Row>
			{user !== -1 || artisanUser !== -1 ? (
				<div>
					<div id="com">
						{arrayAdvice.length} <Icon type="message" />
					</div>
					<List
						className="comment-list"
						id="comment"
						itemLayout="horizontal"
						dataSource={arrayAdvice}
						renderItem={(item) => (
							<li>
								{console.log('response....', advice.report)}
								{advice.report == 'success' ? (
									item.id == idAdvice && (item.userAuthor.isReported = true)
								) : (
									item.id && (item.userAuthor.isReported = true)
								)}
								{console.log('reported', item.userAuthor.isReported)}
								<Comment
									author={item.userAuthor.firstname}
									avatar={`../src/styles/pictures/user/${item.userAuthor.picture}`}
									content={item.body}
									datetime={
										<div>
											{item.createdAt}{' '}
											<Button value={item.id} onClick={handleAlert}>
												{item.userAuthor.isReported === true ? (
													<Icon style={{ color: 'red' }} type="alert" />
												) : (
													<Icon type="alert" />
												)}
											</Button>
										</div>
									}
								/>
							</li>
						)}
					/>
				</div>
			) : (
				''
			)}
		</div>
	);
};
export default PageArtisan;

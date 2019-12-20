import React, { useState, useEffect } from 'react';
import 'antd/dist/antd.css';

import {
	Row,
	Col,
	Carousel,
	Button,
	Rate,
	List,
	Comment,
	Tooltip,
	Link,
	Popover,
	Icon,
	Form,
	Input,
	Modal
} from 'antd';
import { useSelector, useDispatch } from 'react-redux';
import { withRouter } from 'react-router-dom';

import classNames from 'classnames';

import './style.sass';
import moment from 'moment';
import cookies from 'js-cookie';
import { sendRate } from 'src/store/rate/actions';
import { alertAdvice } from 'src/store/advice/actions';
import { sendAdvice } from 'src/store/advice/actions';

import { artisanData } from 'src/store/artisan/actions';
import Carousel1 from 'src/styles/pictures/caroussel/artisan10.jpg';

const { TextArea } = Input;
const PageArtisan = () => {
	const artisanSelector = useSelector((state) => state.artisan);

	const averageRate = useSelector((state) => state.rate);
	//console.log('note moyenne', averageRate);

	const advice = useSelector((state) => state.advice);

	//console.log("object advice", advice);

	let artisanObject = {};
	let adviceObject = [];
	for (let artisan in artisanSelector) {
		//console.log(artisanSelector[artisan]);
		artisanObject = artisanSelector[0];
		adviceObject = artisanSelector[1];
	}

	if (averageRate != null) {
		artisanObject.averageRate = averageRate;
	}

	const connect = useSelector((state) => state.connect);
	let token = '';
	if (connect === true) {
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

	//console.log(artisanObject.advice);
	let arrayAdvice = [];
	if (artisanObject.advice !== undefined) {
		arrayAdvice = artisanObject.advice;
	}

	//console.log(arrayAdvice);

	//console.log('picture: ', artisanObject.picture, 'note : ', artisanObject.averageRate);

	const Rating = () => {
		return (
			<Rate
				className="ratingCompany"
				style={{ fontSize: '1em' }}
				disabled
				defaultValue={artisanObject.averageRate}
			/>
		);
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

	const emailArtisan = artisanObject.email;

	//console.log('request artisan', idArtisan, emailArtisan);

	const hide = () => {
		setVisibleRate(false);
	};

	/**
   *  rate value
   */

	const handleChange = (event) => {
		//console.log(event);
		setValue(event);
		//console.log("vote", event, "mail", mail, "id", idArtisan);
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
	const contentContact = (
		<div>
			<p>Pour accéder aux informations de contact veuillez-vous enregistrer et valider votre adresse email</p>
		</div>
	);

	const ButtonContact = () => {
		return (
			<Popover placement="bottom" content={contentContact} trigger="click">
				<Button id="buttons" className="buttonInscription">
					Contacter
				</Button>
			</Popover>
		);
	};

	/**
   * button advice
   */

	const [ visibleSendAdvice, setVisibleSendAdvice ] = useState(false);
	const [ changeAdvice, setChangeAdvice ] = useState(null);

	const visiblePopAdvice = () => {
		setVisibleSendAdvice(true);
	};

	const hidePopAdvice = () => {
		setVisibleSendAdvice(false);
	};

	/**
   * submit form
   */

	const changeValueArea = (valueArea) => {
		setChangeAdvice(valueArea);
	};

	const changeArea = (value) => {
		let valueArea = value.target.value;
		//console.log(valueArea);
		changeValueArea(valueArea);
	};

	const handleAreaComment = (event) => {
		event.preventDefault();

		//console.log('mail', mail, 'artisanid', idArtisan, 'body', changeAdvice);
		hidePopAdvice();
		dispatch(sendAdvice(mail, idArtisan, changeAdvice));

		setTimeout(() => {
			dispatch(artisanData(idArtisan, emailArtisan));
		}, 2000);
	};

	//console.log("changeAdvice : ", changeAdvice);

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

	const contentAdvice = (
		<div>
			<p>Pour accéder aux commentaires veuillez-vous enregistrer et valider votre adresse email</p>
		</div>
	);

	const ButtonAdvice = () => {
		const handleAdvice = () => {
			if (user !== -1 || artisanUser !== -1) {
				//console.log("commentaire");
				visiblePopAdvice();
			}
		};

		if (user !== -1 || artisanUser !== -1) {
			return (
				<Button onClick={handleAdvice} id="buttons">
					Donnez votre avis
				</Button>
			);
		} else {
			return (
				<Popover placement="bottom" content={contentAdvice} trigger="click">
					<div>
						<Button id="buttons">Donnez votre avis</Button>
					</div>
				</Popover>
			);
		}
	};

	/**
   * report a advice
   */

	const handleAlert = (event) => {
		dispatch(alertAdvice(event.target.value));

		setTimeout(() => {
			dispatch(artisanData(idArtisan, emailArtisan));
		}, 2000);
	};

	return (
		<div id="page-artisan">
			<Row>
				<div className="page-artisan-description">
					<Row>
						<div>
							<div id="companyName">
								<h4>{artisanObject.company}</h4>
							</div>
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
									{user !== -1 || artisanUser !== -1 ? (
										<div>
											<Popover
												placement="bottom"
												trigger="click"
												onVisibleChange={handleVisibleChange}
												visible={visibleRate}
												content={content}
											>
												<a className="evaluez">évaluez</a>
											</Popover>
										</div>
									) : (
										''
									)}
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
									<div className="divDescriptionEmailPhone">
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
									<p>{artisanObject.companyDescription}</p>
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
							<img className="imgCarousel" src={Carousel1} alt="" />
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
				<Col span={24} id="back-patch">
					<ButtonAdvice />
					<Modal footer={null} visible={visibleSendAdvice} onCancel={hidePopAdvice}>
						{areaComment}
					</Modal>
				</Col>
			</Row>

			{user !== -1 || artisanUser !== -1 ? (
				<div id="background-com">
					<div id="com">
						{adviceObject.length} <Icon type="message" />
					</div>
					<List
						className="comment-list"
						id="comment"
						itemLayout="horizontal"
						dataSource={adviceObject}
						renderItem={(item) => (
							<li>
								<Comment
									author={item.userAuthor.firstname}
									avatar={`../src/styles/pictures/user/${item.userAuthor.picture}`}
									content={item.body}
									datetime={
										<div>
											{item.createdAt}{' '}
											<Button id="design" value={item.id} onClick={handleAlert}>
												{item.isReported ? (
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

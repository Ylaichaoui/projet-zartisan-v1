import React, { useState, useEffect } from 'react';
import { Row, Col, List, Avatar, Icon, Dropdown, Menu, Button, Cascader, Rate } from 'antd';

import 'antd/dist/antd.css';
import './style.sass';
import { useSelector, useDispatch } from 'react-redux';
import { getRegions } from 'src/store/regions/actions';
import { getJobs } from 'src/store/jobs/actions';
import { postHomeSearch } from 'src/store/search/actions';
import { withRouter, Link } from 'react-router-dom';
import { artisanData } from 'src/store/artisan/actions';

const ListArtisan = () => {
	/**
	 *  search object from home
	 */
	const artisandata = useSelector((state) => state.search);

	//console.log('listartisan', artisandata);
	let arrayArtisan = [];
	for (let data in artisandata) {
		arrayArtisan = artisandata[data];
	}

	//console.log(arrayArtisan);

	const listData = [];
	let objectArtisan = {};
	for (let d in arrayArtisan) {
		objectArtisan = arrayArtisan[d];
		listData.push(objectArtisan);
	}

	//console.log(objectArtisan);

	//console.log('hello', listData);

	useEffect(() => {
		dispatch(getRegions());
		dispatch(getJobs());

		//console.log(getRegions(Cookies.get("TOKEN");));
	}, []);
	const dispatch = useDispatch();
	const regions = useSelector((state) => state.regions);
	const jobs = useSelector((state) => state.jobs);
	//console.log('select', regions);
	//console.log('select', jobs);
	/**
	* menu of dropdown region
	*/
	const changeRegion = (event) => {
		setRegion(event.item.props.value);
	};

	/**
	* list item menu
	*/

	const itemRegions = regions.map((regionObject) => {
		const array = [];
		for (let regionCode in regionObject) {
			const region = { id: regionCode, name: regionObject[regionCode] };
			//console.log(region);
			array.push(region);
		}
		//console.log('spray', array);
		const item = array.map((region) => {
			//	console.log('item', region.id);
			return (
				<Menu.Item onClick={changeRegion} key={region.id} value={region.name}>
					{region.name}
				</Menu.Item>
			);
		});
		return item;
	});

	//	console.log('array', itemRegions);

	const menuRegion = <Menu>{itemRegions}</Menu>;
	const [ regionChange, setRegion ] = useState('Choisissez une Région');

	const [ jobChange, setJob ] = useState([]);

	/**
	* list item menu
	*/
	let arrayJobb = [];
	for (let j in jobs) {
		//console.log('forin', jobs[j]);
		arrayJobb = jobs[j];
	}

	//console.log(arrayJobb);

	const itemJobs = arrayJobb.map((job) => {
		//console.log('first-map', job);
		let nameValue = '';
		let idValue = '';
		let arrayMyJobs = [];
		for (let j in job.jobs) {
			nameValue = job.jobs[j].name;
			idValue = job.jobs[j].id;
			arrayMyJobs.push({ value: idValue, label: nameValue });
		}
		//console.log(arrayMyJobs);
		//console.log('forindansmap', nameValue, idValue);

		const newObjectJob = {
			value: job.id,
			label: job.name,
			children: arrayMyJobs
		};
		//console.log('nouveau objet : ', newObjectJob);
		return newObjectJob;
	});

	//console.log(itemJobs);

	const onChangeJob = (event) => {
		setJob(event);
	};

	const ButtonSearchArtisanList = () => {
		const handleSearch = () => {
			dispatch(postHomeSearch(regionChange, jobChange[1]));
		};
		return (
			<Button
				className="home-button-search"
				id="buttons"
				style={{ color: 'white', backgroundColor: '#bb9574', border: 'none' }}
				onClick={handleSearch}
			>
				Recherche
			</Button>
		);
	};

	/**
	 * Link artisan
	 */

	const LinkArtisan = withRouter(({ history, item }) => {
		const handleSearch = () => {
			dispatch(artisanData(item.id, item.email));
			setTimeout(() => {
				history.push(`/page-artisan/${item.company}`);
			}, 1000);
		};
		return <a onClick={handleSearch}>{item.company}</a>;
  });

	return (
		<div className="list-artisan-content">
			<Row type="flex" justify="space-around" align="middle">
				<Dropdown overlay={menuRegion} placement="bottomLeft">
					<Button className="home-button-region" style={{ backgroundColor: '#bb9574', color: 'white' }}>
						{regionChange} <Icon type="down" />
					</Button>
				</Dropdown>
				<Cascader
					className="home-cascader-jobs"
					options={itemJobs}
					placeholder="Choisissez un métier"
					onChange={onChangeJob}
				/>
				<ButtonSearchArtisanList />
			</Row>

			<List
				itemLayout="horizontal"
				size="small"
				pagination={{
					onChange: (page) => {
						console.log(page);
					},
					pageSize: 5
				}}
				dataSource={listData}
				renderItem={(item) => (
					<List.Item>
						<List.Item.Meta
							className="ant-list-item"
							avatar={
								<img style={{ width: '60px' }} src={`src/styles/pictures/company/${item.picture}`} />
							}
							title={<LinkArtisan item={item} />}
							description={item.companyDescription.substring(0,50)+" ..."}
						/>
						<Rate style={{ fontSize: '1em' }} disabled defaultValue={item.averageRate} />
					</List.Item>
				)}
			/>
		</div>
	); //"src/styles/pictures/company/company1.png"
};
export default ListArtisan;

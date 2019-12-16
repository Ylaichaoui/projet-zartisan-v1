/**
 * Imports of dependencies
 */
import React, { useState, useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { Row, Button, Icon, Menu, Dropdown, Cascader } from 'antd';
import { withRouter } from 'react-router-dom';

/**
 * Local imports
 */
import './style.sass';
import france from './picture/france.svg';
import { getRegions } from 'src/store/regions/actions';
import { getJobs } from 'src/store/jobs/actions';
import { postHomeSearch } from 'src/store/search/actions';
/**
 * Code
 */

const Home = () => {
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

	/**
	 * Button search artisan list
	 */
	const ButtonSearchArtisanList = withRouter(({ history }) => {
		const handleSearch = () => {
			dispatch(postHomeSearch(regionChange, jobChange[1]));
			setTimeout(() => {history.push('/liste-artisan')}, 1500);
		};
		return (
			<Button className="home-button-search" id="buttons" onClick={handleSearch}>
				Recherche
			</Button>
		);
	});

	return (
		<div className="home">
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
			</Row>
			<Row type="flex" justify="space-around" align="middle" className="home-france">
				<img src={france} className="france-picture" />
				<ButtonSearchArtisanList />
			</Row>
		</div>
	);
};

export default Home;

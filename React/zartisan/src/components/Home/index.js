/**
 * Imports of dependencies
 */
import React, { useState, useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { Row, Button, Icon, Menu, Dropdown, Cascader } from 'antd';
import { withRouter } from 'react-router-dom';
import classNames from 'classnames';
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
	const [ regionChange, setRegion ] = useState('Choisissez une Région');

	const changeRegion = (event) => {
		setRegion(event.item.props.value);

		dispatch(getJobs(event.item.props.value));
		console.log('region', event.item.props.value);
		visibleJobDropdown();
		//setJobChange('Choisissez votre métier');
	};

	useEffect(() => {
		console.log('new ', jobs);
		if (jobs != null) {
			//setJobChange('Choisissez votre métier');
		} else {
			setJobChange('Aucun métier');
		}
	});

	useEffect(() => {
		dispatch(getRegions());
		//dispatch(getJobs());

		//console.log(getRegions(Cookies.get("TOKEN");));
	}, []);
	const dispatch = useDispatch();
	const regions = useSelector((state) => state.regions);
	let jobs = useSelector((state) => state.jobs);

	console.log(jobs);
	if (jobs.length != 0) {
		if (jobs == null) {
			console.log('success');
		} else {
			console.log('no success');
		}
	}

	/**
   * menu of dropdown region
   */

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

	console.log('arrayRegion', itemRegions);

	const menuRegion = <Menu>{itemRegions}</Menu>;

	/**
	 * menu jobs
	 */

	const [ jobChange, setJobChange ] = useState('Choisissez votre métier');

	const [ visibleButtonJobs, setvisibleButtonJobs ] = useState(false);

	const [ idJob, setIdJob ] = useState('');

	const klsDisplayButton = classNames('home-button-region -cascader-jobs button-job', {
		'button-job--display': visibleButtonJobs == true
	});

	const visibleJobDropdown = () => {
		setvisibleButtonJobs(true);
	};

	let arrayJobs = jobs[0];
	//console.log('array', arrayJobs);
	let jobartisan = '';

	if (arrayJobs != undefined) {
		jobartisan = arrayJobs.map((job) => {
			const handleJobChange = (event) => {
				console.log('id job', event.item.props.eventKey);
				chooseJob(event.item.props.value);
				setIdJob(event.item.props.eventKey);
			};

			const chooseJob = (job) => {
				setJobChange(job);
			};

			return (
				<Menu.Item onClick={handleJobChange} key={job.id} value={job.name}>
					{job.name}
				</Menu.Item>
			);
		});
		//console.log('final ', jobartisan);
	}

	const menuJobs = <Menu>{jobartisan}</Menu>;

	/**
   * Button search artisan list
	 */
	const ButtonSearchArtisanList = withRouter(({ history }) => {
		const handleSearch = () => {
			dispatch(postHomeSearch(regionChange, idJob));
			//console.log('recherche : ', regionChange, jobChange);
			setTimeout(() => {
				history.push('/liste-artisan');
			}, 1000);
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

				{/* ############################################################# */}

				<Dropdown overlay={menuJobs} placement="bottomLeft">
					<Button className={klsDisplayButton} style={{ backgroundColor: '#bb9574', color: 'white' }}>
						{jobChange} <Icon type="down" />
					</Button>
				</Dropdown>
			</Row>

			<Row type="flex" justify="space-around" align="middle" className="home-france">
				<object data={france} id="yoursvg" width="100%" height="100%" type="image/svg+xml">
					<img src={france} alt="Une carte de france en svg cliquable" />
				</object>
				<ButtonSearchArtisanList />
			</Row>
		</div>
	);
};

export default Home;

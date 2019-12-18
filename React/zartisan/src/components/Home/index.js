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
<<<<<<< HEAD
		jobs.length = 0;
		dispatch(getJobs(event.item.props.value));
		console.log('region', event.item.props.value);
		visibleJobDropdown();
		setJobChange('Choisissez votre métier');
	};

	useEffect(() => {
		if (jobs.length == 0) {
=======

		setTimeout(() => {
			jobs = [];
		}, 2000);
		dispatch(getJobs(event.item.props.value));
		console.log('region', event.item.props.value);
		visibleJobDropdown();
	};

	useEffect(() => {
		if (jobs.length != 0) {
			setJobChange('Choisissez votre métier');
		} else {
<<<<<<< HEAD
>>>>>>> WIP: new button jobs
=======
>>>>>>> 2fd7e85348ff82f72a4fbdcf9cd4d266ea6eec63
>>>>>>> 334d818537bf3ef3448beca96e8dc49abeedc308
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
<<<<<<< HEAD
	console.log(jobs);
	if (jobs.length != 0) {
		if (jobs[0].success != undefined) {
			console.log('success');
		} else {
			console.log('no success');
		}
	}
=======
	//console.log('select', regions);
	console.log('select', jobs);
<<<<<<< HEAD
>>>>>>> WIP: new button jobs
=======
>>>>>>> 2fd7e85348ff82f72a4fbdcf9cd4d266ea6eec63
>>>>>>> 334d818537bf3ef3448beca96e8dc49abeedc308

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

	// 	const [ jobChange, setJob ] = useState([]);

	// 	/**
	//    * list item menu
	//    */
	//   let arrayJobb = [];
	// 	for (let j in jobs) {
	//     //console.log('forin', jobs[j]);
	// 		arrayJobb = jobs[j];
	//   }

	// 	//console.log(arrayJobb);

	// 	const itemJobs = arrayJobb.map((job) => {
	//     //console.log('first-map', job);
	// 		let nameValue = '';
	// 		let idValue = '';
	// 		let arrayMyJobs = [];
	// 		for (let j in job.jobs) {
	//       nameValue = job.jobs[j].name;
	// 			idValue = job.jobs[j].id;
	// 			arrayMyJobs.push({ value: idValue, label: nameValue });
	// 		}
	// 		//console.log(arrayMyJobs);
	// 		//console.log('forindansmap', nameValue, idValue);

	// 		const newObjectJob = {
	//       value: job.id,
	// 			label: job.name,
	// 			children: arrayMyJobs
	// 		};
	// 		//console.log('nouveau objet : ', newObjectJob);
	// 		return newObjectJob;
	// 	});

	// 	//console.log(itemJobs);

	// 	const onChangeJob = (event) => {
	//     setJob(event);
	// 	};

	/**
	 * menu jobs
	 */

<<<<<<< HEAD
	const [ jobChange, setJobChange ] = useState('Choisissez votre métier');
=======
	const [ jobChange, setJobChange ] = useState('Choisissez un métier');
<<<<<<< HEAD
>>>>>>> WIP: new button jobs
=======
>>>>>>> 2fd7e85348ff82f72a4fbdcf9cd4d266ea6eec63
>>>>>>> 334d818537bf3ef3448beca96e8dc49abeedc308
	const [ visibleButtonJobs, setvisibleButtonJobs ] = useState(false);

	const klsDisplayButton = classNames('home-button-region -cascader-jobs button-job', {
		'button-job--display': visibleButtonJobs == true
	});

	const visibleJobDropdown = () => {
		setvisibleButtonJobs(true);
	};

	let arrayJobs = jobs[0];
	//console.log('array', arrayJobs);
	let jobartisan = '';
<<<<<<< HEAD
	if (jobs.length != 0 && jobs[0].success != 'no job' && arrayJobs != undefined) {
		jobartisan = arrayJobs.map((job) => {
			console.log('metier', job);
=======
	if (arrayJobs != undefined) {
		jobartisan = arrayJobs.map((job) => {
			//console.log('metier', job);
<<<<<<< HEAD
>>>>>>> WIP: new button jobs
=======
>>>>>>> 2fd7e85348ff82f72a4fbdcf9cd4d266ea6eec63
>>>>>>> 334d818537bf3ef3448beca96e8dc49abeedc308

			const handleJobChange = (event) => {
				console.log('helloooooo');
				chooseJob(event.item.props.value);
			};
<<<<<<< HEAD
			console.log('job value search', jobChange);
=======

<<<<<<< HEAD
>>>>>>> WIP: new button jobs
=======
>>>>>>> 2fd7e85348ff82f72a4fbdcf9cd4d266ea6eec63
>>>>>>> 334d818537bf3ef3448beca96e8dc49abeedc308
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
			dispatch(postHomeSearch(regionChange, jobChange[1]));
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

				{/* <Cascader
            className="home-cascader-jobs"
            options={itemJobs}
            placeholder="Choisissez un métier"
            onChange={onChangeJob}
            />*/}
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

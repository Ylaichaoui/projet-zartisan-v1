import React, { useState, useEffect } from 'react';
import { Row, Col, List, Avatar, Icon, Dropdown, Menu, Button, Cascader, Rate } from 'antd';
import classNames from 'classnames';

import 'antd/dist/antd.css';
import './style.sass';
import { useSelector, useDispatch } from 'react-redux';
import { getRegions } from 'src/store/regions/actions';
import { getJobs } from 'src/store/jobs/actions';
import { postHomeSearch } from 'src/store/search/actions';
import { withRouter, Link } from 'react-router-dom';
import { artisanData } from 'src/store/artisan/actions';

const ListArtisan = () => {
	const dispatch = useDispatch();
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
		if (arrayArtisan[d].companyDescription == null) {
			arrayArtisan[d].companyDescription = '';
		}
		objectArtisan = arrayArtisan[d];
		listData.push(objectArtisan);
	}
	//console.log('select', regions);
	//console.log('select', jobs);
	/**
	* menu of dropdown region
	*/
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

	const regions = useSelector((state) => state.regions);
	let jobs = useSelector((state) => state.jobs);

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

	const menuRegion = <Menu>{itemRegions}</Menu>;
	const [ regionChange, setRegion ] = useState('Choisissez une Région');

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

	const ButtonSearchArtisanList = () => {
		const handleSearch = () => {
			dispatch(postHomeSearch(regionChange, idJob));
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

				<Dropdown overlay={menuJobs} placement="bottomLeft">
					<Button className={klsDisplayButton} style={{ backgroundColor: '#bb9574', color: 'white' }}>
						{jobChange} <Icon type="down" />
					</Button>
				</Dropdown>
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
							description={item.companyDescription}
						/>
						<Rate style={{ fontSize: '1em' }} disabled defaultValue={item.averageRate} />
					</List.Item>
				)}
			/>
		</div>
	); //"src/styles/pictures/company/company1.png"
};
export default ListArtisan;

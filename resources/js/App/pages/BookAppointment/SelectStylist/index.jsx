import React from 'react';
import axios from 'axios';

import StylistItem from './StylistItem';

import './SelectStylist.scss';

class SelectStylist extends React.Component {

	constructor(props) {
		super(props);
		this.state = {
			listOfStylists: []
		}
	}

	async componentDidMount() {
		const response = await axios.get('/api/stylist');
		const listOfStylists = response.data;

		this.setState({ listOfStylists: listOfStylists });
	}

	render() { 
		const { setFormField, stylist } = this.props;
		
		return (
			<div className="select-stylist-container">
				<div className="select-stylist-title">Select your stylist</div>
				{this.state.listOfStylists.map(_stylist => (
					<StylistItem
						key={_stylist.id}
						id={_stylist.id} 
						user_id={_stylist.user_id}
						profile_photo_url={_stylist.profile_photo_url}
						job_title={_stylist.job_title}
						introduction={_stylist.introduction}
						service={_stylist.service}
						user={_stylist.user}
						setFormField={setFormField}
						isActive={_stylist.id === (stylist && stylist.id)}
					/>
				))}
			</div>
		);
	}

}

export default SelectStylist;


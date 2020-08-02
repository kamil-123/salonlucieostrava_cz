import React from 'react';
import axios from 'axios';

import TreatmentItem from './TreatmentItem';

import './ChooseTreatment.scss';

class ChooseTreatment extends React.Component {
	
	constructor(props) {
		super(props);
		this.state = {
			listOfTreatments: []
		}
	}

	async componentDidMount() {
		const response = await axios.get(`/api/treatment?stylist_id=${this.props.stylist.id}`);
		const listOfTreatments = response.data;

		this.setState({ listOfTreatments:listOfTreatments });
	}

	render() {
		const { setFormField, treatment } = this.props;
		return (
			<div className="choose-treatment-container">
				<div className="choose-treatment-title">Choose treatment</div>
				<div className="treatments">
					{this.state.listOfTreatments.map(_treatment => (
						<TreatmentItem
							key={_treatment.id}
							id={_treatment.id}
							stylist_id={_treatment.stylist_id}
							name={_treatment.name}
							price={_treatment.price}
							duration={_treatment.duration}
							setFormField={setFormField}
							isActive={_treatment.id === (treatment && treatment.id)}
						/>
					))}
					{this.state.listOfTreatments.length % 2 !== 0 && <div className="empty-treatment-item" />}
				</div>
			</div>
		);
	}

}

export default ChooseTreatment;


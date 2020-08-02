import React from 'react';
import moment from 'moment';
import './TreatmentItem.scss'
class TreatmentItem extends React.Component {

	setTreatment = () => {
		const { id, duration, name, price, setFormField } = this.props;
		this.props.setFormField('treatment', { id, duration, name, price });
		
	}

	render() {
		const {
			id,
			stylist_id,
			name,
			price,
			duration,
			isActive
		} = this.props;
		return (
			<div className={`treatment-item ${isActive ? 'active' : ''}`} onClick={this.setTreatment}>
				<div className="treatment-name">{name}</div>
				<div className="treatment-price">{price} CZK</div>
				<div className="treatment-duration">{moment(duration, 'HH:mm:ss').format('H [hrs] m [min]')}</div>
			</div>
		)
	}
}

export default TreatmentItem;
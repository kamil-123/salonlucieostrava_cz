import React from 'react';
import axios from 'axios';


import './CustomerInfo.scss';

class CustomerInfo extends React.Component {

	setFirstName = (event) => this.props.setFormField('firstName', event.target.value);
	
	setLastName = (event) => this.props.setFormField('lastName', event.target.value);

	setPhoneNumber = (event) => this.props.setFormField('phoneNumber', event.target.value);

	setEmail = (event) => this.props.setFormField('email', event.target.value);

	render() { 
		const { setFormField } = this.props;

		return (
			<form>
				<div className="customer-info-title">One last step...</div>
				<div className="customer-info-container">
					<div className="customer-info">Your First Name</div>
					<input type="text" onChange={this.setFirstName} required />
					<div className="customer-info">Your Last Name</div>
					<input type="text" onChange={this.setLastName} required />
					<div className="customer-info">Your Phone Number</div>
					<input type="text" onChange={this.setPhoneNumber} required />
					<div className="customer-info">Your Email</div>
					<input type="email" pattern="*@*" onChange={this.setEmail} required />
				</div>
			</form>
		);
	}

}

export default CustomerInfo;


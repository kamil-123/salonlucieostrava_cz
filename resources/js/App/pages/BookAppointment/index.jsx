import React from 'react';
import axios from 'axios';

import Calendar from './Calendar';
import ChooseTreatment from './ChooseTreatment';
import Finish from './Finish';
import SelectStylist from './SelectStylist';
import CustomerInfo from './CustomerInfo';

import './BookAppointment.scss';

class BookAppointment extends React.Component {

	constructor(props) {
		super(props);
		this.state = {
			currentStep: 0,
			form: {
				stylist: null,
				customer: null,
				treatment: null,
				startAt: null,
				email: null,
				phoneNumber: null,
				firstName: null,
				lastName: null,
			}
		}
	}

	renderStep = () => {
		const { form, form: { treatment, stylist, startAt } } = this.state;
		switch (this.state.currentStep) {
			case 0: return <SelectStylist stylist={stylist} setFormField={this.setFormField} />;
			case 1: return <ChooseTreatment treatment={treatment} stylist={stylist} setFormField={this.setFormField} />;
			case 2: return <Calendar stylist={stylist} treatment={treatment} startAt={startAt} setFormField={this.setFormField} />;
			case 3: return <CustomerInfo setFormField={this.setFormField} />;
			case 4: return <Finish form={form} makeAppointment={this.makeAppointment} />;
		}
	}

	makeAppointment = async () => {
		const { history } = this.props;
		const { 
			stylist: { id: stylist_id },
			treatment: { id: treatment_id },
			startAt: start_at,
			email,
			phoneNumber: phone_number,
			firstName: first_name,
			lastName: last_name,
		} = this.state.form

		await axios.post('/api/booking', {
			stylist_id,
			treatment_id,
			start_at,
			email,
			phone_number,
			first_name,
			last_name,
		});

		history.push('/react/home');
	}

	setFormField = (key, value) => {
		const form = this.state.form;
		this.setState({
			form: {
				...form,
				[key]: value
			}
		});
	}

	nextStep = () => {
		this.setState({ currentStep: this.state.currentStep + 1 });
	}

	previousStep = () => {
		this.setState({ currentStep: this.state.currentStep - 1 });
	}
 
	render() {
		const { form: { stylist, treatment, email, phoneNumber, firstName, lastName, startAt }, currentStep } = this.state;
		const isNextButtonDisabled =
			(currentStep === 0 && !stylist) ||
			(currentStep === 1 && !treatment) ||
			(currentStep === 2 && !startAt) ||
			(currentStep === 3 && (!email || !phoneNumber || !firstName || !lastName));

		return (
			<div>

				<div className="book-appointment-title">Book Appointments</div>
				{this.renderStep()}
				<div className="bottom-container">
					{this.state.currentStep === 0 && <h3> 1 of 4 </h3>}
					{this.state.currentStep === 1 && <h3> 2 of 4 </h3>}
					{this.state.currentStep === 2 && <h3> 3 of 4 </h3>}
					{this.state.currentStep === 3 && <h3> 4 of 4 </h3>}
					<div className="buttons-container">
						{this.state.currentStep !== 0 && <button className="button button-secondary" onClick={this.previousStep}>Previous</button>}
						{this.state.currentStep !== 4 && <button disabled={isNextButtonDisabled} className="button button-primary" onClick={this.nextStep}>Next</button>}
					</div>
				</div>
			</div>
		);
	}

}

export default BookAppointment;


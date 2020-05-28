import React from 'react';
import moment from 'moment';
import './Finish.scss'
export default class Finish extends React.Component {

    render() {
        const { form, makeAppointment } = this.props;
        const { 
            startAt,
            firstName,
            email,
            phoneNumber,
            stylist: { user },
            treatment: { name }
        } = form;

        const stylistName = `${user.first_name} ${user.last_name}`;

        return (
            <div className='finish-container'>
                <div className='finish1'>Dear {firstName}, here are your booking details: </div>
                <div className='details-container'>
                    <div className='details1'>Treatment: <span className="details">{name}</span></div>
                    <div className='details1'>Stylist: <span className="details">{stylistName}</span></div>
                    <div className='details1'>Your email: <span className="details">{email}</span></div>
                    <div className='details1'>Your phone number: <span className="details">{phoneNumber}</span></div>
                    <div className="greeting">See you on {moment(startAt).format('dddd DD-MM')} at {moment(startAt).format('HH:mm')}</div>
                </div>
                <button className="button-appointment" onClick={makeAppointment}>Make Appointment</button>
            </div>
        )
    }

}
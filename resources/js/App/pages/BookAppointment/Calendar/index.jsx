import React from 'react';
import moment from 'moment';
import axios from 'axios';

import './Calendar.scss'

const DEFAULT_TIMESLOT = {  // original timeslots
    '09:00:00': 0,
    '09:30:00': 0,
    '10:00:00': 0,
    '10:30:00': 0,
    '11:00:00': 0,
    '11:30:00': 0,
    '12:00:00': 0,
    '12:30:00': 0,
    '13:00:00': 0,
    '13:30:00': 0,
    '14:00:00': 0,
    '14:30:00': 0,
    '15:00:00': 0,
    '15:30:00': 0,
    '16:00:00': 0,
    '16:30:00': 0,
};

export default class Calendar extends React.Component {

    state = {
        dateRange: [],
        timeslotAvailability: {}
    }

    async componentDidMount() {
        const response = await axios.get(`/api/booking?stylist_id=${this.props.stylist.id}`);
        const timeslotAvailability = response.data;

        const dateRange = [moment()];
        for (let index = 1; index <= 14; index++) {
            dateRange.push(moment().add(index, 'days'))
        }
        this.setState({ dateRange, timeslotAvailability });
        console.log(dateRange, timeslotAvailability);
        console.log(this.props.treatment);
    }

    setDate = async (date) => {
        const { setFormField } = this.props;
        const startAt = moment(date).toDate();
        setFormField('startAt', startAt);
    }

    setTimeslot = (time) => {
        const { setFormField, startAt } = this.props;
        const date = moment(startAt).format('DD-MM-YYYY');
        const newStartAt = moment(`${date} ${time}`, 'DD-MM-YYYY HH:mm').toDate();
        setFormField('startAt', newStartAt);
        
    }

    render() {
        const { dateRange, timeslotAvailability } = this.state;
        const { startAt, treatment } = this.props
        
        if (!dateRange.length) {
            return null;
        }

        const selectedDate = moment(startAt).format('DD');
        const selectedTimeslot = moment(startAt).format('H:mm');
        const timeslot = timeslotAvailability[moment(startAt).format('YYYY-MM-DD')] || DEFAULT_TIMESLOT;

        return (
            <div className="calendar">
                <div className="calendar-title">Select your date</div>
                <table className="calendar-datepicker">
                    <thead>
                        <tr>
                            <th>{dateRange[0].format('dd')}</th>
                            <th>{dateRange[1].format('dd')}</th>
                            <th>{dateRange[2].format('dd')}</th>
                            <th>{dateRange[3].format('dd')}</th>
                            <th>{dateRange[4].format('dd')}</th>
                            <th>{dateRange[5].format('dd')}</th>
                            <th>{dateRange[6].format('dd')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td onClick={this.setDate.bind(this, dateRange[0].toDate())}><span className={selectedDate === dateRange[0].format('DD') ? 'active' : ''}>{dateRange[0].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[1].toDate())}><span className={selectedDate === dateRange[1].format('DD') ? 'active' : ''}>{dateRange[1].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[2].toDate())}><span className={selectedDate === dateRange[2].format('DD') ? 'active' : ''}>{dateRange[2].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[3].toDate())}><span className={selectedDate === dateRange[3].format('DD') ? 'active' : ''}>{dateRange[3].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[4].toDate())}><span className={selectedDate === dateRange[4].format('DD') ? 'active' : ''}>{dateRange[4].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[5].toDate())}><span className={selectedDate === dateRange[5].format('DD') ? 'active' : ''}>{dateRange[5].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[6].toDate())}><span className={selectedDate === dateRange[6].format('DD') ? 'active' : ''}>{dateRange[6].format('DD')}</span></td>
                        </tr>
                        <tr>
                            <td onClick={this.setDate.bind(this, dateRange[7].toDate())}><span className={selectedDate === dateRange[7].format('DD') ? 'active' : ''}>{dateRange[7].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[8].toDate())}><span className={selectedDate === dateRange[8].format('DD') ? 'active' : ''}>{dateRange[8].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[9].toDate())}><span className={selectedDate === dateRange[9].format('DD') ? 'active' : ''}>{dateRange[9].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[10].toDate())}><span className={selectedDate === dateRange[10].format('DD') ? 'active' : ''}>{dateRange[10].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[11].toDate())}><span className={selectedDate === dateRange[11].format('DD') ? 'active' : ''}>{dateRange[11].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[12].toDate())}><span className={selectedDate === dateRange[12].format('DD') ? 'active' : ''}>{dateRange[12].format('DD')}</span></td>
                            <td onClick={this.setDate.bind(this, dateRange[13].toDate())}><span className={selectedDate === dateRange[13].format('DD') ? 'active' : ''}>{dateRange[13].format('DD')}</span></td>
                        </tr>
                    </tbody>
                </table>

                <div className="calendar-title">Select your timeslot</div>
                <table className="calendar-timepicker">
                    <tbody>
                        <tr>
                            <td onClick={timeslot['09:00:00'] === null ? this.setTimeslot.bind(this, '09:00') : undefined}><span className={`${selectedTimeslot === '09:00' ? 'active' : ''} ${timeslot['09:00:00'] === null ? 'available' : 'unavailable'}`}>9:00</span></td>
                            <td onClick={timeslot['11:00:00'] === null ? this.setTimeslot.bind(this, '11:00') : undefined}><span className={`${selectedTimeslot === '11:00' ? 'active' : ''} ${timeslot['11:00:00'] === null ? 'available' : 'unavailable'}`}>11:00</span></td>
                            <td onClick={timeslot['13:00:00'] === null ? this.setTimeslot.bind(this, '13:00') : undefined}><span className={`${selectedTimeslot === '13:00' ? 'active' : ''} ${timeslot['13:00:00'] === null ? 'available' : 'unavailable'}`}>13:00</span></td>
                            <td onClick={timeslot['15:00:00'] === null ? this.setTimeslot.bind(this, '15:00') : undefined}><span className={`${selectedTimeslot === '15:00' ? 'active' : ''} ${timeslot['15:00:00'] === null ? 'available' : 'unavailable'}`}>15:00</span></td>
                        </tr>
                        <tr>
                            <td onClick={timeslot['09:30:00'] === null ? this.setTimeslot.bind(this, '09:30') : undefined}><span className={`${selectedTimeslot === '09:30' ? 'active' : ''} ${timeslot['09:30:00'] === null ? 'available' : 'unavailable'}`}>9:30</span></td>
                            <td onClick={timeslot['11:30:00'] === null ? this.setTimeslot.bind(this, '11:30') : undefined}><span className={`${selectedTimeslot === '11:30' ? 'active' : ''} ${timeslot['11:30:00'] === null ? 'available' : 'unavailable'}`}>11:30</span></td>
                            <td onClick={timeslot['13:30:00'] === null ? this.setTimeslot.bind(this, '13:30') : undefined}><span className={`${selectedTimeslot === '13:30' ? 'active' : ''} ${timeslot['13:30:00'] === null ? 'available' : 'unavailable'}`}>13:30</span></td>
                            <td onClick={timeslot['15:30:00'] === null ? this.setTimeslot.bind(this, '15:30') : undefined}><span className={`${selectedTimeslot === '15:30' ? 'active' : ''} ${timeslot['15:30:00'] === null ? 'available' : 'unavailable'}`}>15:30</span></td>
                        </tr>
                        <tr>
                            <td onClick={timeslot['10:00:00'] === null ? this.setTimeslot.bind(this, '10:00') : undefined}><span className={`${selectedTimeslot === '10:00' ? 'active' : ''} ${timeslot['10:00:00'] === null ? 'available' : 'unavailable'}`}>10:00</span></td>
                            <td onClick={timeslot['12:00:00'] === null ? this.setTimeslot.bind(this, '12:00') : undefined}><span className={`${selectedTimeslot === '12:00' ? 'active' : ''} ${timeslot['12:00:00'] === null ? 'available' : 'unavailable'}`}>12:00</span></td>
                            <td onClick={timeslot['14:00:00'] === null ? this.setTimeslot.bind(this, '14:00') : undefined}><span className={`${selectedTimeslot === '14:00' ? 'active' : ''} ${timeslot['14:00:00'] === null ? 'available' : 'unavailable'}`}>14:00</span></td>
                            <td onClick={timeslot['16:00:00'] === null ? this.setTimeslot.bind(this, '16:00') : undefined}><span className={`${selectedTimeslot === '16:00' ? 'active' : ''} ${timeslot['16:00:00'] === null ? 'available' : 'unavailable'}`}>16:00</span></td>
                        </tr>
                        <tr>
                            <td onClick={timeslot['10:30:00'] === null ? this.setTimeslot.bind(this, '10:30') : undefined}><span className={`${selectedTimeslot === '10:30' ? 'active' : ''} ${timeslot['10:30:00'] === null ? 'available' : 'unavailable'}`}>10:30</span></td>
                            <td onClick={timeslot['12:30:00'] === null ? this.setTimeslot.bind(this, '12:30') : undefined}><span className={`${selectedTimeslot === '12:30' ? 'active' : ''} ${timeslot['12:30:00'] === null ? 'available' : 'unavailable'}`}>12:30</span></td>
                            <td onClick={timeslot['14:30:00'] === null ? this.setTimeslot.bind(this, '14:30') : undefined}><span className={`${selectedTimeslot === '14:30' ? 'active' : ''} ${timeslot['14:30:00'] === null ? 'available' : 'unavailable'}`}>14:30</span></td>
                            <td onClick={timeslot['16:30:00'] === null ? this.setTimeslot.bind(this, '16:30') : undefined}><span className={`${selectedTimeslot === '16:30' ? 'active' : ''} ${timeslot['16:30:00'] === null ? 'available' : 'unavailable'}`}>16:30</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        )

    }

}
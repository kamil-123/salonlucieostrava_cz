import React from 'react';
import { Link } from 'react-router-dom';


import './Home.scss';

export default class Home extends React.Component {

  aboutSectionRef = React.createRef();

  scrollToAboutSection = () => {
    this.aboutSectionRef.current.scrollIntoView({ behavior: 'smooth' });
  }

  render() {

    return (
      <div>
        <div className='mainPage'>
          <div className='mainPage__box'>
            <h1 className='mainTitle1'>Salon</h1>
            <h1 className='mainTitle2'>Lucie</h1>
            <h3 className='mainSubtitle'>Best Hair Style in Ostrava</h3>
            <div className="mainActions">
              <Link className='buttonBook1' to="/react/book-appointment">
                BOOK NOW
              </Link>
              <div onClick={this.scrollToAboutSection} className='buttonAbout'>ABOUT US</div>
            </div>
          </div>
        </div>
        <div className='aboutSection' ref={this.aboutSectionRef} >
          <h1>About us</h1>
          <h4>
            Salón Lucie has been in the center of Ostrava since 2003.
            Our top hair stylists create the latest lines of cuts and color fashion trends for you.
            We use the latest technologies and products of GOLDWELL.
            Lucie salon will fulfill all your dreams of beautiful hair and new image.
            We cordially invite you!
          </h4>
          <Link className='buttonBook2' to="/react/book-appointment">
            BOOK NOW
          </Link>
        </div>
      </div>

    )
  }
}
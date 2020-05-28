
import React from 'react';
import { Link } from 'react-router-dom';
import './Footer.scss';

class Footer extends React.Component {


  render () {
    return (
      <footer className="footer">
        <div className="footer-content">
          <Link className="link" to="/react/menu">
            Menu
          </Link>
          <Link className="link" to="/react/stylists">
            Stylists
          </Link>
          <Link className="link" to="/react/gallery">
            Gallery
          </Link>
          <Link className="link" to="/react/contactLocation">
            Contact
          </Link>
        </div>
        <h5>© 2020</h5>
      </footer>
    )
  }
}

export default Footer;
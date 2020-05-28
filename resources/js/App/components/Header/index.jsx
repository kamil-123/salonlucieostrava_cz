import React from 'react';
import { Link } from 'react-router-dom';
import './Header.scss';

class Header extends React.Component {
  
  state = {
    visible: false
  }

  toggleHamburger = () => this.setState({ visible: !this.state.visible });

  redirectTo = (url) => {
    const { history } = this.props;
    history.push(url);
    this.toggleHamburger();
  }

  render () {
    const { visible } = this.state; 

    return (
      <header className="header">
        <div className="header-content">
          <Link to="/react/home">
            <div className="logo">Logo</div>
          </Link>
         
          <div onClick={this.toggleHamburger} className="hamburger">
            <span className="hamb1"></span>
            <span className="hamb2"></span>
            <span className="hamb3"></span>
          </div>

          <div className={`sidebar ${visible ? 'active': ''}`}>
            <div onClick={visible ? this.toggleHamburger : undefined} className="sidebar-overlay" />
            <div className="sidebar-content">
              <div className="sidebar-content-flex">
                <a onClick={this.redirectTo.bind(this, '/react/home')}>Home</a>
                <a onClick={this.redirectTo.bind(this, '/react/menu')}>Menu</a>
                <a onClick={this.redirectTo.bind(this, '/react/stylists')}>Stylists</a>
                <a onClick={this.redirectTo.bind(this, '/react/gallery')}>Gallery</a>
                <a onClick={this.redirectTo.bind(this, '/react/contact-location')}>Contact and Location</a>
                <a onClick={this.redirectTo.bind(this, '/react/book-appointment')}>BOOK NOW</a>
              </div>

            </div>
          </div>

        </div>
      </header>
    )
  }
}

export default Header;

class Hamburger {

    constructor(){
        this.body = document.querySelector('body');
        this.hamburger = document.getElementById('hamburger');
        this.navigation = document.querySelector('#navigation.mobile');
        this.hamburger.addEventListener('click', () => this.hamburgerAction(), false);
    }

    hamburgerAction(){
        this.body.classList.toggle('no-scroll');
        this.body.classList.toggle('navigation-active');
        this.hamburger.classList.toggle('active');
        this.navigation.classList.toggle('active');
    }
}

export default Hamburger;

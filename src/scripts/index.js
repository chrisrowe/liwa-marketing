import Hamburger from './components/hamburger';
import TeamMember from './components/teamMember';

import '../styles/index.scss';

((aOs) => {

    document.addEventListener('DOMContentLoaded', () => {

        new Hamburger();
        new TeamMember();

        aOs.init({
            delay: 50,
            duration: 600
        });

    });

})(window.AOS);


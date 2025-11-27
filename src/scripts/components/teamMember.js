
class TeamMembers {

    constructor(){
        this.body = document.querySelector('body');
        this.modals = document.querySelectorAll('.team-member');
        this.closeButtons = document.querySelectorAll('.modal button.close-modal');
        this.setUpModals();
        this.setUpCloseButtons();
    }

    setUpModals(){
        this.modals.forEach(
            element => element.addEventListener('click', () => this.toggleModal(element), false)
        );
    }

    setUpCloseButtons(){
        this.closeButtons.forEach(
            element => element.addEventListener('click', () => this.closeModal(element), false)
        );
    }

    toggleModal(element){
        let modalId = element.dataset.modal;
        let teamMemberModal = document.getElementById(modalId);
        teamMemberModal.classList.add('active');
        this.body.classList.add('no-scroll');
    }

    closeModal(element){
        let modal = document.getElementById(element.dataset.modal);
        modal.classList.remove('active');
        this.body.classList.remove('no-scroll');
    }

}

export default TeamMembers;

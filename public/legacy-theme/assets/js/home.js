document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('#header');
    const mobileMenu = document.querySelector('#mobile-mnu');
    const openMenu = document.querySelector('.open_menu');
    const closeMenu = document.querySelector('#close-mnu');
    const overlay = document.querySelector('.modal-overlay');
    const modalButtons = document.querySelectorAll('.open-modal');
    const closeButtons = document.querySelectorAll('.close-modal');

    const closeModal = () => {
        document.querySelectorAll('.theme-modal.is-open').forEach((modal) => {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        });

        if (overlay) {
            overlay.hidden = true;
        }
    };

    const openModal = (name) => {
        const modal = document.querySelector(`#modal-${name}`);

        if (!modal) {
            return;
        }

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');

        if (overlay) {
            overlay.hidden = false;
        }
    };

    window.addEventListener('scroll', () => {
        if (!header) {
            return;
        }

        header.classList.toggle('painted', window.scrollY >= 30);
    });

    if (openMenu && mobileMenu) {
        openMenu.addEventListener('click', () => {
            mobileMenu.classList.add('is-open');
            mobileMenu.setAttribute('aria-hidden', 'false');
        });
    }

    if (closeMenu && mobileMenu) {
        closeMenu.addEventListener('click', () => {
            mobileMenu.classList.remove('is-open');
            mobileMenu.setAttribute('aria-hidden', 'true');
        });
    }

    document.querySelectorAll('#mobile-mnu a').forEach((link) => {
        link.addEventListener('click', () => {
            if (mobileMenu) {
                mobileMenu.classList.remove('is-open');
                mobileMenu.setAttribute('aria-hidden', 'true');
            }
        });
    });

    modalButtons.forEach((button) => {
        button.addEventListener('click', (event) => {
            const modalName = button.getAttribute('data-modal');

            if (!modalName) {
                return;
            }

            event.preventDefault();
            openModal(modalName);
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', closeModal);
    });

    if (overlay) {
        overlay.addEventListener('click', closeModal);
    }

    document.querySelectorAll('.public-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            const status = form.querySelector('.public-form__status');

            if (status) {
                status.hidden = false;
            }
        });
    });
});

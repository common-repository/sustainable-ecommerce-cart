export default () => {
    const prepareCl = 'rgbc-widget-popup_prepare';
    const activeCl = 'rgbc-widget-popup_active';
    const closeFunc = (popup) => {
        popup.classList.remove(activeCl);
        setTimeout(() => popup.classList.remove(prepareCl), 300);
    }

    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('js-rgbc-widget-link')) {
            const popup = document.querySelector('.rgbc-widget__popup');

            if (!popup) {
                return null;
            }

            e.preventDefault();

            popup.classList.add(prepareCl);
            setTimeout(() => popup.classList.add(activeCl), 0);
        }

        if (e.target.classList.contains('js-rgbc-widget-close')) {
            const popup = e.target.closest('.rgbc-widget__popup');

            if (!popup) {
                return null;
            }

            e.preventDefault();

            closeFunc(popup);
        }

        if (e.target.classList.contains('js-rgbc-widget-popup-wrapper')) {
            closeFunc(e.target);
        }
    });
}

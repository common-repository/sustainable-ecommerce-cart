export default (obj) => {
    if (!obj || !obj.shadowRoot) {
        return null;
    }

    const prepareCl = 'rgbc-widget-popup_prepare';
    const activeCl = 'rgbc-widget-popup_active';
    const closeFunc = (popup) => {
        popup.classList.remove(activeCl);
        setTimeout(() => popup.classList.remove(prepareCl), 300);
    }

    obj.shadowRoot.addEventListener('click', (e) => {
        const popup = document.querySelector('netzero-widget-popup');

        if (!popup) {
            return null;
        }

        if (e.target.classList.contains('js-rgbc-widget-close')) {
            e.preventDefault();

            closeFunc(popup);
        }

        if (e.target.classList.contains('js-rgbc-widget-popup-wrapper')) {
            closeFunc(popup);
        }
    });
}

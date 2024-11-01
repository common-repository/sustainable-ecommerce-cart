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
        if (e.target.classList.contains('js-rgbc-widget-link')) {
            const popup = document.querySelector('netzero-widget-popup');

            if (!popup) {
                return null;
            }

            e.preventDefault();

            popup.classList.add(prepareCl);
            setTimeout(() => popup.classList.add(activeCl), 0);
        }
    });
}

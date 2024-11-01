export default () => {
    //Term checkbox
    document.addEventListener('click', e => {
        const checkbox = e.target.closest('.rgbc-install-form__checkbox[name="terms"]');
        const alertBoxClassName = '.rgbc-install-button_terms-alert';

        if (checkbox && checkbox.checked === true) {
            const form = checkbox.closest('form');
            const errorBox = form.querySelector(alertBoxClassName);
            if (errorBox) {
                errorBox.classList.remove('rgbc-install-button_terms-alert');
            }
        }
    });
}

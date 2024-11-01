export default () => {
    const pluginUrl = window.rgbc_netzero_sm_back.plugin_url;
    const container = document.querySelector('.js-rgbc-design-image-container');
    const image = document.querySelector('.js-rgbc-design-image');

    if (!pluginUrl || !image || !container) {
        return null;
    }
    let currentOption = 'widget_place_a';
    let currentColor = '';

    const placeImage = () =>
        image.src = `${pluginUrl}src/assets/images/cart-preview/${currentOption}_${currentColor || 'white'}.png`;

    const setOptionClass = () => {
        const regx = new RegExp('\\brgbc-design__image-container_[^ ]*[ ]?\\b', 'g');
        container.className = container.className.replace(regx, '');
        if (currentOption === 'widget_place_a') {
            return container.classList.add('rgbc-design__image-container_option-a');
        }
        container.classList.add('rgbc-design__image-container_option-b');
    }

    const options = document.querySelectorAll('input[name="widget_place"]');
    const colors = document.querySelectorAll('input[name="widget_color"]');

    options.forEach((input) => {
        if (input.checked) {
            currentOption = input.value;
            setOptionClass();
        }
        input.addEventListener('change', (e) => {
            currentOption = e.target.value;
            placeImage();
            setOptionClass();
        });
    });
    colors.forEach((input) => {
        if (input.checked) {
            currentColor = input.value;
        }
        input.addEventListener('change', (e) => {
            currentColor = e.target.value;
            placeImage();
        });
    });

    placeImage();
}
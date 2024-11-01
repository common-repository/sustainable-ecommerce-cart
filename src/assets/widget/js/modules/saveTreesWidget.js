export default (obj) => {
    if (!obj || !obj.shadowRoot) {
        return null;
    }

    handleWidgetCheckboxClick();

    function handleWidgetCheckboxClick() {
        obj.shadowRoot.addEventListener('click', e => {
            const widgetCheckbox = e.target.closest('[data-netzero-sm-widget-checkbox]');
            const widgetWrapper = e.target.closest('.rgbc-widget-container');
            const isCheckout = e.target.closest('.rgbc-widget-container.rgbc-content-wrapper_checkout');

            if(!widgetCheckbox || !widgetWrapper) {
                return null;
            }

            const nonce = window?.rgbc_netzero_sm_widget?.nonce;
            const ajaxUrl = window?.rgbc_netzero_sm_widget?.ajax_url;

            if(!nonce || !ajaxUrl) {
                return null;
            }

            fetch(ajaxUrl, {
                method: 'POST',
                headers: new Headers({
                    'Content-Type': 'application/x-www-form-urlencoded',
                }),
                body: new URLSearchParams({
                    nonce,
                    action: 'netzero_sm_save_trees',
                    save_trees: widgetCheckbox.checked
                }).toString(),
            }).then((response) => response.json())
                .then((responseData) => {
                    if (responseData.success === true) {
                        document.body.dispatchEvent(new Event('added_to_cart', {
                            bubbles: true
                        }));
                        document.body.dispatchEvent(new Event('wc_fragment_refresh', {
                            bubbles: true
                        }));

                        if(isCheckout) {
                            document.body.dispatchEvent(new Event('update_checkout', {
                                bubbles: true
                            }));
                        }
                    } else {
                        widgetCheckbox.checked = !widgetCheckbox.checked;
                    }
                });
        })
    }
};

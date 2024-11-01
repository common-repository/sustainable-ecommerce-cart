export default () => {
    document.addEventListener('change', e => {
        const unitsSwitcher = e.target.closest('[data-rgbc-netzero-sm-units-switcher]');

        if (!unitsSwitcher) {
            return null;
        }

        const nonce = window.rgbc_netzero_sm_back.nonce;
        const ajaxUrl = window.rgbc_netzero_sm_back.ajax_url;

        if (!nonce || !ajaxUrl) {
            return null;
        }

        unitsSwitcher.disabled = true;

        fetch(ajaxUrl, {
            method: 'POST',
            headers: new Headers({
                'Content-Type': 'application/x-www-form-urlencoded',
            }),
            body: new URLSearchParams({
                nonce,
                action: 'netzero_sm_switch_units',
                units: unitsSwitcher.checked
            }).toString(),
        }).then((response) => response.json())
            .then((responseData) => {
                if (responseData && responseData.success === true) {
                    window.location.reload();
                } else {
                    unitsSwitcher.checked = !unitsSwitcher.checked;
                }
            }).finally(() => {
            unitsSwitcher.disabled = false;
        });

    });
}

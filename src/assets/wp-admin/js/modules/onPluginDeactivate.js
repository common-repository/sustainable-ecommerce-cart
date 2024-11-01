import {get} from 'underscore';
export default () => {
    let urlRedirect = document.querySelector('[data-slug="sustainable-ecommerce-cart"] a')
    urlRedirect = urlRedirect ? urlRedirect.getAttribute('href') : null;
    const jwt = get(window, ['rgbc_netzero_sm_wp_admin', 'jwt'], '');
    const modal = document.querySelector('#netzero-sm-deactivation-modal');
    const apiUrl = get(window, ['rgbc_netzero_sm_wp_admin', 'api_url'], null);

    if(!urlRedirect || !jwt || !modal || !apiUrl) {
        return null;
    }

    //Click on deactivate plugin btn
    document.addEventListener('click', function (e) {
        const plugin = e.target.closest('.deactivate') && e.target.closest('[data-slug="sustainable-ecommerce-cart"]');

        if (!plugin) {
            return null;
        }

        e.preventDefault();

        modal.style.display = 'flex';
    });

    //Click on stay plugin btn
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-netzero-sm-stay-active]');

         if(!btn) {
             return null;
         }

        e.preventDefault();
        modal.style.display = 'none';
    });

    //Click on submit deactivate
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-netzero-sm-submit-deactivate]');

        if (!btn) {
            return null;
        }

        let reasonsEls = document.querySelectorAll('[data-nezero-sm-deactivation-reason]');

        const reasons = [];

       if (!reasonsEls) {
           modal.style.display = 'none';
            return null;
        }

        e.preventDefault();

        for (let reasonEl of reasonsEls) {
            if (reasonEl.checked) {
                reasons.push(reasonEl.dataset.nezeroSmDeactivationReason)
            }
        }

        btn.disabled = true;

        if (!reasons.length) {
            reasons.push('Reason not specified');
        }

        fetch(apiUrl + '/deactivate_plugin_reason', {
            method: 'POST',
            headers: new Headers({
                'Content-Type': 'application/json',
            }),
            body: JSON.stringify( {
                jwt: jwt,
                reasons: reasons
            } ),
            signal: AbortSignal.timeout(10000)
    })
            .then((response) => response.json())
            .then((responseData) => {
                if (responseData.success === true) {
                    //TODO
                }
            })
            .finally(() => {
                btn.disabled = false;
                modal.style.display = 'none';
                window.location = urlRedirect;
            });
    });
}

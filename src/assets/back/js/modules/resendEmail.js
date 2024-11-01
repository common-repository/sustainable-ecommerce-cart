import {get} from "underscore";

export default () => {
    document.addEventListener('click', e => {
        const btn = e.target.closest('[data-rgbc-resend-email-btn]');
        const jwt = get(window, ['rgbc_netzero_sm_back', 'jwt'], '');
        const apiUrl = get(window, ['rgbc_netzero_sm_back', 'api_url'], null);
        const emailVerificationUrl = get(window, ['rgbc_netzero_sm_back', 'email_verification_url'], null);

        if (!btn || !apiUrl || !jwt || !emailVerificationUrl) {
            return null;
        }

        e.preventDefault();

        btn.disabled = true;
        let counter = 60;

        fetch(apiUrl + '/resend_email', {
            method: 'POST',
            headers: new Headers({
                'Content-Type': 'application/json',
            }),
            body: JSON.stringify( {
                jwt: jwt,
                email_verification_url: emailVerificationUrl
            } ),
        })
            .then((response) => response.json())
            .then((responseData) => {
                if (responseData.resend_email === true) {
                    const btnText = btn.innerText;
                    let interval = setInterval(() => {

                        if(counter <= 0) {
                            clearInterval(interval);
                            btn.innerText = btnText;
                            btn.disabled = false;
                            return;
                        }
                        btn.innerText = btnText + ` (${counter})`;
                        counter--;
                    }, 1000);
                } else {
                    btn.disabled = false;
                }
            })
            .catch(() => {
                btn.disabled = false;
            });
    });
}

import documentReady from '../../common/js/helpers/documentReady';
import saveTreesWidget from "./modules/saveTreesWidget";
import widgetFontSize from "./modules/widgetFontSize";
import popupControlWidget from "./modules/popupControlWidget";
import popupControlPopup from "./modules/popupControlPopup";

documentReady(() => {
    customElements.define('netzero-widget', class extends HTMLElement {
        connectedCallback() {
            this.attachShadow({mode: 'open'});


            const widgetId = this.dataset.widgetId;

            if (!widgetId) {
                return;
            }

            const template = document.getElementById(widgetId);

            if (!template) {
                return null;
            }

            const cssFileUrl = template.dataset.cssFileUrl;

            if (!cssFileUrl) {
                return;
            }

            const link = document.createElement('link');

            link.setAttribute('rel', 'stylesheet');
            link.setAttribute('href', cssFileUrl);

            this.shadowRoot.appendChild(link);
            this.shadowRoot.append(template.content.cloneNode(true));

            widgetFontSize(this);
            saveTreesWidget(this);
            popupControlWidget(this);
        }
    });

    customElements.define('netzero-widget-popup', class extends HTMLElement {
        connectedCallback() {
            this.attachShadow({mode: 'open'});

            const template = document.getElementById('netzero-widget-popup');

            if (!template) {
                return null;
            }

            const cssFileUrl = template.dataset.cssFileUrl;

            if (!cssFileUrl) {
                return null;
            }

            const link = document.createElement('link');

            link.setAttribute('rel', 'stylesheet');
            link.setAttribute('href', cssFileUrl);

            this.shadowRoot.appendChild(link);
            this.shadowRoot.append(template.content.cloneNode(true));

            popupControlPopup(this);
        }
    });
});

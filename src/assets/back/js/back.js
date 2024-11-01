import documentReady from '../../common/js/helpers/documentReady';
import unitsSwitcher from "./modules/unitsSwitcher";
import widgetSwitcher from "./modules/widgetSwitcher";
import designPreview from './modules/designPreview';
import resendEmail from "./modules/resendEmail";
import registerForm from "./modules/registerForm";

documentReady(() => {
    unitsSwitcher();
    widgetSwitcher();
    designPreview();
    resendEmail();
    registerForm()
});

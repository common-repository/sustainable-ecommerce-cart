import documentReady from '../../common/js/helpers/documentReady';
import onPluginDeactivate from "./modules/onPluginDeactivate";

documentReady(() => {
    onPluginDeactivate();
});

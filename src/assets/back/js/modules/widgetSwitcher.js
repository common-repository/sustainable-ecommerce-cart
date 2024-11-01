export default () => {
    document.addEventListener('change', e => {
        const widgetSwitcher = e.target.closest('[data-rgbc-netzero-sm-widget-switcher]');

        if(!widgetSwitcher || !widgetSwitcher.checked) {
            return null;
        }

        const locationSwitchers = document.querySelectorAll('[data-rgbc-netzero-sm-location-switcher]');

        for(const switcher of locationSwitchers) {
            if(switcher.checked) {
                return null;
            }
        }

        for(const switcher of locationSwitchers) {
            switcher.checked = true;
        }
    });
}

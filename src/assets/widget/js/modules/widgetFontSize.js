import {isContainerSup} from '../../../common/js/helpers/helper';

export default (obj) => {
    if (!obj || !obj.shadowRoot) {
        return null;
    }

    if (isContainerSup()) {
        return null;
    }

    const widgets = obj.shadowRoot.querySelectorAll('.rgbc-widget');
    const cl = 'rgbc-widget_small';
    const bpArr = [250, 300, 350, 400, 600];

    const calc = (el) => {
        const width = el.offsetWidth;

        const wClass = new RegExp('\\b' + cl + '[^ ]*[ ]?\\b', 'g');
        if (el.className.match(wClass)) {
            el.className = el.className.replace(wClass, '')
        }

        if (width <= bpArr[bpArr.length - 1]) {
            el.classList.add(cl);
        }
        bpArr.forEach((val, i, arr) => {
            if (i === 0) {
                if (width <= val) {
                    return el.classList.add(cl + '-' + val);
                }
            }
            if (width > val && width <= arr[i + 1]) {
                return el.classList.add(cl + '-' + arr[i + 1]);
            }
        });
    }

    // ResizeObserver
    widgets.forEach((el) => {
        const outputSize = () => calc(el);
        outputSize();
        new ResizeObserver(outputSize).observe(el);
    });
}

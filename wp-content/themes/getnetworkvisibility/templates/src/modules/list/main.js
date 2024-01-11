import * as ReactDOM from "react-dom";
import 'react-app-polyfill/ie11';
import 'react-app-polyfill/stable';

document.addEventListener('fp.openPopup', function ($event) {
    document.body.classList.add('open-popup');
});

document.addEventListener('fp.closePopup', function ($event) {
    document.body.classList.remove('open-popup');
});

/**
 *
 * @param {string} $id
 */
window.fpInitReactElement = function ($id) {
    const $reactElement = document.getElementById($id);

    if (!$reactElement || $reactElement.length < 1 || !window.hasOwnProperty($id) || !window[$id].hasOwnProperty('application')) {
        return false;
    }

    const $config = window[$id];

    import(`./src/Container/${$config.application}`).then((App) => {
        const $App = App.default;
        ReactDOM.render(<$App config={$config.config}/>, $reactElement);
    })
}
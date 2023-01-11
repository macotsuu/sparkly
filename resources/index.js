import './scripts/core/dom';
import './scripts/core/ajax';

import modules from "./scripts/core/modules.js";

window.addEventListener('DOMContentLoaded', () => {
    const {
        page
    } = modules.getCurrentPage()

    modules.render(page);
})

import modules from "./libraries/modules.js";

window.addEventListener('DOMContentLoaded', () => {
    const {
        page
    } = modules.getCurrentPage()

    modules.render(page);
})

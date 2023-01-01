window.addEventListener('DOMContentLoaded', () => {
    document.addEventListener("click", (e) => {
        if (e.target.matches("a.navigation")) {
            e.preventDefault();

            window.history.pushState({}, '', e.target.href);
            renderPage();
        }
    });

    renderPage();
})

const renderPage = () => {
    const params = new Proxy(
        new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        }
    );

    if (params.page > 0) {
        apiCall("\\Module\\ModuleDispatcher::loadModule", { moduleID: params.page }).done(module => {
            const {
                title,
                content,
                assets
            } = module;

            if (assets) {
                $.each(assets.styles, (i, style) => {
                    if (!$(`link[href="${style}"]`).length) {
                        $('head').append(`<link rel="stylesheet" href="${style}"/>`);
                    }
                });

                $.each(assets.scripts, (i, script) => {
                    if (!$(`script[src="${script}"]`).length) {
                        $('head').append(`<script defer src="${script}"></script>`);
                    }
                });
            }

            $("#pageContent").html(content).trigger('ready');
            $(document).title = `${title !== undefined ? title + ' | ' : ''}Blazing Fast Sales Tool`;
        });
    }
}
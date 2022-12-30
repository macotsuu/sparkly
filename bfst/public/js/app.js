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
        apiCall("\\Page\\PageDispatcher::loadPage", {
            pageID: params.page
        }, 'GET').done(response => {
            const obj = JSON.parse(response);

            $("#pageContent").html(obj.content);
            document.title = `${obj.title} | Blazing Fast Sales Tool`;

            $(document).trigger('ready');
        });
    }
}

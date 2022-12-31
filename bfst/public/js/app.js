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
        apiCall("\\Page\\PageDispatcher::loadPage", { pageID: params.page }).done(page => {
            document.title = `${page.title} | Blazing Fast Sales Tool`;

            $("#pageContent").html(page.content);
            $(document).trigger('ready');
        });
    }
}

const modules = {
    render: page => {
        if (!(page > 0)) {
            return;
        }

        ajax.call("\\Volcano\\Module\\ModuleDispatcher::loadModule", {moduleID: page}).then(async module => {
            const {
                title,
                content,
                assets
            } = module;

            if (assets) {
                await loadJSAssets(assets.scripts);
                await loadCSSAssets(assets.styles);
            }

            loadHTML(content)
                .then(() => document.title = `${title !== undefined ? title + ' | ' : ''}Blazing Fast Sales Tool`)
                .then(() => {
                    setTimeout(() => {
                        document.dispatchEvent(new Event('dispatchModule'));
                    }, 1000);
                });

        });
    },
    getCurrentPage: () => {
        return new Proxy(
            new URLSearchParams(window.location.search),
            {
                get: (searchParams, prop) => searchParams.get(prop),
            }
        )
    }
}

const loadCSSAssets = async styles => {
    let ss = document.styleSheets;

    styles.forEach(style => {
        let found = false;
        for (let i = 0, max = ss.length; i < max; i++) {
            if (ss[i].href === style) {
                found = true;
                return;
            }
        }

        if (found === false) {
            const link = document.createElement("link");

            link.rel = "stylesheet";
            link.href = style;

            document.getElementsByTagName("head")[0].appendChild(link);
        }
    });

}

const loadJSAssets = async scripts => {
    let ss = document.scripts;

    scripts.forEach(el => {
        let found = false;
        for (let i = 0, max = ss.length; i < max; i++) {
            if (ss[i].src === el) {
                found = true;
                return;
            }
        }

        if (found === false) {
            const script = document.createElement("script");
            script.src = el;

            document.getElementsByTagName("head")[0].appendChild(script);
        }
    });
}

const loadHTML = async content => {
    document.querySelector('#pageContent').innerHTML = content;
}

document.addEventListener("click", (e) => {
    if (e.target.matches("a.navigation")) {
        e.preventDefault();
        window.history.pushState({}, '', e.target.href);

        const {
            page
        } = modules.getCurrentPage();

        modules.render(page)
    }
});

export default modules;
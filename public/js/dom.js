if (window.$ === undefined) {
    window.$ = {};
}

class HashDOM extends Array {
    ready(callback) {
        const isReadySelector = this.some((el) => {
            return el.readyState !== null && el.readyState !== 'loading'
        })

        if (isReadySelector) {
            return callback()
        }

        this.on('DOMContentLoaded', callback)
    }

    fire(event, delay = 1) {
        setTimeout(() => {
            document.dispatchEvent(
                new Event(event)
            );
        }, delay);


        return this;
    }

    on(event, selector, callback) {
        if (typeof selector === 'function') {
            this.forEach((e) => {
                e.addEventListener(event, selector)
            })

            return this
        }

        this.forEach((el) => {
            el.addEventListener(event, (e) => {
                if (e.target.matches(selector)) {
                    if (callback !== null) {
                        callback(e)
                    }
                }
            })
        })

        return this
    }
}

HashDOM.prototype.html = function (html) {
    this.forEach((el) => {
        el.innerHTML = html
    })

    return this
}

HashDOM.prototype.append = function (html) {
    this.forEach((el) => {
        el.innerHTML = el.innerHTML + html
    })

    return this
}

HashDOM.prototype.prepend = function (html) {
    this.forEach((el) => {
        el.innerHTML = html + el.innerHTML
    })

    return this
}

HashDOM.prototype.addClass = function (className) {
    this.forEach((el) => {
        el.classList.add(className)
    })

    return this
}

HashDOM.prototype.removeClass = function (className) {
    this.forEach((el) => {
        el.classList.remove(className)
    })

    return this
}

HashDOM.prototype.css = function (styles) {
    this.forEach((el) => {
        for (const property in styles) {
            if (styles.hasOwnProperty(property)) {
                el.style[property] = styles[property];
            }
        }
    })

    return this
}

window.hash = (selector) => {
    if (typeof selector === 'string' || selector instanceof String) {
        return new HashDOM(...document.querySelectorAll(selector));
    }

    return new HashDOM(selector);
};
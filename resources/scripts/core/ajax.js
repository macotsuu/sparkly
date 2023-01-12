window.ajax = {
    call: (func, params) => {
        hash('#loader').css({display: 'block'});

        return fetch(`/BFSTalpha/ajax`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=UTF-8',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                'function': func,
                'arguments': params
            })
        }).then(response => {
            hash('#loader').css({display: 'none'});

            return response.json()
        }).catch(err => console.error(err))
    }
}
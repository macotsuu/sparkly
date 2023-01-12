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
        })
            .then(response => response.json())
            .then(async res => {
                hash('#loader').css({display: 'none'});

                if (res.error === true) {
                    return alert(res.message);
                }
                return res
            }).catch(err => console.error(err))
    }
}
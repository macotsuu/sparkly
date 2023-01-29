const request = {
    call: (func, params, method = 'GET') => {
        hash('#loader').css({display: 'block'});

        return fetch(func, {
            method: method,
            headers: {
                'Content-Type': 'application/json; charset=UTF-8',
                'Accept': 'application/json',
            }
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
};
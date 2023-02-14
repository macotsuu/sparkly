const request = {
    get: (func, params = {}) => {
        return fetch(`http://localhost:8080/${func}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json; charset=UTF-8',
                'Accept': 'application/json',
            }
        })
            .then(response => response.json())
            .then(async res => {
                if (res.error === true) {
                    return alert(res.message);
                }
                return res
            }).catch(err => console.error(err))
    }
};
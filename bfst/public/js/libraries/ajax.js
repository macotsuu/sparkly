const ajax = {
    call: (func, params, method = 'POST') => {
        return fetch(`/BFSTalpha/ajax`, {
            method: method,
            headers: {
                'Content-Type': 'application/json; charset=UTF-8',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                function: func,
                arguments: params
            })
        }).then(response => response.json());
    }
}

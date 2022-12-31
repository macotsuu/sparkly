const apiCall = (func, params, method = 'GET', async = true) => {
    return $.ajax({
        url: `ajax?func=\\BFST${func}`,
        accepts: 'json',
        dataType: 'json',
        data: params,
        method: method,
        async: async,
        beforeSend: () => {
            $('#bstAjaxLoader').show();
        },
        success: () => {
            $('#bstAjaxLoader').hide();
        }
    }).fail(jqXHR => {
        if (jqXHR.responseJSON) {
            if (jqXHR.responseJSON.trace !== undefined) {
                console.error(jqXHR.responseJSON.trace);
            }

            return alert(jqXHR.responseJSON.message);
        }

        return alert(jqXHR.responseText);
    }).then(response => {
        try {
            let o = JSON.parse(response);
            if (o && typeof o === "object") {
                return o;
            }
        }
        catch (e) { }

        return response;
    });
}



const apiCall = (func, params, method = 'GET', async = true) => {
    return $.ajax({
        url: `ajax?func=\\BFST${func}`,
        data: params,
        method: method,
        async: async,
        beforeSend: () => {
            $('#bstAjaxLoader').show();
        },
        success: () => {
            $('#bstAjaxLoader').hide();
        }
    }).fail(error => {
        console.log(error);
    })
}



let timerID = null;

const fetchOrders = filters => {
    return new Promise((resolve, reject) => {
        debounce(() => {
            request.call("/api/orders/search?" + (new URLSearchParams(filters).toString()), {})
                .then(response => resolve(response))
                .catch(error => reject(error))
        }, 200);
    })
}

const debounce = (callback, delay) => {
    clearTimeout(timerID)
    timerID = setTimeout(callback, delay)
}

hash(document).ready((e) => {
    const searchParams = new URLSearchParams(window.location.search);

    searchParams.forEach((value, param) => {
        const filter = document.querySelector(`#${param}`);

        if (filter !== null) {
            filter.value = value;
        }
    });

    hash('.filter').on('change', e => {
        if (e.target.id) {
            const searchParams = new URLSearchParams(window.location.search)

            if (!searchParams.has(e.target.id)) {
                searchParams.append(e.target.id, e.target.value);
            } else {
                if (e.target.value === '') {
                    searchParams.delete(e.target.id);
                } else {
                    searchParams.set(e.target.id, e.target.value);
                }
            }

            listOrders(searchParams);
        }
    });


    listOrders(searchParams);
});

const listOrders = (searchParams) => {
    window.history.pushState({}, '', '?' + searchParams.toString());

    const filters = {};

    searchParams.forEach(
        (filter, key) => {
            filters[key] = filter;
        }
    );

    fetchOrders(filters).then(drawOrdersTable);
}

const drawOrdersTable = response => {
    const {
        orders,
        meta
    } = response;

    hash('#pagination').html(drawPagination(meta));
    hash('#orders').html(orders.map(order => {
        const {
            order_id,
            order_date: {date},
            order_status,
            order_currency,
            order_sell_price,
            order_buyer_name
        } = order;

        return `
            <tr>
                <td>${date.substring(0, 19)}</td>
                <td><div data-order_id="${order_id}">#${order_id}</div></td>
                <td><span class="status status-${order_status.toLowerCase()}"></span> ${order_status}</td>
                <td>${order_buyer_name}</td>
                <td>${order_currency} ${order_sell_price}</td>
            </tr>
        `;
    }).join(''));

    hash('.cursor').on('click', e => {
        const searchParams = new URLSearchParams(window.location.search);

        if (e.target.hasAttribute('data-page')) {
            searchParams.set('page', e.target.getAttribute('data-page'));
        }

        listOrders(searchParams);
    });
}

const drawPagination = (meta) => {
    const {
        offset,
        limit,
        count
    } = meta;

    let page = parseInt(offset);
    
    return `
        <span class="cursor" style="display: ${page > 1 ? 'inline-block' : 'none'}" data-page="${page - 1}">↞ </span>
        <span class="current">${page}</span>
        <span class="cursor" style="display: ${count / limit === 0 ? 'none' : 'inline-block'}" data-page="${page + 1}"> ↠</span>
    `;
}
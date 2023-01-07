const fetchOrders = async (filters = {}) => {
    const tbody = hash('#orders').html('');

    ajax.call("\\Order\\OrderList::listOrders", {
        filters: filters
    }).then(orders => {
        orders.forEach(order => {
            const {
                order_id,
                order_date,
                order_status
            } = order;

            tbody.append(`
                <tr data-order_id="${order_id}">
                    <td>#${order_id}</td>
                    <td>${order_date}</td>
                    <td>${order_status}</td>
                    <td></td>
                    <td></td>
                </tr>
            `);
        });
    });
}

document.addEventListener('dispatchModule', async(e) => {
    await fetchOrders();

    hash('#search').on('input', async e => {
        await fetchOrders({orderID: e.target.value})
    });
});

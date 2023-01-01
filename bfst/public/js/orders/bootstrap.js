function fetchOrders (page, filters = {}, limit = 100) {
    let html = "";

    apiCall("\\Order\\OrderList::listOrders", {
        page: page,
        limit: limit,
        filters: filters
    }).done(orders => {
        $.each(orders, (i, order) => {
            const {
                order_status,
                order_date,
                order_id
            } = order;

            html += `
                    <tr data-order_id="${order_id}">
                        <td>#${order_id}</td>
                        <td>${order_date}</td>
                        <td>${order_status}</td>
                        <td></td>
                        <td></td>
                     </tr>
                `;
        });

        $("#orders").html(html);
    });
}


$(document).ready(async () => {
    // Load first page of orders...
    fetchOrders(0);

    $("#search").on('input', async e => {
        fetchOrders(0, {orderID: e.target.value})
    });
});
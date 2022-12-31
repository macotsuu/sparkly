<div class="searchbar">
    <div class="searchbox">
        <label for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
        <input type="text" id="search" placeholder="Wyszukaj przez # zamówienia" />
    </div>
</div>

<table class="table" style="min-width: 900px">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Data</th>
        <th scope="col">Status</th>
        <th scope="col">Klient</th>
        <th scope="col">Kwota</th>
    </tr>
    </thead>
    <tbody id="orders"></tbody>
</table>

<script>
    const fetchOrders = async (page, filters = {}, limit = 100) => {
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
       await fetchOrders(0);

        $("#search").on('input', async e => {
            await fetchOrders(0, {orderID: e.target.value})
        });
    });
</script>
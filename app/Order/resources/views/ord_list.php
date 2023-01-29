<div class="order-listings">
    <div class="filters">
        <h2>Filtrowanie</h2>

        <div class="filter-group">
            <label for="order_id">Numer zamówienia</label>
            <input type="number" id="order_id" class="filter"/>
        </div>

        <div class="filter-group">
            <label for="buyer">Kupujący</label>
            <input type="text" id="buyer" class="filter"/>
        </div>
    </div>
    <div class="orders">
        <div id="pagination"></div>

        <table class="table orders-table">
            <thead>
            <tr>
                <th>Data zakupu</th>
                <th>Numer zamówienia</th>
                <th>Status</th>
                <th>Kupujący</th>
                <th>Suma</th>
            </tr>
            </thead>

            <tbody id="orders"></tbody>
        </table>
    </div>
</div>
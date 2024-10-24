<div class="row align-items-center py-4">
    <div class="col">
        <h6 class="h2 text-white d-inline-block mb-0">Tổng quan theo ngày</h6>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Light table -->
            <div class="table-responsive">
                <table class="table table-striped align-items-center table-flush">
                    <thead class="table-dark" style="position: sticky;top: 0 ">
                    <tr class="">
                        <th class="header" scope="col">Ngày</th>
                        <th class="header" scope="col">Đơn</th>
                        <th class="header" scope="col">SL</th>
                        <th class="header" scope="col" :class="{'invisible': hideByRole}">Tiền hàng</th>
                        <th class="header" scope="col">Tiền ads</th>
                        <th class="header" scope="col" :class="{'invisible': hideByRole}">Vận chuyển</th>
                        <th class="header" scope="col" :class="{'invisible': hideByRole}">Tiền Hoàn</th>
                        <th class="header" scope="col" :class="{'invisible': hideByRole}">Tổng chi</th>
                        <th class="header" scope="col">Tiền COD</th>
                        <th class="header" scope="col" :class="{'invisible': hideByRole}">Lợi nhuận</th>
                        <th class="header" scope="col" :class="{'invisible': hideByRole}">%Ads</th>
                        <th class="header" scope="col" :class="{'invisible': hideByRole}">ROAS</th>
                    </tr>
                    </thead>
                    <tbody class="list table-striped">
                    @verbatim
                    <tr v-for="(item, index) in thisMonthReportItemsTable">
                        <th scope="row">{{ item.date }}</th>
                        <th scope="row" class="row-orders">
                            <span class="editable">
                                {{ item.orders || 0}}
                            </span>
                        </th>
                        <td scope="row" class="row-qty">
                            <span class="editable">
                                {{ item.product_qty || 0}}
                            </span>
                        </td>
                        <td scope="row" @click="resetEditFields(index)" :class="{'invisible': hideByRole}">
                            <span>{{ formatCurrencyNumber(item.totalUnitPrice) }}</span>
                        </td>
                        <td scope="row" class="row-ads">
                            <span class="editable">{{ formatCurrencyNumber(item.ads_amount)}}</span>
                        </td>
                        <td scope="row" :class="{'invisible': hideByRole}">
                            <span>{{ formatCurrencyNumber(item.totalShippingPrice) }}</span>
                        </td>
                        <td scope="row" :class="{'invisible': hideByRole}">
                            <span>{{ formatCurrencyNumber(item.totalReturnPrice) }}</span>
                        </td>
                        <td scope="row" :class="{'invisible': hideByRole}">
                            <span>{{ formatCurrencyNumber(item.totalSpent) }}</span>
                        </td>
                        <td scope="row" class="row-revenue">
                            <span class="editable text-green font-weight-bold">{{ formatCurrencyNumber(item.revenue)}}</span>
                        </td>
                        <td scope="row" :class="{'invisible': hideByRole}">
                            <span class="text-red font-weight-bold">{{ formatCurrencyNumber(item.profit) }}</span>
                        </td>
                        <td scope="row" :class="{'invisible': hideByRole}">
                            <span>{{ formatNumber((item.ads_amount/item.revenue)*100) }}</span>
                        </td>
                        <td scope="row" :class="{'invisible': hideByRole}">
                            <span class="font-weight-bold">{{ formatNumber(item.revenue/item.ads_amount) }}</span>
                        </td>
                    </tr>
                    @endverbatim
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

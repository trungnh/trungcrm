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
                        <th class="header" scope="col">CPA</th>
                        <th class="header" scope="col">% ads</th>
                        <th class="header" scope="col">ROAS</th>
                    </tr>
                    </thead>
                    <tbody class="list table-striped">
                    @verbatim
                    <tr v-for="(item, index) in report.items">
                        <th scope="row">{{ item.date }}</th>
                        <th scope="row" class="row-orders">
                            <span class="editable" @click="enableEditOrder(index)">
                                {{ item.orders || 0}}
                            </span>
                            <input @blur="resetEditFields(index)" type="text" v-model="item.orders" class="form-control" aria-describedby="basic-addon3">
                        </th>
                        <td scope="row" class="row-qty">
                            <span class="editable" @click="enableEditQty(index)">
                                {{ item.product_qty || 0}}
                            </span>
                            <input @blur="resetEditFields(index)" type="text" v-model="item.product_qty" class="form-control" aria-describedby="basic-addon3">
                        </td>
                        <td scope="row" @click="resetEditFields(index)" :class="{'invisible': hideByRole}">
                            <span>{{ formatCurrencyNumber(item.totalUnitPrice) }}</span>
                        </td>
                        <td scope="row" class="row-ads">
                            <span class="editable" @click="enableEditAds(index)">{{ formatCurrencyNumber(item.ads_amount)}}
                            </span>
                            <input @blur="calculateAdsAmount(index, this)" type="text" class="form-control" aria-describedby="basic-addon3">
                        </td>
                        <td scope="row" @click="resetEditFields(index)" :class="{'invisible': hideByRole}">
                            <span>{{ formatCurrencyNumber(item.totalShippingPrice) }}</span>
                        </td>
                        <td scope="row" @click="resetEditFields(index)" :class="{'invisible': hideByRole}">
                            <span>{{ formatCurrencyNumber(item.totalReturnPrice) }}</span>
                        </td>
                        <td scope="row" @click="resetEditFields(index)" :class="{'invisible': hideByRole}">
                            <span>{{ formatCurrencyNumber(item.totalSpent) }}</span>
                        </td>
                        <td scope="row" class="row-revenue">
                            <span class="editable text-green font-weight-bold" @click="enableEditRevenue(index)">{{ formatCurrencyNumber(item.revenue)}}
                            </span>
                            <input @blur="resetEditFields(index)" type="text" v-model="item.revenue" class="form-control" aria-describedby="basic-addon3">
                        </td>
                        <td scope="row" @click="resetEditFields(index)" :class="{'invisible': hideByRole}">
                            <span class="text-red font-weight-bold">{{ formatCurrencyNumber(item.profit) }}</span>&nbsp;<span class="text-green"><small>({{formatNumber((item.profit / item.revenue)*100)}}%)</small></span>
                        </td>
                        <td scope="row" @click="resetEditFields(index)">
                            <span>{{ formatCurrencyNumber(item.cpa) }}</span>
                        </td>
                        <td scope="row" @click="resetEditFields(index)">
                            <span>{{ formatNumber(item.adsRate) }}</span>
                        </td>
                        <td scope="row" @click="resetEditFields(index)">
                            <span>{{ formatNumber(item.roas) }}</span>
                        </td>
                    </tr>
                    @endverbatim
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

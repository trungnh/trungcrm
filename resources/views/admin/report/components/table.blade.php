<div class="row">
    <div class="col">
        <div class="card">
            <!-- Light table -->
            <div class="table-responsive">
                <table class="table table-striped align-items-center table-flush">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Ngày</th>
                        <th scope="col">Đơn</th>
                        <th scope="col">SL</th>
                        <th scope="col">Tiền hàng</th>
                        <th scope="col">Tiền ads</th>
                        <th scope="col">Vận chuyển</th>
                        <th scope="col">Tiền Hoàn</th>
                        <th scope="col">Tổng chi</th>
                        <th scope="col">Tiền COD</th>
                        <th scope="col">Lợi nhuận</th>
                        <th scope="col">CPA</th>
                        <th scope="col">% ads</th>
                        <th scope="col">ROAS</th>
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
                        <td scope="row" @click="resetEditFields(index)">
                            <span>{{ formatCurrencyNumber(item.totalUnitPrice) }}</span>
                        </td>
                        <td scope="row" class="row-ads">
                            <span class="editable" @click="enableEditAds(index)">{{ formatCurrencyNumber(item.ads_amount)}}
                            </span>
                            <input @blur="resetEditFields(index)" type="text" v-model="item.ads_amount" class="form-control" aria-describedby="basic-addon3">
                        </td>
                        <td scope="row" @click="resetEditFields(index)">
                            <span>{{ formatCurrencyNumber(item.totalShippingPrice) }}</span>
                        </td>
                        <td scope="row" @click="resetEditFields(index)">
                            <span>{{ formatCurrencyNumber(item.totalReturnPrice) }}</span>
                        </td>
                        <td scope="row" @click="resetEditFields(index)">
                            <span>{{ formatCurrencyNumber(item.totalSpent) }}</span>
                        </td>
                        <td scope="row" class="row-revenue">
                            <span class="editable text-green font-weight-bold" @click="enableEditRevenue(index)">{{ formatCurrencyNumber(item.revenue)}}
                            </span>
                            <input @blur="resetEditFields(index)"type="text" v-model="item.revenue" class="form-control" aria-describedby="basic-addon3">
                        </td>
                        <td scope="row" @click="resetEditFields(index)">
                            <span class="text-red font-weight-bold">{{ formatCurrencyNumber(item.profit) }}</span>
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

import {global} from '../../../system/storage';
import * as PageModule from '../module';
import axios from "axios";

/**
 * Export main module application for current page.
 */
export default {
    mixins: [
        PageModule.default,
    ],
    data: {
        report: [],
        totalRevenue: 0,
        totalProfit: 0,
        totalUnitPrice: 0,
        totalAds: 0,
        totalProfitRate: 0,
        message: {},

    },
    methods: {
        saveReport() {
            axios.post('/report/saveReport/' + this.report.id, this.report).then(response => {
                if (response.status == 200) {
                    return {data: response.data, success: true};
                } else {
                    return {data: response.data, success: false};
                }
            }).then(res => {
                let type = res.success ? 'success' : 'danger';
                this.setMessage(type, res.data.message);
            });

        },
        handleRateChange () {
            this.report.items.forEach((val) => {
                this.handleChange(val);
            });
        },
        handleChange (newItem) {
            newItem.totalUnitPrice = this.report.product_unit_price * newItem.product_qty;
            newItem.totalShippingPrice = this.report.shipping_rate * newItem.orders;
            newItem.totalReturnPrice = ((newItem.revenue - newItem.totalUnitPrice) * this.report.return_rate) + (newItem.orders * this.report.return_rate * (this.report.shipping_rate/2));
            let adsTax = parseFloat(newItem.ads_amount) * this.report.ads_tax_rate;
            newItem.totalSpent = newItem.totalUnitPrice + newItem.totalShippingPrice + newItem.totalReturnPrice + parseFloat(newItem.ads_amount) + adsTax;
            newItem.profit = newItem.revenue - newItem.totalSpent;
            newItem.cpa = parseFloat(newItem.ads_amount) / newItem.orders;
            newItem.profitPerOrder = newItem.profit / newItem.orders;
            newItem.adsRate = (parseFloat(newItem.ads_amount) / newItem.revenue) * 100;
            newItem.roas = newItem.revenue / parseFloat(newItem.ads_amount);

            this.calculate();
        },
        calculate () {
            this.totalRevenue = 0;
            this.totalProfit = 0;
            this.totalUnitPrice = 0;
            this.totalAds = 0;
            this.totalProfitRate = 0;
            this.report.items.forEach((val) => {
                this.totalRevenue += parseFloat(val.revenue);
                this.totalProfit += parseFloat(val.profit);
                this.totalUnitPrice += parseFloat(val.totalUnitPrice);
                this.totalAds += parseFloat(val.ads_amount);
            });
            this.totalProfitRate = (this.totalProfit / this.totalRevenue) * 100;
        },
        enableEditOrder (index) {
            $('.list').children('tr').eq(index).addClass('editing-orders');
        },
        enableEditQty (index) {
            $('.list').children('tr').eq(index).addClass('editing-qty');
        },
        enableEditAds (index) {
            $('.list').children('tr').eq(index).addClass('editing-ads');
        },
        enableEditRevenue (index) {
            $('.list').children('tr').eq(index).addClass('editing-revenue');
        },
        resetEditFields(index) {
            $('.list').children('tr').eq(index).removeClass('editing-orders');
            $('.list').children('tr').eq(index).removeClass('editing-qty');
            $('.list').children('tr').eq(index).removeClass('editing-ads');
            $('.list').children('tr').eq(index).removeClass('editing-revenue');
        },
        formatNumber(number) {
            return (isNaN(number) || number == 0) ? '-' : new Intl.NumberFormat('vi-VN', { maximumSignificantDigits: 2 }).format(number);
        },
        formatCurrencyNumber(number) {
            return (isNaN(number) || number == 0) ? '-' : new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
        },
        parseCustomFields(field) {
            return JSON.parse(field);
        },
        setMessage(type, content) {
            this.message = {
                messageClass: 'alert alert-' + type,
                messageText: content,
            }

            return;
        },
        setData: function () {
            if (global.report) {
                this.report = global.report;
                this.calculate();
            }
        },

    },
    created () {
        this.setData();
        this.report.items.forEach((val) => {
            this.$watch(() => val, this.handleChange, {deep: true});
        });
    },
    mounted () {
        this.setData();
    }
}

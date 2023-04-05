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
        reportsOfLastMonth: [],
        reportsOfThisMonth: [],
        filterMonth: null,
        totalOrders: 0,
        totalRevenue: 0,
        totalAds: 0,
        totalProfit: 0,
        totalLastMonthOrders: 0,
        totalLastMonthRevenue: 0,
        totalLastMonthAds: 0,
        totalLastMonthProfit: 0,
    },
    methods: {
        calculateThisMonth (report) {
            let orders = 0;
            let totalProfit = 0;
            let totalAds = 0;
            let totalRevenue = 0;
            report.items.forEach((val) => {
                orders += parseFloat(val.orders);
                totalProfit += parseFloat(val.profit);
                totalAds += parseFloat(val.ads_amount);
                totalRevenue += parseFloat(val.revenue);
            });

            report.orders = orders;
            report.totalProfit = totalProfit;
            report.totalAds = totalAds;
            report.totalRevenue = totalRevenue;

            this.totalOrders += orders;
            this.totalRevenue += totalRevenue;
            this.totalAds += totalAds;
            this.totalProfit += totalProfit;
        },
        calculateLastMonth (report) {
            let orders = 0;
            let totalProfit = 0;
            let totalAds = 0;
            let totalRevenue = 0;
            report.items.forEach((val) => {
                orders += parseFloat(val.orders);
                totalProfit += parseFloat(val.profit);
                totalAds += parseFloat(val.ads_amount);
                totalRevenue += parseFloat(val.revenue);
            });

            report.orders = orders;
            report.totalProfit = totalProfit;
            report.totalAds = totalAds;
            report.totalRevenue = totalRevenue;

            this.totalLastMonthOrders += orders;
            this.totalLastMonthRevenue += totalRevenue;
            this.totalLastMonthAds += totalAds;
            this.totalLastMonthProfit += totalProfit;
        },
        calculateRate(val1, val2) {
            let diff = val2 - val1;
            let rate = (diff / val1) * 100;

            return rate.toFixed(2);
        },
        changeMonth() {
            axios.get('/home/changeReportMonth/' + this.filterMonth).then(response => {
                if (response.status == 200) {
                    return {data: response.data, success: true};
                } else {
                    return {data: response.data, success: false};
                }
            }).then(res => {
                this.reportsOfLastMonth = res.data.reportsOfLastMonth.data;
                this.reportsOfThisMonth = res.data.reportsOfThisMonth.data;

                this.totalOrders = 0;
                this.totalRevenue = 0;
                this.totalAds = 0;
                this.totalProfit = 0;
                this.totalLastMonthOrders = 0;
                this.totalLastMonthRevenue = 0;
                this.totalLastMonthAds = 0;
                this.totalLastMonthProfit = 0;

                this.reportsOfLastMonth.forEach((report) => {
                    this.calculateLastMonth(report);
                });
                this.reportsOfThisMonth.forEach((report) => {
                    this.calculateThisMonth(report);
                });
            });
        },
        getReportName (reportName, userName) {
            if (global.loggedUser.role == 'admin') {
                return reportName + ' - ' + userName;
            }

            return reportName;
        },
        showFilter() {
            return global.loggedUser.role == 'admin';
        },
        formatNumber(number) {
            return (isNaN(number) || number == 0) ? '-' : new Intl.NumberFormat('vi-VN', { maximumSignificantDigits: 2 }).format(number);
        },
        formatCurrencyNumber(number) {
            return (isNaN(number) || number == 0) ? '-' : new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
        },
        getEditLink(id) {
            return '/report/edit/' + id;
        },
        parseCustomFields(field) {
            return JSON.parse(field);
        },
        setItems: function () {
            if (global.reportsOfLastMonth) {
                this.reportsOfLastMonth = global.reportsOfLastMonth.data;
                this.reportsOfThisMonth = global.reportsOfThisMonth.data;

                this.reportsOfLastMonth.forEach((report) => {
                    this.calculateLastMonth(report);
                });
                this.reportsOfThisMonth.forEach((report) => {
                    this.calculateThisMonth(report);
                });
            }
        },

    },
    mounted () {
        this.setItems();
    }
}

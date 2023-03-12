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
        reports: [],
        products: [],
        report: {
            month: '',
            product_id: '',
            // fields: []
        },
        filterMonth: null,
        filterUser: null,
        filterProduct: null,
        totalOrders: 0,
        totalAds: 0,
        totalProfit: 0,
        message: {},
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,

    },
    methods: {
        addReport() {
            axios.post('/report/addReport', this.report).then(response => {
                if (response.status == 200) {
                    return {data: response.data, success: true};
                } else {
                    return {data: response.data, success: false};
                }
            }).then(res => {
                this.report = {
                    month: '',
                    product_id: '',
                };
                let type = res.success ? 'success' : 'danger';
                this.reports.push(res.data.report);
                this.setMessage(type, res.data.message);
            });

        },
        calculate (report) {
            let orders = 0;
            let totalProfit = 0;
            let totalAds = 0;
            report.items.forEach((val) => {
                orders += parseFloat(val.orders);
                totalProfit += parseFloat(val.profit);
                totalAds += parseFloat(val.ads_amount);
            });

            report.orders = orders;
            report.totalProfit = totalProfit;
            report.totalAds = totalAds;

            this.totalOrders += orders;
            this.totalAds += totalAds;
            this.totalProfit += totalProfit;
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
        setMessage(type, content) {
            this.message = {
                messageClass: 'alert alert-' + type,
                messageText: content,
            }

            return;
        },
        setItems: function () {
            if (global.reports) {
                this.reports = global.reports.data;
                this.products = global.products.data;
                this.pagination = global.reports.pagination;
            }
        },

    },
    computed: {
        filteredReports() {
            let filtered = this.reports;
            if (this.filterMonth != null) {
                filtered = filtered.filter(item => {
                    return item.month.toLowerCase().indexOf(this.filterMonth.toLowerCase()) > -1
                })
            }
            if (this.filterUser != null) {
                filtered = filtered.filter(item => {
                    return item.user.name.toLowerCase().indexOf(this.filterUser.toLowerCase()) > -1
                })
            }
            if (this.filterProduct != null) {
                filtered = filtered.filter(item => {
                    return item.product.name.toLowerCase().indexOf(this.filterProduct.toLowerCase()) > -1
                })
            }

            this.totalOrders = 0;
            this.totalAds = 0;
            this.totalProfit = 0;
            filtered.forEach((report) => {
                this.calculate(report);
            });

            return filtered;
        },

        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }

    },
    mounted () {
        this.setItems();
    }
}

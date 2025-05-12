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
        thisMonthReportItemsTable: [],
        filterMonth: null,
        filterUser: null,
        filterProduct: null,
        usersInFilter: [],
        productsInFilter: [],
        users: [],
        totalOrders: 0,
        totalRevenue: 0,
        totalAds: 0,
        totalProfit: 0,
        totalProfitRate: 0,
        totalLastMonthOrders: 0,
        totalLastMonthRevenue: 0,
        totalLastMonthAds: 0,
        totalLastMonthProfit: 0,
        hideByRole: false
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

            this.totalProfitRate  = this.formatNumber((this.totalProfit / this.totalRevenue) * 100);
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
        changeUser() {
            let urlParams = this.getAllUrlParams();
            let targetUrl = "?user=" + event.target.value; 
            if (urlParams.month) {
                targetUrl += "&month=" + urlParams.month;
            } 
            if (urlParams.product) {
                targetUrl += "&product=" + urlParams.product;
            }
            window.location.href = targetUrl; 
        },
        changeProduct() {
            let urlParams = this.getAllUrlParams();
            let targetUrl = "?product=" + event.target.value; 
            if (urlParams.month) {
                targetUrl += "&month=" + urlParams.month;
            } 
            if (urlParams.user) {
                targetUrl += "&user=" + urlParams.user;
            }
            window.location.href = targetUrl; 
        },
        changeMonth() {
            let urlParams = this.getAllUrlParams();
            let targetUrl = "?month=" + event.target.value; 
            if (urlParams.product) {
                targetUrl += "&product=" + urlParams.product;
            } 
            if (urlParams.user) {
                targetUrl += "&user=" + urlParams.user;
            }
            window.location.href = targetUrl; 
            //window.location.href = "?month=" + event.target.value;
            // axios.get('/home/changeReportMonth/' + this.filterMonth).then(response => {
            //     if (response.status == 200) {
            //         return {data: response.data, success: true};
            //     } else {
            //         return {data: response.data, success: false};
            //     }
            // }).then(res => {
            //     this.reportsOfLastMonth = res.data.reportsOfLastMonth.data;
            //     this.reportsOfThisMonth = res.data.reportsOfThisMonth.data;
            //     this.thisMonthReportItemsTable = res.data.thisMonthReportItemsTable;

            //     this.totalOrders = 0;
            //     this.totalRevenue = 0;
            //     this.totalAds = 0;
            //     this.totalProfit = 0;
            //     this.totalLastMonthOrders = 0;
            //     this.totalLastMonthRevenue = 0;
            //     this.totalLastMonthAds = 0;
            //     this.totalLastMonthProfit = 0;

            //     this.reportsOfLastMonth.forEach((report) => {
            //         this.calculateLastMonth(report);
            //     });
            //     this.reportsOfThisMonth.forEach((report) => {
            //         this.calculateThisMonth(report);
            //     });
            // });
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
        getAllUrlParams() {
            const url = new URL(window.location.href) + '';
            // get query string from url (optional) or window
            var queryString = url ? url.split('?')[1] : window.location.search.slice(1);
        
            // we'll store the parameters here
            var obj = {};
        
            // if query string exists
            if (queryString) {
        
                // stuff after # is not part of query string, so get rid of it
                queryString = queryString.split('#')[0];
        
                // split our query string into its component parts
                var arr = queryString.split('&');
        
                for (var i = 0; i < arr.length; i++) {
                    // separate the keys and the values
                    var a = arr[i].split('=');
        
                    // set parameter name and value (use 'true' if empty)
                    var paramName = a[0];
                    var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];
        
                    // (optional) keep case consistent
                    paramName = paramName.toLowerCase();
                    if (typeof paramValue === 'string') paramValue = paramValue.toLowerCase();
        
                    // if the paramName ends with square brackets, e.g. colors[] or colors[2]
                    if (paramName.match(/\[(\d+)?\]$/)) {
        
                        // create key if it doesn't exist
                        var key = paramName.replace(/\[(\d+)?\]/, '');
                        if (!obj[key]) obj[key] = [];
        
                        // if it's an indexed array e.g. colors[2]
                        if (paramName.match(/\[\d+\]$/)) {
                            // get the index value and add the entry at the appropriate position
                            var index = /\[(\d+)\]/.exec(paramName)[1];
                            obj[key][index] = paramValue;
                        } else {
                            // otherwise add the value to the end of the array
                            obj[key].push(paramValue);
                        }
                    } else {
                        // we're dealing with a string
                        if (!obj[paramName]) {
                            // if it doesn't exist, create property
                            obj[paramName] = paramValue;
                        } else if (obj[paramName] && typeof obj[paramName] === 'string'){
                            // if property does exist and it's a string, convert it to an array
                            obj[paramName] = [obj[paramName]];
                            obj[paramName].push(paramValue);
                        } else {
                            // otherwise add the property
                            obj[paramName].push(paramValue);
                        }
                    }
                }
            }
        
            return obj;
        },
        setItems: function () {
            if (global.reportsOfLastMonth) {
                this.reportsOfLastMonth = global.reportsOfLastMonth.data;
                this.reportsOfThisMonth = global.reportsOfThisMonth.data;
                this.thisMonthReportItemsTable = global.thisMonthReportItemsTable;

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
        if (global.loggedUser.role != 'admin') {
            this.hideByRole = true;
        }
        let urlParams = this.getAllUrlParams();
        if (urlParams.user) {
            this.filterUser = urlParams.user;
        }
        if (urlParams.product) {
            this.filterProduct = urlParams.product;
        }
        if (urlParams.month) {
            this.filterMonth = urlParams.month;
        }
        this.setItems();
    }
}

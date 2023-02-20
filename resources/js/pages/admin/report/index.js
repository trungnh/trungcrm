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
        buildNameReport (source, productName, month) {
            let monthPath = month.split('-');

            return source + ' - ' + productName + ' Tháng ' + monthPath[1];
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

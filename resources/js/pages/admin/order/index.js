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
        orders: [],
        products: global.products,
        useProduct: {},
        useCustomer: {},
        tmpOrder: {
            customer_name: '',
            phone: '',
            address: '',
            qty: 1,
            total: '',
            note: '',
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
        setItems: function () {
            if (global.orders) {
                this.orders = global.orders.data;
                this.orders = global.orders.pagination;
            }
        },
        setUseProduct: function (product) {
            this.useProduct = product;
            this.tmpOrder.product_id = product.id;
        },
        setUseCustomer: function (customer) {
            this.useCustomer = customer;
            this.tmpOrder.customer_id = customer.id;
        },
        parseCustomFields(field) {
            return JSON.parse(field);
        },
        addOrder() {
            let params = {
                order: this.tmpOrder,
                product: this.useProduct,
                customer: this.useCustomer
            }

            axios.post('/addOrder', params).then(response => {
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
        setMessage(type, content) {
            this.message = {
                messageClass: 'alert alert-' + type,
                messageText: content,
            }

            return;
        },
        getCustomer() {
            axios.post('/getCustomer', {phone: this.tmpOrder.phone}).then(response => {
                if (response.status == 200) {
                    return {data: response.data, success: true};
                } else {
                    return {data: response.data, success: false};
                }
            }).then(res => {
                this.customer = res.data.customer;
                this.tmpOrder.customer_name = this.customer.name;
                this.tmpOrder.address = this.customer.address;
            });
        }
        // changePage: function (page=1) {
        //     this.pagination.current_page = page;
        //     this.getItems(page);
        // },
        // getItems: function (page) {
        //     this.loading = true;
        //     let params = {
        //         page: page
        //     };
        //     axios.post(this.getListUrl, params)
        //         .then(function ( response) {
        //             if (response.status == 200) {
        //                 return {data: response.data, success: true};
        //             } else {
        //                 return {data: response.data, success: false};
        //             }
        //         }).then(res => {
        //         if (res.success) {
        //             this.items = res.data.data;
        //             this.pagination = res.data.pagination;
        //         }
        //         this.loading = false;
        //     });
        // },

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
        },
        total () {
            this.tmpOrder.total = this.tmpOrder.qty * parseInt(this.useProduct.price||0);
            return this.tmpOrder.total;
        },
    },
    mounted () {
        this.setItems();
    }
}

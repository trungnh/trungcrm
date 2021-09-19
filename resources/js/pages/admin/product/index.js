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
        products: [],
        product: {
            name: '',
            price: 0,
            fields: [
                {
                    label: 'Label 1',
                    value: '',
                }
            ]
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
        addField() {
            let fieldCount = this.product.fields.length;
            this.product.fields.push({
                label: 'Label ' + (fieldCount+1),
                value: '',
            });
        },
        removeField(item) {
            this.product.fields.splice(this.product.fields.indexOf(item), 1);
        },
        addProduct() {
            axios.post('/addProduct', this.product).then(response => {
                if (response.status == 200) {
                    return {data: response.data, success: true};
                } else {
                    return {data: response.data, success: false};
                }
            }).then(res => {
                this.product = {
                    name: '',
                        price: 0,
                        fields: [
                        {
                            label: 'Label 1',
                            value: '',
                        }
                    ]
                };
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
        setItems: function () {
            if (global.products) {
                this.products = global.products.data;
                this.pagination = global.products.pagination;
            }
        },
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
        }

    },
    mounted () {
        this.setItems();
        console.log(this.products);
    }
}

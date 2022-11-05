import {global} from '../../../system/storage';
import * as PageModule from '../module';
import axios from "axios";
import {parseInt} from "lodash/string";

/**
 * Export main module application for current page.
 */
export default {
    mixins: [
        PageModule.default,
    ],
    data: {
        user_id: global.userId,
        adaIgnoreIds: global.adaIgnoreIds,
        bmData: [],
        loading: false

    },
    methods: {
        setItems: function () {
            if (global.bmData) {
                this.bmData = global.bmData;
            }
        },
        addAdaIgnoreIds() {
            axios.post('/addAdaIgnoreIds', {ignored_ada_ids: this.adaIgnoreIds}).then(response => {
                if (response.status == 200) {
                    return {data: response.data, success: true};
                } else {
                    return {data: response.data, success: false};
                }
            });

        },
        reload: function () {
            this.loading = true;
            this.bmData = [];
            axios.get('/reloadAccount').then(response => {
                if (response.status == 200) {
                    return {data: response.data, success: true};
                } else {
                    return {data: response.data, success: false};
                }
            }).then(res => {
                this.bmData = res.data.bmData;
                this.loading = false;
            });
        },
        statusIdToText: function (status) {
            let realStt = '';
            switch (status) {
                case 1:
                    realStt = 'ACTIVE';
                    break;
                case 2:
                    realStt = 'VÔ HIỆU HÓA';
                    break;
                case 3:
                    realStt = 'UNSETTLED';
                    break;
                case 7:
                    realStt = 'PENDING_RISK_REVIEW';
                    break;
                case 8:
                    realStt = 'PENDING_SETTLEMENT';
                    break;
                case 9:
                    realStt = 'IN_GRACE_PERIOD';
                    break;
                case 100:
                    realStt = 'PENDING_CLOSURE';
                    break;
                case 101:
                    realStt = 'CLOSED';
                    break;
                case 201:
                    realStt = 'ANY_ACTIVE';
                    break;
                case 202:
                    realStt = 'ANY_CLOSED';
                    break;
            }
            return realStt;
        },
        rowClass: function (status, payment) {
            let className = '';
            switch (status) {
                case 1:
                    className = 'row-active';
                    break;
                case 2:
                    className = 'row-disabled';
                    break;
                case 3:
                    className = 'row-unsettled';
                    break;
                default:
                    className = 'row-disabled';
                    break;
            }

            if (payment.currentBilling >= (payment.threshold * 0.8)) {
                className = 'row-unsettled';
            }


            return className;
        },
        formatNumber : function (number) {
            let numberIn = parseInt(number);
            return new Intl.NumberFormat('vi-VN').format(numberIn);
        }

    },
    computed: {},
    mounted () {
        this.setItems();
    }
}

import {global} from '../../../system/storage';
import * as PageModule from '../module';
import axios from "axios";
import {parseInt} from "lodash/string";
import DateRangePicker from 'vue2-daterange-picker'
//you need to import the CSS manually
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'
import moment from 'moment';

/**
 * Export main module application for current page.
 */
export default {
    mixins: [
        PageModule.default,
    ],
    data: {
        bmData: [],
        campData: [],
        selectedBM: null,
        selectedAda: null,
        startDate: moment(new Date()).format("DD-MM-YYYY"),
        endDate: moment(new Date()).format("DD-MM-YYYY"),
        dateRange: { startDate: new Date(), endDate: new Date() },
        locale: {
            direction: "ltr",
            format: "DD-MM-YYYY",
            separator: " - ",
            applyLabel: "Apply",
            cancelLabel: "Cancel",
            weekLabel: "W",
            customRangeLabel: "Custom Range",
            daysOfWeek: moment.weekdaysMin(),
            monthNames: moment.monthsShort(),
            firstDay: 1
        },
        loading: false

    },
    components: {
        DateRangePicker
    },
    methods: {
        setItems: function () {
            if (global.bmData) {
                this.bmData = global.bmData;
            }
        },
        formatDisplayDate: function (date) {
            return moment(date).format("DD-MM-YYYY");
        },
        updateValues: function (value) {
            this.startDate = moment(value.startDate).format("DD-MM-YYYY");
            this.endDate = moment(value.endDate).format("DD-MM-YYYY");
        },
        loadData: function () {
            this.loading = true;
            this.campData = [];
            let params = {
                bm_id: this.selectedBM.business_id,
                ada_id: this.selectedAda,
                start: this.startDate,
                end: this.endDate,
            }
            axios.post('/getCampData', params).then(response => {
                if (response.status == 200) {
                    return {data: response.data, success: true};
                } else {
                    return {data: response.data, success: false};
                }
            }).then(res => {
                this.campData = res.data.campData;
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
                case 'PAUSED':
                    className = 'row-unsettled';
                    break;
                default:
                    className = 'row-active';
                    break;
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

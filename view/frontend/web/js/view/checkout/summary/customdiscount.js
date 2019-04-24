define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/totals'
    ],
    function ($,Component,totals) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Mageplaza_GiftCard/checkout/summary/customdiscount'
            },
            isDisplayedCustomdiscount: function () {
                var amount;
                if (totals.getSegment('customer_discount') === null ){
                    amount = 0;
                } else {
                    amount = totals.getSegment('customer_discount').value;
                }
                return amount;
            },
            getCustomDiscount: function () {
                var amount = totals.getSegment('customer_discount').value;
                console.log(this);
                return this.getFormattedPrice(amount);
            },
            getDiscountCode: function () {
                var title = totals.getSegment('customer_discount').title;
                return title;
            }
        });
    }
);
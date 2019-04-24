define(
    [
        'jquery',
    ],
    function ($,Component) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Mageplaza_GiftCard/checkout/summary/'
            },
            isLockDiscountInput: function () {
                var amount;
                if (totals.getSegment('customer_discount') === null ){
                    amount = 0;
                } else {
                    amount = totals.getSegment('customer_discount').value;
                }
                return amount;
            },

        });
    }
);
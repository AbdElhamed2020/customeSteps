define([
    'jquery',
    'underscore',
    'uiComponent',
    'ko',
    'Magento_Checkout/js/model/step-navigator'
    ], function ($, _, Component, ko, stepNavigator) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Subscription_Products/customer/list'
        },
        isVisible: ko.observable(true),
        initialize: function (config) {
            this._super();
            // component initialization logic
            // register your step
            stepNavigator.registerStep(
                //step code will be used as step content id in the component template
                'first-step',
                //step alias
                'first-step',
                //step title value
                'Working Title',
                //observable property with logic when display step or hide step
                this.isVisible,

                _.bind(this.navigate, this),

                /**
                 * sort order value
                 * 'sort order value' < 10: step displays before shipping step;
                 * 10 < 'sort order value' < 20 : step displays between shipping and payment step
                 * 'sort order value' > 20 : step displays after payment step
                 */
                15
            );

            // this.isVisible = false;
            return this;
        },
        navigate: function (step) {
            step && step.isVisible(true);
        },

        /**
         * @returns void
         */
        navigateToNextStep: function () {
            stepNavigator.next();
        }
    });
});

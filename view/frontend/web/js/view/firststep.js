// file view/frontend/web/js/view/resume.js
define([
    'ko',
    'uiComponent',
    'underscore',
    'Magento_Checkout/js/model/step-navigator'
], function (
    ko,
    Component,
    _,
    stepNavigator
) {
    return Component.extend({
        defaults: {
            template: 'Subscription_Products/steps/firststep',
            isVisible: ko.observable(true),
            stepCode: 'firststep',
            stepTitle: 'firststep',
        },

        /**
         * @return {*}
         */
        initialize: function () {
            this._super();
            stepNavigator.registerStep(
                this.stepCode, null, this.stepTitle, this.isVisible, _.bind(this.navigate, this), 25
            );

            return this;
        },

        /**
         * @returns void
         */
        navigate: function () {
            this.isVisible(true);
        },

        /**
         * @returns void
         */
        navigateToNextStep: function () {
            stepNavigator.next();
        }
    });
});

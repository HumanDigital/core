<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009-2014 terminal42 gmbh & Isotope eCommerce Workgroup
 *
 * @package    Isotope
 * @link       http://isotopeecommerce.org
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

namespace Isotope\CheckoutStep;

use Isotope\Interfaces\IsotopeCheckoutStep;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Isotope;
use Isotope\Model\Payment;
use Isotope\Module\Checkout;
use Isotope\Template;

/**
 * Checkout step lets the user choose a payment method in PayPal PLUS
 */
class PaymentPaypalPlus extends CheckoutStep implements IsotopeCheckoutStep
{
    /**
     * Payment modules
     * @var array
     */
    private $modules;

    /**
     * Returns true if the current cart has payment
     *
     * @inheritdoc
     */
    public function isAvailable()
    {
        if (!Isotope::getCart()->requiresPayment()) {
            return false;
        }

        $this->initializeModules();

        return 0 !== count($this->modules);
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $this->initializeModules();

        if (0 === count($this->modules)) {
            return '';
        }

        return 'PayPal PLUS';
    }

    /**
     * Return review information for last page of checkout
     * @return  string
     */
    public function review()
    {
        return array(
            'payment_method' => array(
                'headline' => $GLOBALS['TL_LANG']['MSC']['payment_method'],
                'info'     => Isotope::getCart()->getDraftOrder()->getPaymentMethod()->checkoutReview(),
                'note'     => Isotope::getCart()->getDraftOrder()->getPaymentMethod()->getNote(),
                'edit'     => $this->isSkippable() ? '' : Checkout::generateUrlForStep('payment'),
            ),
        );
    }

    /**
     * @inheritdoc
     */
    public function getNotificationTokens(IsotopeProductCollection $objCollection)
    {
        // TODO add invoice tokens from PayPal API
        return [];
    }

    /**
     * Initialize modules and options
     */
    private function initializeModules()
    {
        if (null !== $this->modules) {
            return;
        }

        $this->modules = [];

        $modules = deserialize($this->objModule->iso_payment_modules);

        if (empty($modules) || !is_array($modules)) {
            return;
        }

        $arrColumns = [
            'id IN (' . implode(',', $modules) . ')',
            "type='paypal_plus'"
        ];

        if (BE_USER_LOGGED_IN !== true) {
            $arrColumns[] = "enabled='1'";
        }

        /** @type Payment[] $objModules */
        $objModules = Payment::findBy($arrColumns, null, array('order' => \Database::getInstance()->findInSet('id', $modules)));

        if (null !== $objModules) {
            foreach ($objModules as $objModule) {

                if (!$objModule->isAvailable()) {
                    continue;
                }

                $this->modules[$objModule->id] = $objModule;
            }
        }
    }
}

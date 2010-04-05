<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Winans Creative 2009
 * @author     Fred Bliss <fred@winanscreative.com>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


// Default settings, can be overwritten in localconfig.php
$GLOBALS['TL_CONFIG']['isotope_root'] = TL_ROOT . '/isotope';
$GLOBALS['TL_CONFIG']['isotope_upload_path'] = 'isotope';


/**
 * Backend modules
 */
if (!is_array($GLOBALS['BE_MOD']['store']))
{
	array_insert($GLOBALS['BE_MOD'], 1, array('store' => array()));
}
 
array_insert($GLOBALS['BE_MOD']['store'], 0, array
(
	'product_manager' => array
	(
		'tables'					=> array('tl_product_data', 'tl_product_downloads', 'tl_product_categories'),
		'icon'						=> 'system/modules/isotope/html/icon-products.gif',
		'stylesheet'				=> 'system/modules/isotope/html/backend.css',
		'javascript'				=> 'system/modules/isotope/html/backend.js',
		'import'					=> array('tl_product_data', 'importAssets')
	),
	'orders' => array
	(
		'tables'					=> array('tl_iso_orders', 'tl_iso_order_items'),
		'icon'						=> 'system/modules/isotope/html/icon-orders.gif',
		'stylesheet'				=> 'system/modules/isotope/html/backend.css',
		'export_emails'     		=> array('IsotopeExport', 'exportOrderEmails'),
		'authorize_process_payment'	=> array('IsotopePOS', 'getPOSInterface'),
		'print_order'				=> array('IsotopePOS','printInvoice'),
	),
	'iso_statistics' => array
	(
		'callback'					=> 'ModuleIsotopeStatistics',
		'icon'						=> 'system/modules/isotope/html/icon-statistics.gif',
	),
	'isotope' => array
	(
		'callback'					=> 'ModuleIsotopeConfig',
		'tables'					=> array('tl_store', 'tl_shipping_modules', 'tl_shipping_options', 'tl_payment_modules', 'tl_payment_options', 'tl_tax_class', 'tl_tax_rate', 'tl_product_types', 'tl_product_attributes', 'tl_iso_mail', 'tl_iso_mail_content'),
		'icon'						=> 'system/modules/isotope/html/icon-store.gif',
		'stylesheet'				=> 'system/modules/isotope/html/backend.css',
	),
));

$GLOBALS['BE_MOD']['accounts']['member']['tables'][] = 'tl_address_book';

// Callback is only used for overview screen
if ($_GET['do'] == 'isotope' && strlen($_GET['table']))
{
	unset($GLOBALS['BE_MOD']['store']['isotope']['callback']);
}



// Isotope Modules
$GLOBALS['ISO_MOD'] = array
(
	'checkout' => array
	(
		'shipping' => array
		(
				'tables'				=> array('tl_shipping_modules','tl_shipping_options'),
				'icon'					=> 'system/modules/isotope/html/icon-shipping.gif',
		),
		'payment' => array
		(
			'tables'					=> array('tl_payment_modules', 'tl_payment_options'),
			'icon'						=> 'system/modules/isotope/html/icon-payment.png',
		),
		'tax_class' => array
		(
			'tables'					=> array('tl_tax_class'),
			'icon'						=> 'system/modules/isotope/html/icon-taxclass.gif',
		),
		'tax_rate' => array
		(
			'tables'					=> array('tl_tax_rate'),
			'icon'						=> 'system/modules/isotope/html/icon-taxrate.gif',
		),
	),
	'product' => array
	(
		'product_type_manager' => array
		(
			'tables'					=> array('tl_product_types'),
			'icon'						=> 'system/modules/isotope/html/icon-types.gif'
		),
		'attribute_manager' => array
		(
			'tables'					=> array('tl_product_attributes'),
			'icon'						=> 'system/modules/isotope/html/icon-attributes.gif',
		),
	),
	'config' => array
	(
		'iso_mail' => array
		(
			'tables'					=> array('tl_iso_mail', 'tl_iso_mail_content'),
			'icon'						=> 'system/modules/isotope/html/icon-mail.gif',
		),
		'store_configuration' => array
		(
			'callback'					=> 'ModuleIsotopeConfig',
			'tables'					=> array('tl_store'),
			'icon'						=> 'system/modules/isotope/html/icon-store.gif',
		),
	)
);



/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['createNewUser'][]				= array('Isotope', 'createNewUser');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][]			= array('Isotope', 'replaceIsotopeTags');
$GLOBALS['TL_HOOKS']['generatePage'][]				= array('Isotope', 'generatePage');
$GLOBALS['TL_HOOKS']['loadDataContainer'][]			= array('ProductCatalog', 'loadProductCatalogDCA');
$GLOBALS['TL_HOOKS']['isoButtons'][]				= array('Isotope', 'defaultButtons');
//$GLOBALS['TL_HOOKS']['googleTracking'][] 			= array('ModuleIsotopeCheckout', 'googleTracking');



/**
 * Checkout surcharge calculation callbacks
 */
$GLOBALS['TL_HOOKS']['isoCheckoutSurcharge'][] = array('IsotopeCart', 'getShippingSurcharge');
$GLOBALS['TL_HOOKS']['isoCheckoutSurcharge'][] = array('IsotopeCart', 'getPaymentSurcharge');


/**
 * Backend form fields
 */
$GLOBALS['BE_FFL']['mediaManager']		= 'MediaManager';
$GLOBALS['BE_FFL']['attributeWizard']	= 'AttributeWizard';
$GLOBALS['BE_FFL']['optionDataWizard']	= 'OptionDataWizard';
$GLOBALS['BE_FFL']['surchargeWizard']	= 'SurchargeWizard';
$GLOBALS['BE_FFL']['variantWizard']		= 'VariantWizard';


/**
 * Frontend modules
 */
$GLOBALS['FE_MOD']['isotope'] = array
(
	'isoProductLister'			=> 'ModuleIsotopeProductList',
	'isoProductReader'			=> 'ModuleIsotopeProductReader',
	'isoShoppingCart'			=> 'ModuleIsotopeCart',
	'isoCheckout'				=> 'ModuleIsotopeCheckout',
	'isoFilterModule'			=> 'ModuleIsotopeProductFilters',
	'isoGiftRegistryManager'	=> 'ModuleGiftRegistry',
	'isoGiftRegistrySearch'		=> 'ModuleGiftRegistrySearch',
	'isoGiftRegistryResults'	=> 'ModuleGiftRegistryResults',
	'isoGiftRegistryReader'		=> 'ModuleGiftRegistryReader',
	'isoAddressBook'			=> 'ModuleAddressBook',
	'isoOrderHistory'			=> 'ModuleIsotopeOrderHistory',
	'isoOrderDetails'			=> 'ModuleIsotopeOrderDetails',
	'isoStoreSwitcher'			=> 'ModuleIsotopeStoreSwitcher',
	'isoDonationsModule'		=> 'ModuleDonations',
);


/** 
 * Form fields
 */
$GLOBALS['TL_FFL']['textCollection'] = 'FormTextCollectionField';


/** 
 * Weight conversation
 */
$GLOBALS['ISO_WGT'] = array
(
	'gram' 	=> 1,
	'kg' 	=> 1000,
	'oz' 	=> 28.35,
	'lbs' 	=> 453.6,
);


/**
 * Shipping modules
 */
$GLOBALS['ISO_SHIP']['order_total']	 = 'ShippingOrderTotal';
$GLOBALS['ISO_SHIP']['flat']		 = 'ShippingFlat';
$GLOBALS['ISO_SHIP']['ups']			 = 'ShippingUPS';
$GLOBALS['ISO_SHIP']['usps']		 = 'ShippingUSPS';


/**
 * Payment modules
 */
$GLOBALS['ISO_PAY']['cash']						= 'PaymentCash';
$GLOBALS['ISO_PAY']['paypal']					= 'PaymentPaypal';
$GLOBALS['ISO_PAY']['paypalpro']				= 'PaymentPaypalPro';
$GLOBALS['ISO_PAY']['paypalpayflowpro']			= 'PaymentPaypalPayflowPro';
$GLOBALS['ISO_PAY']['postfinance']				= 'PaymentPostfinance';
$GLOBALS['ISO_PAY']['authorizedotnet']			= 'PaymentAuthorizeDotNet';


/** 
 * Order Statuses
 */
$GLOBALS['ISO_ORDER'] = array('pending','processing','shipped','complete','on_hold', 'cancelled');


/**
 * Product types
 */
$GLOBALS['ISO_PRODUCT'] = array
(
	'regular' => array
	(
		'class'	=> 'IsotopeProduct',
	),
);


/** 
 * Order module additional operations
 */
$GLOBALS['ISO_ORDERS']['operations']['authorizedotnet'] = 'IsotopePOS';
$GLOBALS['ISO_ORDERS']['operations']['paypalpayflowpro'] = 'PayflowProPOS';


/** 
 * Miscellaneous Isotope-specific settings
 */
$GLOBALS['ISO_MSC']['tl_product_data']['groups_ordering'] = array
('general_legend','pricing_legend','inventory_legend','shipping_legend','tax_legend','options_legend','media_legend','publish_legend');

	
/**
 * Content elements
 */
$GLOBALS['TL_CTE']['links']['attributeLinkRepeater'] = 'ContentAttributeLinkRepeater';


/** 
 * Permissions are access settings for user and groups (fields in tl_user and tl_user_group)
 */
$GLOBALS['TL_PERMISSIONS'][] = 'iso_stores';
$GLOBALS['TL_PERMISSIONS'][] = 'iso_product_types';
$GLOBALS['TL_PERMISSIONS'][] = 'iso_modules';


/**
 * Number formatting
 */
$GLOBALS['ISO_NUM']["10000.00"]		= array(2, '.', "");
$GLOBALS['ISO_NUM']["10,000.00"]	= array(2, '.', ",");
$GLOBALS['ISO_NUM']["10.000,00"]	= array(2, ',', ".");
$GLOBALS['ISO_NUM']["10'000.00"]	= array(2, '.', "'");


/**
 * Step callbacks for checkout module
 */
$GLOBALS['ISO_CHECKOUT_STEPS'] = array
(
	'address' => array
	(
		array('ModuleIsotopeCheckout', 'getBillingAddressInterface'),
		array('ModuleIsotopeCheckout', 'getShippingAddressInterface'),
	),
	'shipping' => array
	(
		array('ModuleIsotopeCheckout', 'getShippingModulesInterface'),
	),
	'payment' => array
	(
		array('ModuleIsotopeCheckout', 'getPaymentModulesInterface'),
	),
	'review' => array
	(
		array('ModuleIsotopeCheckout', 'getOrderReviewInterface'),
		array('ModuleIsotopeCheckout', 'getOrderConditionsInterface'),
	),
);

$GLOBALS['ISO_ATTR'] = array
(
	'text' => array
	(
		'sql'		=> "varchar(255) NOT NULL default ''",
	),
	'integer' => array
	(
		'frontend'	=> 'text',
		'backend'	=> 'text',
		'sql'		=> "int(10) NULL default NULL",
	),
	'decimal' => array
	(
		'frontend'	=> 'text',
		'backend'	=> 'text',
		'sql'		=> "double NULL default NULL",
	),
	'textarea' => array
	(
		'sql'		=> "text NULL",
	),
	'datetime' => array
	(
		'frontend'	=> 'text',
		'backend'	=> 'text',
		'sql'		=> "int(10) unsigned NOT NULL default '0'",
	),
	'select' => array
	(
		'backend'	=> 'optionDataWizard',
		'sql'		=> "blob NULL",
		'callback'	=> array(array('Isotope', 'mergeOptionData')),
	),
	'checkbox' => array
	(
		'sql'		=> "char(1) NOT NULL default ''",
	),
	'options' => array
	(
		'frontend'	=> 'radio',
		'backend'	=> 'radio',
		'sql'		=> "blob NULL",
	),
	'file' => array
	(
		'frontend'	=> 'mediaManager',
		'backend'	=> 'mediaManager',
		'sql'		=> "text NULL",
	),
	'media' => array
	(
		'frontend'	=> 'mediaManager',
		'backend'	=> 'mediaManager',
		'sql'		=> "blob NULL",
	),
);


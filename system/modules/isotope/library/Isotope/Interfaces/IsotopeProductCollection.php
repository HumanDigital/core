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

namespace Isotope\Interfaces;

use Isotope\Model\ProductCollectionItem;
use Isotope\Model\ProductCollectionSurcharge;


/**
 * IsotopeProductCollection interface defines an Isotope product collection
 */
interface IsotopeProductCollection
{

    /**
     * Return true if collection is locked
     *
     * @return bool
     */
    public function isLocked();

    /**
     * Return true if collection has no items
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Return number of items in the collection
     *
     * @return int
     */
    public function countItems();

    /**
     * Return summary of item quantity in collection
     *
     * @return int
     */
    public function sumItemsQuantity();

    /**
     * Delete all products in the collection
     */
    public function purge();

    /**
     * Lock collection from begin modified
     */
    public function lock();

    /**
     * Sum price of all items in the collection
     *
     * @return float
     */
    public function getSubtotal();

    /**
     * Sum total tax free price of all items in the collection
     *
     * @return float
     */
    public function getTaxFreeSubtotal();

    /**
     * Sum total price of items and surcharges
     *
     * @return float
     */
    public function getTotal();

    /**
     * Sum tax free total of items and surcharges
     *
     * @return float
     */
    public function getTaxFreeTotal();

    /**
     * Return the item with the latest timestamp (e.g. the latest added item)
     *
     * @return ProductCollectionItem|null
     */
    public function getLatestItem();

    /**
     * Return all items in the collection
     *
     * @param callable
     * @param bool
     *
     * @return \Isotope\Model\ProductCollectionItem[]
     */
    public function getItems($varCallable = null, $blnNoCache = false);

    /**
     * Search item for a specific product
     *
     * @param IsotopeProduct $objProduct
     *
     * @return ProductCollectionItem|null
     */
    public function getItemForProduct(IsotopeProduct $objProduct);

    /**
     * Check if a given product is already in the collection
     *
     * @param IsotopeProduct $objProduct
     * @param bool           $blnIdentical
     *
     * @return bool
     */
    public function hasProduct(IsotopeProduct $objProduct, $blnIdentical = true);

    /**
     * Add a product to the collection
     *
     * @param IsotopeProduct $objProduct
     * @param integer        $intQuantity
     * @param array          $arrConfig
     *
     * @return ProductCollectionItem
     */
    public function addProduct(IsotopeProduct $objProduct, $intQuantity, array $arrConfig = array());

    /**
     * Update a product collection item
     *
     * @param ProductCollectionItem $objItem The product object
     * @param array                 $arrSet  The property(ies) to adjust
     *
     * @return bool
     */
    public function updateItem(ProductCollectionItem $objItem, $arrSet);

    /**
     * Update product collection item with given ID
     *
     * @param int   $intId
     * @param array $arrSet
     *
     * @return bool
     */
    public function updateItemById($intId, $arrSet);

    /**
     * Remove item from collection
     *
     * @param ProductCollectionItem $objItem
     *
     * @return bool
     */
    public function deleteItem(ProductCollectionItem $objItem);

    /**
     * Remove item with given ID from collection
     *
     * @param int $intId
     *
     * @return bool
     */
    public function deleteItemById($intId);

    /**
     * Find surcharges for the current collection
     *
     * @return ProductCollectionSurcharge[]
     */
    public function getSurcharges();

    /**
     * Check if minimum order amount is reached
     *
     * @return bool
     */
    public function hasErrors();

    /**
     * Get error messages for the cart
     *
     * @return array
     */
    public function getErrors();
}

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

namespace Isotope\Model\Attribute;

use Isotope\Interfaces\IsotopeAttributeForVariants;
use Isotope\Interfaces\IsotopeAttributeWithOptions;
use Isotope\Interfaces\IsotopeProduct;
use Isotope\Model\Attribute;
use Isotope\Model\AttributeOption;
use Isotope\Model\Product;
use Isotope\Translation;

abstract class AbstractAttributeWithOptions extends Attribute implements IsotopeAttributeWithOptions
{
    /**
     * Cache product options for attribute
     * "false" as long as the cache is not built
     * @type \Isotope\Collection\AttributeOption|array
     */
    protected $varOptionsCache = false;

    /**
     * Return true if attribute can have prices
     *
     * @return bool
     */
    public function canHavePrices()
    {
        if ($this instanceof IsotopeAttributeForVariants && $this->isVariantOption()) {
            return false;
        }

        return in_array($this->field_name, Attribute::getPricedFields());
    }

    /**
     * Get options of attribute from database
     *
     * @param IsotopeProduct $objProduct
     *
     * @return array|mixed
     *
     * @throws \InvalidArgumentException when optionsSource=product but product is null
     * @throws \UnexpectedValueException for unknown optionsSource
     */
    public function getOptionsForWidget(IsotopeProduct $objProduct = null)
    {
        $arrOptions = array();

        switch ($this->optionsSource) {

            // @deprecated remove in Isotope 3.0
            case 'attribute':
                $options = deserialize($this->options);

                if (!empty($options) && is_array($options)) {
                    if ($this->isCustomerDefined()) {
                        // Build for a frontend widget

                        foreach ($options as $option) {
                            $option['label'] = Translation::get($option['label']);

                            $arrOptions[] = $option;
                        }
                    } else {
                        // Build for a backend widget

                        $group = '';

                        foreach ($options as $option) {
                            $option['label'] = Translation::get($option['label']);

                            if ($option['group']) {
                                $group = $option['label'];
                                continue;
                            }

                            if ($group != '') {
                                $arrOptions[$group][] = $option;
                            } else {
                                $arrOptions[] = $option;
                            }
                        }
                    }
                }
                break;

            case 'table':
                $objOptions = $this->getOptionsFromManager();

                if (null === $objOptions) {
                    $arrOptions = array();

                } elseif ($this->isCustomerDefined()) {
                    $arrOptions = $objOptions->getArrayForFrontendWidget($objProduct, (TL_MODE == 'FE'));

                } else {
                    $arrOptions = $objOptions->getArrayForBackendWidget();
                }
                break;

            case 'product':
                if ('FE' === TL_MODE && !($objProduct instanceof IsotopeProduct)) {
                    throw new \InvalidArgumentException(
                        'Must pass IsotopeProduct to Attribute::getOptions if optionsSource is "product"'
                    );
                }

                $objOptions = $this->getOptionsFromManager($objProduct);

                if (null === $objOptions) {
                    return array();

                } else {
                    return $objOptions->getArrayForFrontendWidget($objProduct, (TL_MODE == 'FE'));
                }

                break;

            default:
                throw new \UnexpectedValueException(
                    'Invalid options source "'.$this->optionsSource.'" for '.static::$strTable.'.'.$this->field_name
                );
        }

        // Variant options cannot have a default value (see #1546)
        if ($this->isVariantOption()) {
            foreach ($arrOptions as &$option) {
                $option['default'] = '';
            }
        }

        return $arrOptions;
    }

    /**
     * Get AttributeOption models for current attribute
     *
     * @param IsotopeProduct $objProduct
     *
     * @return \Isotope\Collection\AttributeOption
     *
     * @throws \InvalidArgumentException when optionsSource=product but product is null
     * @throws \UnexpectedValueException for unknown optionsSource
     */
    public function getOptionsFromManager(IsotopeProduct $objProduct = null)
    {
        switch ($this->optionsSource) {

            case 'table':
                if (false === $this->varOptionsCache) {
                    $this->varOptionsCache = AttributeOption::findByAttribute($this);
                }

                return $this->varOptionsCache;

            case 'product':
                /** @type IsotopeProduct|Product|Product\Standard $objProduct */
                if ('FE' === TL_MODE && !($objProduct instanceof IsotopeProduct)) {
                    throw new \InvalidArgumentException(
                        'Must pass IsotopeProduct to Attribute::getOptionsFromManager if optionsSource is "product"'
                    );

                }

                $productId = $objProduct->id;

                if ($objProduct->isVariant() && !in_array($this->field_name, $objProduct->getVariantAttributes())) {
                    $productId = $objProduct->getProductId();
                }

                if (!is_array($this->varOptionsCache)
                    || !array_key_exists($productId, $this->varOptionsCache)
                ) {
                    $this->varOptionsCache[$productId] = AttributeOption::findByProductAndAttribute(
                        $objProduct,
                        $this
                    );
                }

                return $this->varOptionsCache[$productId];

            default:
                throw new \UnexpectedValueException(
                    static::$strTable.'.'.$this->field_name . ' does not use options manager'
                );
        }
    }

    /**
     * Get options for the frontend product filter widget
     *
     * @param array $arrValues
     *
     * @return array
     */
    public function getOptionsForProductFilter(array $arrValues)
    {
        switch ($this->optionsSource) {

            // @deprecated remove in Isotope 3.0
            case 'attribute':
                $arrOptions = array();
                $options = deserialize($this->options);

                if (!empty($options) && is_array($options)) {
                    foreach ($options as $option) {
                        if (in_array($option['value'], $arrValues)) {
                            $option['label'] = Translation::get($option['label']);
                            $arrOptions[] = $option;
                        }
                    }
                }

                return $arrOptions;
                break;

            case 'foreignKey':
                list($table, $field) = explode('.', $this->foreignKey, 2);
                $result = \Database::getInstance()->execute("
                    SELECT id AS value, $field AS label
                    FROM $table
                    WHERE id IN (" . implode(',', $arrValues) . ")
                ");

                return $result->fetchAllAssoc();
                break;

            case 'table':
            case 'product':
                /** @type \Isotope\Collection\AttributeOption $objOptions */
                $objOptions = AttributeOption::findPublishedByIds($arrValues);

                return (null === $objOptions) ? array() : $objOptions->getArrayForFrontendWidget(null, false);
                break;

            default:
                throw new \UnexpectedValueException(
                    'Invalid options source "'.$this->optionsSource.'" for '.static::$strTable.'.'.$this->field_name
                );
        }
    }

    /**
     * Make sure array values are unserialized and CSV values are splitted.
     *
     * @param IsotopeProduct $product
     *
     * @return mixed
     */
    public function getValue(IsotopeProduct $product)
    {
        $value = parent::getValue($product);

        if ($this->multiple) {
            if ($this->optionsSource == 'table' || $this->optionsSource == 'foreignKey') {
                $value = explode(',', $value);
            } else {
                $value = deserialize($value);
            }
        }

        return $value;
    }


    /**
     * Adjust DCA field for this attribute
     *
     * @param array $arrData
     */
    public function saveToDCA(array &$arrData)
    {
        $this->fe_search = false;

        if ($this->isCustomerDefined() && $this->optionsSource == 'product') {
            $this->be_filter = false;
            $this->fe_filter = false;
        }

        if ($this->multiple && ($this->optionsSource == 'table' || $this->optionsSource == 'foreignKey')) {
            $this->csv = ',';
        }

        parent::saveToDCA($arrData);

        if (TL_MODE == 'BE') {
            if ($this->be_filter && \Input::get('act') == '') {
                $arrData['fields'][$this->field_name]['foreignKey'] = 'tl_iso_attribute_option.label';
            }

            if ($this->isCustomerDefined() && $this->optionsSource == 'product') {
                \Controller::loadDataContainer(static::$strTable);
                \System::loadLanguageFile(static::$strTable);

                $fieldTemplate = $GLOBALS['TL_DCA'][static::$strTable]['fields']['optionsTable'];
                unset($fieldTemplate['label']);

                $arrField = array_merge(
                    $arrData['fields'][$this->field_name],
                    $fieldTemplate
                );

                $arrField['attributes']['dynamic'] = true;
                $arrField['foreignKey'] = 'tl_iso_attribute_option.label';

                if (\Input::get('do') == 'iso_products') {
                    $arrField['eval']['whereCondition'] = "field_name='{$this->field_name}'";
                }

                $arrData['fields'][$this->field_name] = $arrField;
            }
        }
    }
}

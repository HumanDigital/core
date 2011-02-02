<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Winans Creative 2009, Intelligent Spark 2010, iserv.ch GmbH 2010
 * @author     Rebecca Jutzi <rebecca.jutzi@bluewin.ch>
 * @author     Simon Moos <cc@simonmoos.com>
 * @author     Cyril Ponce <cyril@contao.fr>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

$GLOBALS['TL_LANG']['tl_iso_orders']['order_id'][0] = 'ID de la commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['uniqid'][0] = 'ID unique';
$GLOBALS['TL_LANG']['tl_iso_orders']['status'][0] = 'Statut de la commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['status'][1] = 'Sélectionner le statut de cette commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['date_payed'][0] = 'Date de paiement';
$GLOBALS['TL_LANG']['tl_iso_orders']['date_payed'][1] = 'Saisir la date à laquelle la commande a été payée.';
$GLOBALS['TL_LANG']['tl_iso_orders']['date_shipped'][0] = 'Date de livraison';
$GLOBALS['TL_LANG']['tl_iso_orders']['date_shipped'][1] = 'Saisir la date à laquelle la commande a été livrée.';
$GLOBALS['TL_LANG']['tl_iso_orders']['date'][0] = 'Date';
$GLOBALS['TL_LANG']['tl_iso_orders']['shipping_address'][0] = 'Adresse de livraison';
$GLOBALS['TL_LANG']['tl_iso_orders']['billing_address'][0] = 'Adresse de facturation';
$GLOBALS['TL_LANG']['tl_iso_orders']['order_subtotal'][0] = 'Sous total';
$GLOBALS['TL_LANG']['tl_iso_orders']['order_tax'][0] = 'Coût des tases';
$GLOBALS['TL_LANG']['tl_iso_orders']['shippingTotal'][0] = 'Coût de la livrasion';
$GLOBALS['TL_LANG']['tl_iso_orders']['shipping_method'][0] = 'Mode de livraison';
$GLOBALS['TL_LANG']['tl_iso_orders']['surcharges'][0] = 'Surtaxes';
$GLOBALS['TL_LANG']['tl_iso_orders']['cc_num'][0] = 'Numéro de carte';
$GLOBALS['TL_LANG']['tl_iso_orders']['cc_num'][1] = 'Le numéro de la carte de paiement';
$GLOBALS['TL_LANG']['tl_iso_orders']['cc_cvv'][0] = 'Cryptogramme visuel';
$GLOBALS['TL_LANG']['tl_iso_orders']['cc_cvv'][1] = '3  ou 4 derniers chiffres présents au dos de la carte de paiement.';
$GLOBALS['TL_LANG']['tl_iso_orders']['cc_type'][0] = 'Type de carte';
$GLOBALS['TL_LANG']['tl_iso_orders']['cc_type'][1] = 'Le type de la carte de paiement.';
$GLOBALS['TL_LANG']['tl_iso_orders']['cc_exp'][0] = 'Expiration';
$GLOBALS['TL_LANG']['tl_iso_orders']['cc_exp'][1] = 'La date d\'expiration de la carte de paiement.';
$GLOBALS['TL_LANG']['tl_iso_orders']['notes'][0] = 'Informations sur la commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['notes'][1] = 'Permet de transmettre des informations à d\'autres utilisateurs du back office.';
$GLOBALS['TL_LANG']['tl_iso_orders']['shipping_method_labels']['ups_ground'] = 'UPS Ground';
$GLOBALS['TL_LANG']['tl_iso_orders']['opLabel'] = 'Nom de la surtaxe';
$GLOBALS['TL_LANG']['tl_iso_orders']['opPrice'] = 'Prix';
$GLOBALS['TL_LANG']['tl_iso_orders']['opTaxClass'] = 'Taxe';
$GLOBALS['TL_LANG']['tl_iso_orders']['opAddTax'] = 'Ajouter une taxe ?';
$GLOBALS['TL_LANG']['tl_iso_orders']['new'][0] = 'Nouvelle commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['new'][1] = 'Créer une nouvelle commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['edit'][0] = 'Éditer la commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['edit'][1] = 'Éditer la commande ID %s';
$GLOBALS['TL_LANG']['tl_iso_orders']['copy'][0] = 'Duppliquer la commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['copy'][1] = 'Duppliquer la commande ID %s';
$GLOBALS['TL_LANG']['tl_iso_orders']['delete'][0] = 'Supprimer la commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['delete'][1] = 'Supprimer la commande ID %s';
$GLOBALS['TL_LANG']['tl_iso_orders']['show'][0] = 'Afficher les détails de la commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['show'][1] = 'Afficher les détails de la commande ID %s';
$GLOBALS['TL_LANG']['tl_iso_orders']['edit_order'][0] = 'Éditer la commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['edit_order'][1] = 'Éditer les éléments de la commande, ajouter ou supprimer des produits.';
$GLOBALS['TL_LANG']['tl_iso_orders']['edit_order_items'][0] = 'Éditer les éléments de la commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['edit_order_items'][1] = 'Éditer les éléments de la commande ID %s';
$GLOBALS['TL_LANG']['tl_iso_orders']['print_order'][0] = 'Imprimer cette commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['print_order'][1] = 'Imprimer une facture pour la commande en cours';
$GLOBALS['TL_LANG']['tl_iso_orders']['tools'][0] = 'Outils';
$GLOBALS['TL_LANG']['tl_iso_orders']['tools'][1] = 'Plus d\'options pour la gestion des commandes.';
$GLOBALS['TL_LANG']['tl_iso_orders']['export_emails'][0] = 'Exporter les e-mails des commandes';
$GLOBALS['TL_LANG']['tl_iso_orders']['export_emails'][1] = 'Exporter les e-mails des personnes qui ont commandé.';
$GLOBALS['TL_LANG']['tl_iso_orders']['print_invoices'][0] = 'Impression des factures';
$GLOBALS['TL_LANG']['tl_iso_orders']['print_invoices'][1] = 'Imprimer une ou plusieurs factures dans un seul document pour un statut de commande définit.';
$GLOBALS['TL_LANG']['tl_iso_orders']['status_legend'] = 'Statut de la commande';
$GLOBALS['TL_LANG']['tl_iso_orders']['details_legend'] = 'Détails de la commande';


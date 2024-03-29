<?php
/* Copyright (C) 2014-2017		Charlie Benke	<charlie@patas-monkey.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 * or see http://www.gnu.org/
 */

/**
 *	\file	   htdocs/factory/core/modules/equipement/mod_arctic.php
 *	\ingroup	produit
 *	\brief	  File with Babouin numbering module for factory
 */
dol_include_once("/factory/core/modules/factory/modules_factory.php");

/**
 *	Class to manage numbering of equipement cards with rule Artic.
 */
class mod_babouin extends ModeleNumRefFactory
{
	var $version='dolibarr';		// 'development', 'experimental', 'dolibarr'
	var $error = '';
	var $nom = 'babouin';

	/**
	 *  Renvoi la description du modele de numerotation
	 *
	 *  @return	 string	  Texte descripif
	 */
	function info()
	{
		global $conf, $langs;

		$langs->load("factory@factory");

		$form = new Form($this->db);

		$texte = $langs->trans('GenericNumRefModelDesc')."<br>\n";
		$texte.= '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
		$texte.= '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
		$texte.= '<input type="hidden" name="action" value="updateMask">';
		$texte.= '<input type="hidden" name="maskconst" value="FACTORY_BABOUIN_MASK">';
		$texte.= '<table class="nobordernopadding" width="100%">';

		$tooltip=$langs->trans(
						"GenericMaskCodes", 
						$langs->transnoentities("FactoryCard"), 
						$langs->transnoentities("FactoryCard")
		);
		$tooltip.=$langs->trans("GenericMaskCodes2");
		$tooltip.=$langs->trans("GenericMaskCodes3");
		$tooltip.=$langs->trans(
						"GenericMaskCodes4a", 
						$langs->transnoentities("FactoryCard"), 
						$langs->transnoentities("FactoryCard")
		);
		$tooltip.=$langs->trans("GenericMaskCodes5");

		// Parametrage du prefix
		$texte.= '<tr><td>'.$langs->trans("Mask").':</td>';
		$texte.= '<td align="right">';
		$texte.= $form->textwithpicto(
						'<input type="text" class="flat" size="24" name="maskvalue" value="'.$conf->global->FACTORY_BABOUIN_MASK.'">', 
						$tooltip, 1, 1
		).'</td>';

		$texte.= '<td align="left" rowspan="2">&nbsp;';
		$texte.= '<input type="submit" class="button" value="'.$langs->trans("Modify").'" name="Button"></td>';

		$texte.= '</tr>';

		$texte.= '</table>';
		$texte.= '</form>';

		return $texte;
	}

	/**
	 * Renvoi un exemple de numerotation
	 *
	 * @return	 string	  Example
	 */
	function getExample()
	{
		global $langs, $mysoc;

		$old_code_client=$mysoc->code_client;
		$mysoc->code_client='CCCCCCCCCC';
		$numExample = $this->getNextValue($mysoc, '');
		$mysoc->code_client=$old_code_client;

		if (! $numExample)
			$numExample = $langs->trans('NotConfigured');

		return $numExample;
	}

	/**
	 * 	Return next free value
	 *
	 *  @param	Societe		$objsoc	 Object thirdparty
	 *  @param  Object		$object		Object we need next value for
	 *  @return string	  			Value if KO, <0 if KO
	 */
	function getNextValue($objsoc=0, $object='')
	{
		global $db, $conf;

		require_once(DOL_DOCUMENT_ROOT ."/core/lib/functions2.lib.php");

		// On défini critere recherche compteur
		$mask=$conf->global->FACTORY_BABOUIN_MASK;

		if (! $mask) {
			$this->error='NotConfigured';
			return 0;
		}

		$numFinal=get_next_value($db, $mask, 'factory', 'ref', '', $objsoc->code_client, $object->date);

		return  $numFinal;
	}

	/**
	* 	Return next free value
	*
	*  @param	Societe		$objsoc	 Object third party
	* 	@param	Object		$objforref	Object for number to search
	*  @return string	  			Next free value
	*/
	function getNumRef($objsoc, $objforref)
	{
		return $this->getNextValue($objsoc, $objforref);
	}
}
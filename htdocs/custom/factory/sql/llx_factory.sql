-- --------------------------------------------------------

--
-- Structure de la table `llx_factory`
--

CREATE TABLE 		llx_factory (
  rowid 			integer 	PRIMARY KEY NOT NULL AUTO_INCREMENT,
  ref				varchar(30) NOT NULL,		-- numéro de série interne de l'OF
  fk_product 		integer 	NOT NULL DEFAULT 0,
  fk_entrepot		integer 	NOT NULL,
  description		text,
  tms				timestamp,
  date_start_planned datetime	DEFAULT NULL,		-- date de début de fabrication prévue
  date_start_made 	datetime	DEFAULT NULL,		-- date de d�but de fabrication r�elle
  date_end_planned	datetime	DEFAULT NULL,		-- date de fin de fabrication pr�vue
  date_end_made		datetime	DEFAULT NULL,		-- date de fin de fabrication r�elle
  duration_planned	double 		DEFAULT NULL,		-- dur�e estim� de la fabrication
  duration_made		double 		DEFAULT NULL,		-- dur�e r�elle de la fabrication
  qty_planned		double 		DEFAULT NULL,		-- quantit� de produit � fabriquer
  qty_made			double 		DEFAULT NULL,		-- quantit� de produit r�ellement fabriqu�
  note_public		text,
  note_private		text,
  entity			integer DEFAULT 1 NOT NULL,		-- FUCKIN multi company id
  fk_user_author	integer,						-- createur de la fiche
  fk_user_modif		integer,						-- createur de la fiche
  fk_user_valid		integer,						-- valideur de la fiche (lancement de la production)
  fk_user_close		integer,						-- clotureur de la fiche (saisie du rapport)
  model_pdf			varchar(255),
  import_key		VARCHAR( 14 ) NULL DEFAULT NULL,
  extraparams		varchar(255),				-- for stock other parameters with json format
  fk_statut			smallint DEFAULT 0		
) ENGINE=InnoDB ;
	-- 0 = demande de lancement, 1 = en cours de production, 2 = terminé

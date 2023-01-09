ALTER TABLE exercises
add COLUMN (
  `enableInlineAd` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_unicode_ci'
);

ALTER TABLE exercises
add COLUMN (
	`adCount` INT(11) NULL DEFAULT '0'
);

ALTER TABLE exercises
add COLUMN (
	`enableBelowExerciseAd` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_unicode_ci'
);

ALTER TABLE exercises
add COLUMN (
	`enableEmailMarketing` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_unicode_ci'
);

ALTER TABLE exercises
add COLUMN (
	`subscriptionCount` INT(11) NULL DEFAULT '0'
);

ALTER TABLE codes MODIFY code_value varchar(1000) COLLATE utf8_unicode_ci NOT NULL;
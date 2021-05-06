#
# Table structure for table 'tx_spldomain_domain_model_variabletext'
#
CREATE TABLE tx_bpnvariabletext_domain_model_variabletext
(
	uid             int(11)                 NOT NULL auto_increment,
	pid             int(11)      DEFAULT 0  NOT NULL,
	tstamp          int(11)      DEFAULT 0  NOT NULL,
	crdate          int(11)      DEFAULT 0  NOT NULL,
	cruser_id       int(11)      DEFAULT 0  NOT NULL,
	deleted         tinyint(4)   DEFAULT 0  NOT NULL,
	hidden          tinyint(4)   DEFAULT 0  NOT NULL,

	text_formatting int(11)      DEFAULT 0  NOT NULL,
	label_name      varchar(255) DEFAULT '' NOT NULL,
	plaintext       text                    NOT NULL,
	html            text                    NOT NULL,
	description     text                    NOT NULL,
	markers         text                    NOT NULL,

	PRIMARY KEY (uid),
	KEY label (label_name),
	KEY parent (pid)
);
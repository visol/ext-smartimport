#
# Table structure for table 'tx_smartimport_domain_model_entity'
#
CREATE TABLE tx_smartimport_domain_model_entity (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

  source_unique_identifier varchar(255) DEFAULT '' NOT NULL,
  source_field_hashes mediumtext,
  internal_uid int(11) NOT NULL,
  internal_pid int(11) NOT NULL,
  internal_entity_classname varchar(255) DEFAULT '' NOT NULL,
  internal_language int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
);

#
# Table structure for table 'tx_smartimport_domain_model_ressource'
#
CREATE TABLE tx_smartimport_domain_model_ressource (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

  url mediumtext,
  last_modified int(11) unsigned DEFAULT '0' NOT NULL,
  etag mediumtext,
  expires int(11) unsigned DEFAULT '0' NOT NULL,
  sha1 mediumtext,
  file int(11) NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
);
#
# Table structure for table 'tx_bwregistration_domain_model_registration'
#
CREATE TABLE tx_bwregistration_domain_model_registration (
    persons int(11) unsigned DEFAULT '0' NOT NULL,
    hash varchar(255) DEFAULT '' NOT NULL,
    attended tinyint DEFAULT '0' NOT NULL,
    attended_time datetime DEFAULT null,
    event int(11) unsigned DEFAULT '0' NOT NULL,
    slot int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_bwregistration_domain_model_person'
#
CREATE TABLE tx_bwregistration_domain_model_person (
    first_name varchar(255) DEFAULT '' NOT NULL,
    last_name varchar(255) DEFAULT '' NOT NULL,
    street_and_number varchar(255) DEFAULT '' NOT NULL,
    town varchar(255) DEFAULT '' NOT NULL,
    zip varchar(5) DEFAULT '' NOT NULL,
    phone varchar(255) DEFAULT '' NOT NULL,
    email varchar(255) DEFAULT '' NOT NULL,
    registration int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_bwregistration_domain_model_slot'
#
CREATE TABLE tx_bwregistration_domain_model_slot (
    begin_datetime DATETIME DEFAULT NULL,
    end_datetime DATETIME DEFAULT NULL,
    max_persons int(11) unsigned DEFAULT '0' NOT NULL,
    max_registrations int(11) unsigned DEFAULT '0' NOT NULL,
    event int(11) unsigned DEFAULT '0' NOT NULL,
    registrations int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_bwregistration_domain_model_event'
#
CREATE TABLE tx_bwregistration_domain_model_event (
    name varchar(255) DEFAULT '' NOT NULL,
    registrations int(11) unsigned DEFAULT '0' NOT NULL,
    slots int(11) unsigned DEFAULT '0' NOT NULL,
    persons_per_registration int(11) DEFAULT '0' NOT NULL,
);
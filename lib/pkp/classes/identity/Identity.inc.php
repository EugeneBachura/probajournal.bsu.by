<?php

/**
 * @defgroup identity Identity
 * Implements an abstract identity underlying e.g. User and Author records.
 */

/**
 * @file classes/identity/Identity.inc.php
 *
 * Copyright (c) 2014-2017 Simon Fraser University
 * Copyright (c) 2000-2017 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Identity
 * @ingroup identity
 *
 * @brief Basic class providing common functionality for users and authors in the system.
 */

class Identity extends DataObject {

	/**
	 * Get the identity's localized complete name.
	 * Includes first name, middle name (if applicable), and last name.
	 * @param $lastFirst boolean False / default: Firstname Middle Lastname
	 * 	If true: Lastname, Firstname Middlename
	 * @return string
	 */
	function getFullName($lastFirst = false) {
		$salutation = $this->getData('salutation');
		$firstName = $this->getLocalizedData('firstName');
		$middleName = $this->getLocalizedData('middleName');
		$lastName = $this->getLocalizedData('lastName');
		$suffix = $this->getData('suffix');
		if ($lastFirst) {
			return "$lastName, " . ($salutation != ''?"$salutation ":'') . $firstName . ($middleName != ''?" $middleName":'');
		} else {
			return ($salutation != ''?"$salutation ":'') . "$firstName " . ($middleName != ''?"$middleName ":'') . $lastName . ($suffix != ''?", $suffix":'');
		}
	}


	/**
	 * Get first name.
	 * @param $locale string
	 * @return string
	 */
	function getFirstName($locale) {
		return $this->getData('firstName', $locale);
	}

	/**
 	 * Get first name.
 	 * @return string
 	 */
	function getLocalizedFirstName() {
		return $this->getLocalizedData('firstName');
 	}
	 
	/**
	 * Set first name.
	 * @param $firstName string
	 * @param $locale string
	 */
	function setFirstName($firstName, $locale) {
		$this->setData('firstName', $firstName, $locale);
	}

	/**
	 * Get middle name.
	 * @param $locale string
	 * @return string
	 */
	function getMiddleName($locale) {
		return $this->getData('middleName', $locale);
	}

	/**
	 * Get middle name.
	 * @return string
	 */
	function getLocalizedMiddleName() {
		return $this->getLocalizedData('middleName');
 	}

	/**
	 * Set middle name.
	 * @param $middleName string
	 * @param $locale string
	 */
	function setMiddleName($middleName, $locale) {
		$this->setData('middleName', $middleName, $locale);
	}

	/**
	 * Get last name.
	 * @param $locale string
	 * @return string
	 */
	function getLastName($locale) {
		return $this->getData('lastName', $locale);
	}

	/**
	 * Get last name.
	 * @return string
	 */
	 function getLocalizedLastName() {
		return $this->getLocalizedData('lastName');
 	}
	
	/**
	 * Set last name.
	 * @param $lastName string
	 * @param $locale string
	 */
	function setLastName($lastName, $locale) {
		$this->setData('lastName', $lastName, $locale);
	}

	/**
	 * Get initials.
	 * @return string
	 */
	function getInitials() {
		$initials = $this->getData('initials');
		if (!$initials) {
			$initials = PKPString::substr($this->getFirstName(), 0, 1) . PKPString::substr($this->getLastName(), 0, 1);
		}
		return $initials;
	}

	/**
	 * Set initials.
	 * @param $initials string
	 */
	function setInitials($initials) {
		$this->setData('initials', $initials);
	}

	/**
	 * Get user salutation.
	 * @return string
	 */
	function getSalutation() {
		return $this->getData('salutation');
	}

	/**
	 * Set user salutation.
	 * @param $salutation string
	 */
	function setSalutation($salutation) {
		$this->setData('salutation', $salutation);
	}

	/**
	 * Get affiliation (position, institution, etc.).
	 * @param $locale string
	 * @return string
	 */
	function getAffiliation($locale) {
		return $this->getData('affiliation', $locale);
	}

	/**
	 * Set affiliation.
	 * @param $affiliation string
	 * @param $locale string
	 */
	function setAffiliation($affiliation, $locale) {
		$this->setData('affiliation', $affiliation, $locale);
	}

	/**
	 * Get the localized affiliation for this author
	 */
	function getLocalizedAffiliation() {
		return $this->getLocalizedData('affiliation');
	}

	/**
	 * Get email address.
	 * @return string
	 */
	function getEmail() {
		return $this->getData('email');
	}

	/**
	 * Set email address.
	 * @param $email string
	 */
	function setEmail($email) {
		$this->setData('email', $email);
	}

	/**
	 * Get ORCID identifier
	 * @return string
	 */
	function getOrcid() {
		return $this->getData('orcid');
	}

	/**
	 * Set ORCID identifier.
	 * @param $orcid string
	 */
	function setOrcid($orcid) {
		$this->setData('orcid', $orcid);
	}

	/**
	 * Get name suffix.
	 * @return string
	 */
	function getSuffix() {
		return $this->getData('suffix');
	}

	/**
	 * Set suffix.
	 * @param $suffix string
	 */
	function setSuffix($suffix) {
		$this->setData('suffix', $suffix);
	}

	/**
	 * Get country code (ISO 3166-1 two-letter codes)
	 * @return string
	 */
	function getCountry() {
		return $this->getData('country');
	}

	/**
	 * Get localized country
	 * @return string
	 */
	function getCountryLocalized() {
		$countryDao = DAORegistry::getDAO('CountryDAO');
		$country = $this->getCountry();
		if ($country) {
			return $countryDao->getCountry($country);
		}
		return null;
	}

	/**
	 * Set country code (ISO 3166-1 two-letter codes)
	 * @param $country string
	 */
	function setCountry($country) {
		$this->setData('country', $country);
	}

	/**
	 * Get URL.
	 * @return string
	 */
	function getUrl() {
		return $this->getData('url');
	}

	/**
	 * Set URL.
	 * @param $url string
	 */
	function setUrl($url) {
		$this->setData('url', $url);
	}

	/**
	 * Get the localized biography for this author
	 * @return string
	 */
	function getLocalizedBiography() {
		return $this->getLocalizedData('biography');
	}

	/**
	 * Get author biography.
	 * @param $locale string
	 * @return string
	 */
	function getBiography($locale) {
		return $this->getData('biography', $locale);
	}

	/**
	 * Set author biography.
	 * @param $biography string
	 * @param $locale string
	 */
	function setBiography($biography, $locale) {
		$this->setData('biography', $biography, $locale);
	}
}

?>

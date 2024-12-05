<?php

class ConsentCheckboxField extends CheckboxField {

	protected $consentIDFieldName = 'Email';
	protected $consentType = 'Undefined';

	public function __construct($name, $title = null, $value = null) {
		$this->setConsentType($name);
		parent::__construct($name, $title, $value);
	}
	public function Type() {
		return 'checkbox';
	}
	public function setConsentIDFieldName($consentIDFieldName) {
		$this->consentIDFieldName = $consentIDFieldName;
		return $this;
	}
	public function getConsentIDFieldName() {
		return $this->consentIDFieldName;
	}
	public function getConsentType() {
		return $this->consentType;
	}
	public function setConsentType($consentType) {
		$this->consentType = $consentType;
		return $this;
	}
	public function Required() {
		if($this->form && ($validator = $this->form->Validator)) {
			$validator->addRequiredField($this->name);
		}
		return true;
	}
	public function getCustomValidationMessage() {
		return ($this->customValidationMessage) ? $this->customValidationMessage : _t('ConsentCheckboxField.CONSENTERRORMESSAGE', 'Please give consent to handle your private data');
	}
}
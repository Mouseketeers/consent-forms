<?php

class EditableConsentCheckbox extends EditableFormField {
	
	private static $singular_name = 'Consent Checkbox Field';
	
	private static $plural_name = 'Consent Checkboxes';
	
	static $icon = 'user-consent/images/editableconsentcheckbox.png';

	public function getFieldConfiguration() {
		// $options = parent::getFieldConfiguration();

		$fields = new FieldList();

		$consentID     = $this->getSetting('ConsentID');
		$otherFields = $this->Parent()->Fields();

		$otherFields = $otherFields->map('Name', 'Title')->toArray();
		$pre = "Fields[$this->ID][CustomSettings]";

		$fields->push(
			DropdownField::create("{$pre}[ConsentID]", _t('EditableFormField.ConsentID', 'Consent ID'), $otherFields, $consentID)->setRightTitle('Consent ID is typically an e-mail address')
		);
		return $fields;
	}	
	public function getFormField() {

		$consentID = $this->getSetting('ConsentID');

		$field = ConsentCheckboxField::create( $this->Name, $this->Title)
			->setConsentIDFieldName($consentID)
			->setConsentType('Contact Form');
		$errorMessage = $this->getErrorMessage()->HTML();
		$field->setAttribute('data-rule-required', 'true');
		$field->setAttribute('data-msg-required', $errorMessage);
		
		return $field;
	}
	public function getFieldValidationOptions() {
		$fields = new FieldList(
			new TextField($this->getFieldName('CustomErrorMessage'), _t('EditableFormField.CUSTOMERROR','Custom Error Message'), $this->CustomErrorMessage)
		);
		return $fields;
	}
	public function getIcon() {
		return  self::$icon;
	}	
}
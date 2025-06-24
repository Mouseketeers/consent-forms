<?php

class EditableConsentCheckbox extends EditableFormField {
	
	private static $singular_name = 'Consent Checkbox Field';
	
	private static $plural_name = 'Consent Checkboxes';
	
	static $icon = 'consent-forms/images/editableconsentcheckbox.png';

	public function getFieldConfiguration() {

		$fields = new FieldList();

		$consentID     = $this->getSetting('ConsentID');
		$otherFields = $this->Parent()->Fields();

		$otherFields = $otherFields->map('Name', 'Title')->toArray();
		$pre = "Fields[$this->ID][CustomSettings]";

		$fields->push(
			DropdownField::create("{$pre}[ConsentID]", _t('EditableConsentCheckbox.ConsentID', 'Consent ID'), $otherFields, $consentID)->setRightTitle('Consent ID is typically an e-mail address')
		);
		return $fields;
	}	
	public function getFormField() {
		
		$consentID = $this->getSetting('ConsentID');
		
		$field = ConsentCheckboxField::create( $this->Name, $this->Title)
			->setConsentIDFieldName($consentID)
			->setConsentType('ContactForm');
		
		$errorMessage = ($this->getErrorMessage()) ? $this->getErrorMessage() : $field->getCustomValidationMessage();
		$field->setAttribute('data-rule-required', 'true');
		$field->setAttribute('data-msg-required', $errorMessage);
		
		return $field;
	}
	public function getErrorMessage() {
        return DBField::create_field('Varchar', $this->CustomErrorMessage);
	}
	public function getIcon() {
		return  self::$icon;
	}	
}
<?php

class EditableTermsAndPrivacyConsentCheckbox extends EditableConsentCheckbox {
	
	private static $singular_name = 'Terms and Privacy Consent Checkbox Field';
	private static $plural_name = 'Terms and Privacy Consent Checkbox Fields';
	
	static $icon = 'consent-forms/images/editableconsentcheckbox.png';

    public function populateDefaults() {
        parent::populateDefaults();
        $this->Title = self::$singular_name;
    }

	public function getFieldConfiguration() {

		$fields = new FieldList();

		$consentID     = $this->getSetting('ConsentID');
		$otherFields = $this->Parent()->Fields();

		$otherFields = $otherFields->map('Name', 'Title')->toArray();
		$pre = "Fields[$this->ID][CustomSettings]";

		$fields->push(
			DropdownField::create("{$pre}[ConsentID]", _t('EditableTermsAndPrivacyConsentCheckbox.ConsentID', 'Consent ID'), $otherFields, $consentID)->setRightTitle('Consent ID is typically an e-mail address')
		);
		return $fields;
	}	
	public function getFormField() {
		
		$consentID = $this->getSetting('ConsentID');
		
		$field = TermsAndPrivacyConsentCheckboxField::create($this->Name)
			->setConsentIDFieldName($consentID);
		
		$errorMessage = ($this->getErrorMessage()) ? $this->getErrorMessage() : $field->getCustomValidationMessage();
		$field->setAttribute('data-rule-required', 'true');
		$field->setAttribute('data-msg-required', $errorMessage);
		
		return $field;
	}
}
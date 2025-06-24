<?php

class EditableTermsAndPrivacyConsentCheckbox extends EditableFormField {
	
	private static $singular_name = 'Terms and Privacy Consent Checkbox Field';
	
	private static $plural_name = 'Terms and Privacy Consent Checkbox Fields';
	
	static $icon = 'consent-forms/images/editableconsentcheckbox.png';

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

        $siteConfig = SiteConfig::current_site_config();

        if ($siteConfig->TermsPageID) {
            $terms = '<a href="' . $siteConfig->TermsPage()->Link() . '" target="_blank" class="legal-page-link">'
                . $siteConfig->TermsPage()->MenuTitle . '</a>';
        } else {
            $terms = _t('EditableTermsAndPrivacyConsentCheckbox.Terms', 'Terms of Service');
        }

        if ($siteConfig->PrivacyPageID) {
            $privacy = '<a href="' . $siteConfig->PrivacyPage()->Link() . '" target="_blank" class="legal-page-link">'
                . $siteConfig->PrivacyPage()->MenuTitle . '</a>';
        } else {
            $privacy = _t('EditableTermsAndPrivacyConsentCheckbox.PrivacyPolicy', 'Privacy Policy');
        }

        $title = _t(
            'EditableTermsAndPrivacyConsentCheckbox.ConsentStatement',
            'I agree to the {terms} and have read the {privacypolicy}',
            [
                'terms' => $terms,
                'privacypolicy' => $privacy
            ]
        );
		
		$field = ConsentCheckboxField::create($this->Name, $title)
			->setConsentIDFieldName($consentID)
			->setConsentType('TermsAndPrivacyConsent');
		
		$errorMessage = ($this->getErrorMessage()) ? $this->getErrorMessage() : $field->getCustomValidationMessage();
		$field->setAttribute('data-rule-required', 'true');
		$field->setAttribute('data-msg-required', $errorMessage);
		
		return $field;
	}
	public function getIcon() {
		return  self::$icon;
	}
	public function getErrorMessage() {
		return DBField::create_field('Varchar', $this->CustomErrorMessage);
	}
}
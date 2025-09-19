<?php

class EditablePrivacyTextField extends EditableConsentCheckbox {
	
	private static $singular_name = 'Privacy Text Field';
	
	private static $plural_name = 'Privacy Text Fields';
	
	static $icon = 'consent-forms/images/editableconsentcheckbox.png';
	
    public function populateDefaults() {
        parent::populateDefaults();
        $this->Title = self::$singular_name;
    }
	
	public function getFormField() {

        $siteConfig = SiteConfig::current_site_config();

        if($siteConfig->PrivacyPageID) {
            $privacy = '<a href="' . $siteConfig->PrivacyPage()->Link() . '" target="_blank" class="legal-page-link">'
                . $siteConfig->PrivacyPage()->MenuTitle . '</a>';
        } else {
            $privacy = _t('EditablePrivacyTextField.PrivacyPolicy', 'Privacy Policy');
        }

        $title = _t(
            'EditablePrivacyTextField.ImpliedAgreement',
            'We use the information you provide exclusively to handle your inquiry. For further details, please refer to our {privacypolicy}.',
            ['privacypolicy' => $privacy]
        );
		
		$field = LiteralField::create($this->Name, '<div class="field">' . $title  . '</div>'	);
		
		return $field;
	}
}
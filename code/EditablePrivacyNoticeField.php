<?php

class EditablePrivacyNoticeField extends EditableFormField {
	
	private static $singular_name = 'Privacy Text Field';
	private static $plural_name = 'Privacy Text Fields';
	
	static $icon = 'consent-forms/images/editableconsentcheckbox.png';
	
    public function populateDefaults() {
        parent::populateDefaults();
        $this->Title = self::$singular_name;
    }
	
	public function getFormField() {

        $siteConfig = SiteConfig::current_site_config();


        $privacyPolicyReferenceText = '';

        $privacyPage = $siteConfig->PrivacyPageID ? $siteConfig->PrivacyPage() : null;

        if($privacyPage) {
            $privacyLink = '<a href="' . $privacyPage->Link() . '" target="_blank" class="legal-page-link">' . $privacyPage->MenuTitle . '</a>';
            $privacyPolicyReferenceText = _t(
                'EditablePrivacyNoticeField.PrivacyPolicyReferenceText',
                'For further details, please refer to our {privacypolicy}.',
                ['privacypolicy' => $privacyLink]
            );
        }     

        $label = _t(
            'EditablePrivacyNoticeField.ImpliedAgreementText',
            'We use the information you provide exclusively to handle your inquiry.',
        );

        $label .= ' ' . $privacyPolicyReferenceText;
		
		$field = LiteralField::create($this->Name, '<div class="field">' . $label  . '</div>'	);
		
		return $field;
	}
}
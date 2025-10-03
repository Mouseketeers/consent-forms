<?php

class TermsAndPrivacyConsentCheckboxField extends ConsentCheckboxField {

    protected $consentType = 'TermsAndPrivacyConsent';

	public function __construct($name = null, $title = null, $value = null) {
        $name = $name ?: $this->consentType;
        $title = $title ?: $this->getTitle();
		parent::__construct($name, $title, $value);
	}
    
    public function getTitle() {
        $siteConfig = SiteConfig::current_site_config();
        
        $termsPage = $siteConfig->TermsPageID ? $siteConfig->TermsPage() : null;
        $privacyPage = $siteConfig->PrivacyPageID ? $siteConfig->PrivacyPage() : null;
        
        if ($termsPage) {
            $terms = '<a href="' . $termsPage->Link() . '" target="_blank" class="legal-page-link">'
                . $termsPage->MenuTitle . '</a>';
        } else {
            $terms = _t('TermsAndPrivacyConsentCheckboxField.Terms', 'Terms of Service');
        }

        if ($privacyPage) {
            $privacy = '<a href="' . $privacyPage->Link() . '" target="_blank" class="legal-page-link">'
                . $privacyPage->MenuTitle . '</a>';
        } else {
            $privacy = _t('TermsAndPrivacyConsentCheckboxField.PrivacyPolicy', 'Privacy Policy');
        }
        
        return _t(
            'TermsAndPrivacyConsentCheckboxField.ConsentStatement',
            [
                'terms' => $terms,
                'privacypolicy' => $privacy
            ]
        );
    }
}
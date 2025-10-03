<?php

class PrivacyNoticeField extends LiteralField {


	public function __construct($name = null, $title = null, $value = null) {
        $title = $title ?: $this->getTitle();
		parent::__construct($name, $title, $value);
	}
    
    public function getTitle() {
        $siteConfig = SiteConfig::current_site_config();
        $privacyPage = $siteConfig->PrivacyPageID ? $siteConfig->PrivacyPage() : null;
        
        $baseText = _t(
            'PrivacyNoticeField.ImpliedAgreement'
        );
        
        $fullText = $baseText;
        
        if ($privacyPage) {
            $privacyLink = sprintf(
                '<a href="%s" target="_blank" class="legal-page-link">%s</a>',
                $privacyPage->Link(),
                $privacyPage->MenuTitle
            );
            
            $privacyText = _t(
                'PrivacyNoticeField.PrivacyPolicyReference',
                ['privacypolicy' => $privacyLink]
            );
            
            $fullText .= ' ' . $privacyText;
        }
        
        return '<div class="field">' . $fullText . '</div>';
    }
}
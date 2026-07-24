<?php

namespace Mouseketeers\ConsentForms;

use SilverStripe\UserForms\Model\EditableFormField;


class EditablePrivacyNoticeField extends EditableFormField {

	private static $table_name = 'EditablePrivacyNoticeField';

	private static $singular_name = 'Privacy Notice';

	private static $plural_name = 'Privacy Notices';

	static $icon = 'consent-forms/images/privacy.png';

	public function populateDefaults() {
		parent::populateDefaults();
		$this->Title = self::$singular_name;
	}

	public function getFormField() {
		return PrivacyNoticeField::create($this->Name);
	}
}

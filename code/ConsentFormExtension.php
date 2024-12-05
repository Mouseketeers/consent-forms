<?php 
class ConsentFormExtension extends Extension {

	private static $ignoredFields = array(
		'ConsentCheckboxField',
		'HiddenField',
		'BackURL',
		'PasswordField',
		'ConfirmedPasswordField',
		'ReadonlyField'
	);
	public function afterCallActionHandler($request, $action) {

		$form = $this->owner;

		if($form->validator && $form->validator->getErrors()) return;

		$fields = $form->Fields();
		
		$consentFields = [];

		foreach($fields as $field) {
			if($field->class == 'ConsentCheckboxField' && $field->value == 1) {
				$consentFields[] = $field;
			}
		}
		if(!$consentFields) return;

		$formData = [];
		
		foreach($fields as $field) {
			if(in_array($field->class, self::$ignoredFields)) {
				continue;
			}
			$key = ($field->title) ? $field->title : $field->name;
			$value = $field->dataValue();
			if($value) {
				$formData[] = $key . ': ' . $value;	
			}
		}

		foreach($consentFields as $consentField) {
			$consentIDFieldName = $consentField->getConsentIDFieldName();
			$consentIDField = $fields->fieldByName($consentIDFieldName);
			$consentType = $consentField->getConsentType();
			
			$consentRecord = new ConsentRecord();
			$consentRecord->ConsentID = $consentIDField->dataValue();
			$consentRecord->ConsentType = $consentType;
			$consentRecord->URL = $form->request->getHeader('Referer');
			$consentRecord->ConsentStatement = $consentField->title;
			$consentRecord->ConsentData = implode(', ', $formData);

			$consentRecord->write();
		}
	}	
}

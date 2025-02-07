<?php

namespace Mouseketeers\ConsentForms;

use SilverStripe\Core\Extension;
use Mouseketeers\ConsentRecords\ConsentRecord;
use Mouseketeers\ConsentForms\EditableConsentCheckbox;

 
class ConsentFormExtension extends Extension {

	public function afterCallActionHandler($request, $action, $actionRes) {

		if($action == 'Form') {

			$form = $this->owner;
			
			if($form->validator && $form->validator->getErrors()) return;

			$vars = $request->postVars();
			$fields = $form->Fields();

			$consentFields = [];
			$formData = [];

			foreach($fields as $field) 
			{
				if($field->ClassName == EditableConsentCheckbox::class && $vars[$field->Name] == 1)
				{
					$consentFields[] = $field->getFormField();
				}
				else 
				{
					$key = ($field->title) ? $field->title : $field->name;
					if(isset($vars[$field->Name])) {
						$formData[] = $key . ': ' . $vars[$field->Name];	
					}					
				}
			}
			foreach($consentFields as $consentField) 
			{
				$consentRecord = new ConsentRecord();
				$consentRecord->ConsentID = $vars[$consentField->getConsentIDFieldName()];
				$consentRecord->ConsentType = $consentField->getConsentType();
				$consentRecord->URL = $form->request->getHeader('Referer');
				$consentRecord->ConsentStatement = $consentField->title;
				$consentRecord->ConsentData = implode(', ', $formData);
				$consentRecord->write();
			}
		}
	}	
}

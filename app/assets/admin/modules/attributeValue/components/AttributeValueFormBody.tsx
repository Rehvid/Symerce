import { hasAnyFieldError } from '@admin/shared/utils/formUtils';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import InputField from '@admin/shared/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/utils/validationRules';
import React from 'react';
import FormSection from '@admin/shared/components/form/FormSection';

const AttributeValueFormBody = ({register, fieldErrors}) => (
  <FormSection title="Informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>

    <FormGroup
      label={<InputLabel isRequired={true} label="Wartość" htmlFor="value"  />}
    >
      <InputField
        type="text"
        id="name"
        hasError={!!fieldErrors?.value}
        errorMessage={fieldErrors?.value?.message}
        icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
        {...register('value', {
          ...validationRules.required(),
          ...validationRules.minLength(2),
        })}
      />
    </FormGroup>
  </FormSection>
)

export default AttributeValueFormBody;

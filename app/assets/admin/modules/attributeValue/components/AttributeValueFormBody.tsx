import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';

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

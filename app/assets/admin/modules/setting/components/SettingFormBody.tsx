import { Control, FieldErrors, UseFormRegister, UseFormSetValue, UseFormWatch } from 'react-hook-form';
import { FormContextInterface } from '@admin/shared/interfaces/FormContextInterface';
import { SettingFormDataInterface } from '@admin/modules/setting/interfaces/SettingFormDataInterface';
import React from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import { hasAnyFieldError } from '@admin/shared/utils/formUtils';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import InputField from '@admin/shared/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/utils/validationRules';
import Description from '@admin/shared/components/Description';
import Switch from '@admin/shared/components/form/input/Switch';
import SettingValueInputType from '@admin/modules/setting/components/SettingValueInputType';


interface SettingFormBodyProps {
  register: UseFormRegister<SettingFormDataInterface>;
  control: Control<SettingFormDataInterface>;
  watch: UseFormWatch<SettingFormDataInterface>;
  setValue: UseFormSetValue<SettingFormDataInterface>;
  fieldErrors: FieldErrors<SettingFormDataInterface>;
  formData?: SettingFormDataInterface;
  formContext?: FormContextInterface;
}

const SettingFormBody: React.FC<SettingFormBodyProps> = ({
 register,
 control,
 watch,
 setValue,
 fieldErrors,
 formData,
 formContext
}) => {
  return (
    <FormSection title="Informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>
      <FormGroup
        label={<InputLabel isRequired={true} label="Nazwa" htmlFor="name"  />}
        description={<Description>Wartość wyświetlana tylko w panelu administracyjnym</Description>}
      >
        <InputField
          type="text"
          id="name"
          hasError={!!fieldErrors?.name}
          errorMessage={fieldErrors?.name?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('name', {
            ...validationRules.required(),
            ...validationRules.minLength(3),
          })}
        />
      </FormGroup>
      <FormGroup label={<InputLabel label="Wartość" />} >
        <SettingValueInputType register={register} fieldErrors={fieldErrors} control={control} formData={formData} />
      </FormGroup>
      <FormGroup label={ <InputLabel label="Czy jest aktywne?" /> }>
        <Switch {...register('isActive')} />
      </FormGroup>
    </FormSection>
  )
  
}

export default SettingFormBody;

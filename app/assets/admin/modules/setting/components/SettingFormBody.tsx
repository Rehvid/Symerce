import { Control, FieldErrors, UseFormRegister, UseFormSetValue, UseFormWatch } from 'react-hook-form';
import { FormContextInterface } from '@admin/common/interfaces/FormContextInterface';
import { SettingFormData } from '@admin/modules/setting/interfaces/SettingFormData';
import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Description from '@admin/common/components/Description';
import Switch from '@admin/common/components/form/input/Switch';
import SettingValueInputType from '@admin/modules/setting/components/SettingValueInputType';

interface SettingFormBodyProps {
    register: UseFormRegister<SettingFormData>;
    control: Control<SettingFormData>;
    fieldErrors: FieldErrors<SettingFormData>;
    formData: SettingFormData;
}

const SettingFormBody: React.FC<SettingFormBodyProps> = ({ register, control, fieldErrors, formData }) => {
    return (
        <FormSection title="Informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>
            <FormGroup
                label={<InputLabel isRequired={true} label="Nazwa" htmlFor="name" />}
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
                        ...validationRules.minLength(2),
                    })}
                />
            </FormGroup>
            <FormGroup label={<InputLabel label="Wartość" />}>
                <SettingValueInputType register={register} control={control} formData={formData} />
            </FormGroup>
            <FormGroup label={<InputLabel label="Ustawienie dostępne" />}>
                <Switch {...register('isActive')} />
            </FormGroup>
        </FormSection>
    );
};

export default SettingFormBody;

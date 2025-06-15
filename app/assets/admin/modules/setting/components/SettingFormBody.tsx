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
import GenericTextField from '@admin/common/components/form/fields/formGroup/GenericTextField';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';

interface SettingFormBodyProps {
    register: UseFormRegister<SettingFormData>;
    control: Control<SettingFormData>;
    fieldErrors: FieldErrors<SettingFormData>;
    formData: SettingFormData;
}

const SettingFormBody: React.FC<SettingFormBodyProps> = ({ register, control, fieldErrors, formData }) => {
    return (
        <FormSection title="Informacje" useToggleContent={false}>
            <GenericTextField
                fieldName="name"
                register={register}
                fieldErrors={fieldErrors}
                label="Nazwa"
                isRequired={true}
                description="Wartość wyświetlana tylko w panelu administracyjnym"
            />
            <FormGroup label={<InputLabel label="Wartość" />}>
                <SettingValueInputType register={register} control={control} formData={formData} />
            </FormGroup>
            <FormSwitchField register={register} name="isActive" label="Ustawienie jest aktywne" />
        </FormSection>
    );
};

export default SettingFormBody;

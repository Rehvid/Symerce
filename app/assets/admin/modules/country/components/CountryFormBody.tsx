import { FieldErrors, UseFormRegister } from 'react-hook-form';
import { CountryFormData } from '@admin/modules/country/interfaces/CountryFormData';
import React from 'react';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Switch from '@admin/common/components/form/input/Switch';
import FormSection from '@admin/common/components/form/FormSection';
import Description from '@admin/common/components/Description';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';
import GenericTextField from '@admin/common/components/form/fields/formGroup/GenericTextField';

interface CountryFormBodyProps {
    register: UseFormRegister<CountryFormData>;
    fieldErrors: FieldErrors<CountryFormData>;
}

const CountryFormBody: React.FC<CountryFormBodyProps> = ({ register, fieldErrors }) => {
    return (
        <>
            <FormSection title="Informacje" useToggleContent={false}>
                <GenericTextField
                    register={register}
                    fieldErrors={fieldErrors}
                    fieldName="name"
                    label="Nazwa"
                    isRequired={true}
                    placeholder="Polska"
                />
                <GenericTextField
                    register={register}
                    fieldErrors={fieldErrors}
                    fieldName="code"
                    label="Kod kraju"
                    isRequired={true}
                    description="Kod kraju musi być zgodny z ISO 3166-1 alfa-2"
                    placeholder="PL"
                    minLength={2}
                    maxLength={2}
                />
                <FormSwitchField register={register} name="isActive" label="Kraj dostepny" />
            </FormSection>
        </>
    );
};

export default CountryFormBody;

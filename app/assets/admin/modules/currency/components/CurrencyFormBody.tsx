import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import React, { FC } from 'react';
import NumberIcon from '@/images/icons/number.svg';
import FormSection from '@admin/common/components/form/FormSection';
import { FieldErrors, UseFormRegister } from 'react-hook-form';
import { CurrencyFormData } from '@admin/modules/currency/interfaces/CurrencyFormData';
import GenericTextField from '@admin/common/components/form/fields/formGroup/GenericTextField';

interface CurrencyFormBodyProps {
    register: UseFormRegister<CurrencyFormData>;
    fieldErrors: FieldErrors<CurrencyFormData>;
}

const CurrencyFormBody: FC<CurrencyFormBodyProps> = ({ register, fieldErrors }) => {
    return (
        <FormSection title="Informacje" useToggleContent={false}>
            <GenericTextField register={register} fieldErrors={fieldErrors} fieldName="name" label="Nazwa" isRequired={true} />
            <GenericTextField
                register={register}
                fieldErrors={fieldErrors}
                fieldName="code"
                label="Kod waluty"
                isRequired={true}
                minLength={3}
                maxLength={3}
                description="Kod waluty zgodny z ISO 4217, np. USD, EUR, PLN"
            />
            <GenericTextField
                register={register}
                fieldErrors={fieldErrors}
                fieldName="symbol"
                label="Symbol waluty"
                isRequired={true} minLength={1}
            />

            <FormGroup
                label={<InputLabel isRequired={true} label="Precyzja zaokrąglenia" htmlFor="roundingPrecision" />}
            >
                <InputField
                    type="number"
                    id="roundingPrecision"
                    hasError={!!fieldErrors?.roundingPrecision}
                    errorMessage={fieldErrors?.roundingPrecision?.message}
                    icon={<NumberIcon className="text-gray-500 w-[24px] h-[24px]" />}
                    {...register('roundingPrecision', {
                        ...validationRules.required(),
                        ...validationRules.min(0),
                        ...validationRules.max(8),
                    })}
                />
            </FormGroup>
        </FormSection>
    );
};

export default CurrencyFormBody;

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

interface CountryFormBodyProps {
    register: UseFormRegister<CountryFormData>;
    fieldErrors: FieldErrors<CountryFormData>;
}

const CountryFormBody: React.FC<CountryFormBodyProps> = ({ register, fieldErrors }) => {
    return (
        <>
            <FormSection title="Informacje" useToggleContent={false}>
                <FormGroup label={<InputLabel isRequired={true} label="Nazwa" htmlFor="name" />}>
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
                <FormGroup
                    label={<InputLabel isRequired={true} label="Kod kraju" htmlFor="code" />}
                    description={<Description>Kod kraju musi być zgodny z ISO 3166-1 alfa-2</Description>}
                >
                    <InputField
                        type="text"
                        id="code"
                        hasError={!!fieldErrors?.code}
                        errorMessage={fieldErrors?.code?.message}
                        icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                        {...register('code', {
                            ...validationRules.required(),
                            ...validationRules.max(2),
                        })}
                    />
                </FormGroup>
                <FormGroup label={<InputLabel label="Kraj dostępny" />}>
                    <Switch {...register('isActive')} />
                </FormGroup>
            </FormSection>
        </>
    );
};

export default CountryFormBody;

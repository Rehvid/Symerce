import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import React, { FC } from 'react';
import Switch from '@admin/common/components/form/input/Switch';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { WarehouseFormData } from '@admin/modules/warehouse/interfaces/WarehouseFormData';
import { WarehouseFormContext } from '@admin/modules/warehouse/interfaces/WarehouseFormContext';

interface WarehouseFormBodyProps {
    register: UseFormRegister<WarehouseFormData>;
    fieldErrors: FieldErrors<WarehouseFormData>;
    control: Control<WarehouseFormData>;
    formContext: WarehouseFormContext;
}

const WarehouseFormBody: FC<WarehouseFormBodyProps> = ({ register, fieldErrors, control, formContext }) => {
    return (
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

            <FormGroup label={<InputLabel label="Opis" htmlFor="description" />}>
                <textarea
                    {...register('description')}
                    className="w-full rounded-lg border border-gray-300 p-2 transition-all focus:ring-4 focus:border-primary focus:border-1 focus:outline-hidden focus:ring-primary-light"
                />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Ulica" htmlFor="street" />}>
                <InputField
                    type="text"
                    id="street"
                    hasError={!!fieldErrors?.street}
                    errorMessage={fieldErrors?.street?.message}
                    icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                    {...register('street', {
                        ...validationRules.required(),
                        ...validationRules.minLength(2),
                    })}
                />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Miasto" htmlFor="city" />}>
                <InputField
                    type="text"
                    id="city"
                    hasError={!!fieldErrors?.city}
                    errorMessage={fieldErrors?.city?.message}
                    icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                    {...register('city', {
                        ...validationRules.required(),
                        ...validationRules.minLength(2),
                    })}
                />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Kod pocztowy" htmlFor="postalCode" />}>
                <InputField
                    type="text"
                    id="postalCode"
                    hasError={!!fieldErrors?.postalCode}
                    errorMessage={fieldErrors?.postalCode?.message}
                    icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                    {...register('postalCode', {
                        ...validationRules.required(),
                        ...validationRules.minLength(2),
                    })}
                />
            </FormGroup>

            <FormGroup label={<InputLabel label="Kraj" isRequired={true} />}>
                <ControlledReactSelect name="country" control={control} options={formContext?.availableCountries} />
            </FormGroup>

            <FormGroup label={<InputLabel label="Aktywny?" />}>
                <Switch {...register('isActive')} />
            </FormGroup>
        </FormSection>
    );
};

export default WarehouseFormBody;

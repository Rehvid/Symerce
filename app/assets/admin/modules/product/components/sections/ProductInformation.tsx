import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import FormGroup from '@admin/common/components/form/FormGroup';
import Switch from '@admin/common/components/form/input/Switch';
import { validationRules } from '@admin/common/utils/validationRules';
import LabelNameIcon from '@/images/icons/label-name.svg';
import InputField from '@admin/common/components/form/input/InputField';
import { Control, FieldErrors, UseFormRegister, Controller } from 'react-hook-form';
import RichTextEditor from '@admin/common/components/form/input/RichTextEditor';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import { ProductFormData } from '@admin/modules/product/interfaces/ProductFormData';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { ProductFormContext } from '@admin/modules/product/interfaces/ProductFormContext';

interface ProductInformationProps {
    register: UseFormRegister<ProductFormData>;
    fieldErrors: FieldErrors<ProductFormData>;
    control: Control<ProductFormData>;
    formContext?: ProductFormContext;
}

const ProductInformation: React.FC<ProductInformationProps> = ({ register, fieldErrors, control, formContext }) => {
    return (
        <FormSection title="Podstawowe informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>
            <FormGroup label={<InputLabel isRequired={true} label="Nazwa" htmlFor="name" />}>
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

            <FormGroup label={<InputLabel label="Opis" />}>
                <Controller
                    name="description"
                    control={control}
                    defaultValue=""
                    render={({ field }) => <RichTextEditor value={field.value ?? ''} onChange={field.onChange} />}
                />
            </FormGroup>

            <FormGroup label={<InputLabel isRequired={true} label="Producent" />}>
                <ControlledReactSelect
                    rules={{
                        ...validationRules.required(),
                    }}
                    name="brand"
                    control={control}
                    options={formContext?.availableBrands}
                    isMulti={false}
                />
            </FormGroup>

            <FormGroup label={<InputLabel label="Produkt widoczny na sklepie?" />}>
                <Switch {...register('isActive')} />
            </FormGroup>
        </FormSection>
    );
};

export default ProductInformation;

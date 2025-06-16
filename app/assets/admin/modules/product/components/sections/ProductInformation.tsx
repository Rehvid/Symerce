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
import GenericTextField from '@admin/common/components/form/fields/formGroup/GenericTextField';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';

interface ProductInformationProps {
    register: UseFormRegister<ProductFormData>;
    fieldErrors: FieldErrors<ProductFormData>;
    control: Control<ProductFormData>;
    formContext?: ProductFormContext;
}

const ProductInformation: React.FC<ProductInformationProps> = ({ register, fieldErrors, control, formContext }) => {
    return (
        <FormSection title="Podstawowe informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>
            <GenericTextField register={register} fieldErrors={fieldErrors} fieldName={"name"} label="Nazwa" isRequired={true} />
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
                    name="brandId"
                    control={control}
                    options={formContext?.availableBrands}
                    isMulti={false}
                />
            </FormGroup>

            <FormSwitchField register={register} name={"isActive"} fieldErrors={fieldErrors} label="Produkt widoczny na sklepie?" />
        </FormSection>
    );
};

export default ProductInformation;

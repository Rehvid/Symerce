import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { ProductFormData } from '@admin/modules/product/interfaces/ProductFormData';
import { ProductFormContext } from '@admin/modules/product/interfaces/ProductFormContext';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import Slug from '@admin/common/components/form/fields/formGroup/Slug';
import MetaFields from '@admin/common/components/form/fields/formGroup/MetaFields';

interface ProductLogisticsProps {
    control: Control<ProductFormData>;
    fieldErrors: FieldErrors<ProductFormData>;
    register: UseFormRegister<ProductFormData>;
    formContext?: ProductFormContext;
}

const ProductSeo: React.FC<ProductLogisticsProps> = ({ control, fieldErrors, formContext, register }) => {
    return (
        <FormSection title="SEO">
            <Slug register={register} fieldErrors={fieldErrors} isRequired={false} />
            <MetaFields register={register} fieldErrors={fieldErrors} />

            <FormGroup label={<InputLabel label="Tagi" htmlFor="tags" />}>
                <ControlledReactSelect
                    name="tags"
                    control={control}
                    options={formContext?.availableTags || []}
                    isMulti={true}
                />
            </FormGroup>
        </FormSection>
    );
};

export default ProductSeo;

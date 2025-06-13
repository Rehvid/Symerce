import React from 'react';
import { UseFormRegister, Control, FieldErrors, UseFormWatch, UseFormSetValue } from 'react-hook-form';
import ProductImages from '@admin/modules/product/components/sections/ProductImages';
import ProductInformation from '@admin/modules/product/components/sections/ProductInformation';
import ProductCategorization from '@admin/modules/product/components/sections/ProductCategorization';
import ProductSeo from '@admin/modules/product/components/sections/ProductSeo';
import ProductPricing from '@admin/modules/product/components/sections/ProductPricing';
import ProductStock from '@admin/modules/product/components/sections/ProductStock';
import ProductAttributes from '@admin/modules/product/components/sections/ProductAttributes';
import { ProductFormData } from '@admin/modules/product/interfaces/ProductFormData';
import { ProductFormContext } from '@admin/modules/product/interfaces/ProductFormContext';

interface ProductFormBodyProps {
    register: UseFormRegister<ProductFormData>;
    control: Control<ProductFormData>;
    watch: UseFormWatch<ProductFormData>;
    setValue: UseFormSetValue<ProductFormData>;
    fieldErrors: FieldErrors<ProductFormData>;
    formData?: ProductFormData;
    formContext?: ProductFormContext;
}

const ProductFormBody: React.FC<ProductFormBodyProps> = ({
    register,
    control,
    watch,
    setValue,
    fieldErrors,
    formData,
    formContext,
}) => {
    return (
        <>
            <ProductImages setValue={setValue} formData={formData} />
            <ProductInformation
                register={register}
                fieldErrors={fieldErrors}
                control={control}
                formContext={formContext}
            />
            <ProductCategorization control={control} fieldErrors={fieldErrors} formContext={formContext} />
            <ProductSeo control={control} fieldErrors={fieldErrors} formContext={formContext} register={register} />
            <ProductPricing
                register={register}
                control={control}
                watch={watch}
                formContext={formContext}
                fieldErrors={fieldErrors}
            />
            <ProductStock register={register} fieldErrors={fieldErrors} control={control} formContext={formContext} />
            <ProductAttributes control={control} formContext={formContext} register={register} setValue={setValue} />
        </>
    );
};

export default ProductFormBody;

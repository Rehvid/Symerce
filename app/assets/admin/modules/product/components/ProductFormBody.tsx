import React from 'react';
import {
  UseFormRegister,
  Control,
  FieldErrors,
  UseFormWatch,
  UseFormSetValue,
} from 'react-hook-form';
import ProductImages from '@admin/modules/product/components/sections/ProductImages';
import ProductInformation from '@admin/modules/product/components/sections/ProductInformation'
import ProductCategorization from '@admin/modules/product/components/sections/ProductCategorization'
import ProductSeo from '@admin/modules/product/components/sections/ProductSeo';
import ProductPricing from '@admin/modules/product/components/sections/ProductPricing';
import ProductStock from '@admin/modules/product/components/sections/ProductStock';
import ProductAttributes from '@admin/modules/product/components/sections/ProductAttributes';
import { ProductFormDataInterface } from '@admin/modules/product/interfaces/ProductFormDataInterface';
import { FormContextInterface } from '@admin/common/interfaces/FormContextInterface';


interface ProductFormBodyProps {
  register: UseFormRegister<ProductFormDataInterface>;
  control: Control<ProductFormDataInterface>;
  watch: UseFormWatch<ProductFormDataInterface>;
  setValue: UseFormSetValue<ProductFormDataInterface>;
  fieldErrors: FieldErrors<ProductFormDataInterface>;
  formData?: ProductFormDataInterface;
  formContext?: FormContextInterface;
}

const ProductFormBody: React.FC<ProductFormBodyProps> = ({register, control, watch, setValue, fieldErrors, formData, formContext}) => {
  return (
    <>
      <ProductImages setValue={setValue} formData={formData} />
      <ProductInformation register={register} fieldErrors={fieldErrors} control={control} formContext={formContext} />
      <ProductCategorization control={control} fieldErrors={fieldErrors} formData={formContext} watch={watch} />
      <ProductSeo control={control} fieldErrors={fieldErrors} formData={formContext} register={register} />
      <ProductPricing register={register} control={control} watch={watch} formData={formContext} fieldErrors={fieldErrors} />
      <ProductStock register={register} fieldErrors={fieldErrors} control={control} formContext={formContext} />
      <ProductAttributes control={control} fieldErrors={fieldErrors} formData={formContext} register={register} watch={watch} setValue={setValue} />
    </>
  )
}

export default ProductFormBody;

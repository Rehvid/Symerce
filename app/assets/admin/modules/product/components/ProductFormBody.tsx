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
import ProductLogistics from '@admin/modules/product/components/sections/ProductLogistics';
import ProductPricing from '@admin/modules/product/components/sections/ProductPricing';
import ProductStock from '@admin/modules/product/components/sections/ProductStock';
import ProductAttributes from '@admin/modules/product/components/sections/ProductAttributes';
import { ProductFormDataInterface } from '@admin/modules/product/interfaces/ProductFormDataInterface';


interface ProductFormBodyProps {
  register: UseFormRegister<ProductFormDataInterface>;
  control: Control<ProductFormDataInterface>;
  watch: UseFormWatch<ProductFormDataInterface>;
  setValue: UseFormSetValue<ProductFormDataInterface>;
  fieldErrors: FieldErrors<ProductFormDataInterface>;
  formData?: ProductFormDataInterface;
}

const ProductFormBody: React.FC<ProductFormBodyProps> = ({register, control, watch, setValue, fieldErrors, formData}) => {
  return (
    <>
      <ProductImages setValue={setValue} formData={formData} />
      <ProductInformation register={register} fieldErrors={fieldErrors} control={control} />
      <ProductCategorization control={control} fieldErrors={fieldErrors} formData={formData} watch={watch} />
      <ProductLogistics control={control} fieldErrors={fieldErrors} formData={formData} />
      <ProductPricing register={register} control={control} watch={watch} formData={formData} fieldErrors={fieldErrors} />
      <ProductStock register={register} fieldErrors={fieldErrors} />
      <ProductAttributes control={control} fieldErrors={fieldErrors} formData={formData} />
    </>
  )
}

export default ProductFormBody;

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

export interface ProductFormData {
  name: string,
  slug?: string
  description?: string
  isActive: boolean
}

interface ProductFormBodyProps {
  register: UseFormRegister<ProductFormData>;
  control: Control<ProductFormData>;
  watch: UseFormWatch<ProductFormData>;
  setValue: UseFormSetValue<ProductFormData>;
  fieldErrors: FieldErrors<ProductFormData>;
  formData?: ProductFormData;
  setFormData?: React.Dispatch<React.SetStateAction<ProductFormData>>;
}

const ProductFormBody: React.FC<ProductFormBodyProps> = ({register, control, watch, setValue, fieldErrors, formData, setFormData}) => {
  return (
    <>
      <ProductImages setValue={setValue} formData={formData} />
      <ProductInformation register={register} fieldErrors={fieldErrors} control={control} />
      <ProductCategorization control={control} fieldErrors={fieldErrors} formData={formData} />
      <ProductLogistics control={control} fieldErrors={fieldErrors} formData={formData} />
      <ProductPricing register={register} control={control} watch={watch} formData={formData} fieldErrors={fieldErrors} />
      <ProductStock register={register} fieldErrors={fieldErrors} />
      <ProductAttributes control={control} fieldErrors={fieldErrors} formData={formData} />
    </>
  )
}

export default ProductFormBody;

import { AttributeType } from '@admin/modules/attribute/enums/AttributeType';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { Control, Controller, Path, UseFormRegister } from 'react-hook-form';
import RichTextEditor from '@admin/common/components/form/input/RichTextEditor';
import Chrome from '@uiw/react-color-chrome';
import React from 'react';
import { ProductFormData } from '@admin/modules/product/interfaces/ProductFormData';


interface ProductAttributeCustomValueProps {
    control: Control<ProductFormData>;
    register: UseFormRegister<ProductFormData>;
    type: AttributeType;
    name: Path<ProductFormData>;
}

const ProductAttributeCustomValue = ({
 control,
 register,
 type,
 name,
}: ProductAttributeCustomValueProps) => {
  const fullName = `${name}.value`;

  switch (type) {
    case AttributeType.TEXT:
    case AttributeType.NUMBER:
      return (
        <InputField
          type={type}
          id="value"
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register(fullName as Path<ProductFormData>)}
        />
      )
    case AttributeType.RAW_TEXTAREA:
      return (
        <textarea {...register(fullName as Path<ProductFormData>)} className="w-full rounded-lg border border-gray-300 p-2 transition-all focus:ring-4 focus:border-primary focus:border-1 focus:outline-hidden focus:ring-primary-light" />
      )
    case AttributeType.TEXTAREA:
      return (
        <Controller
          name={fullName as Path<ProductFormData>}
          control={control}
          defaultValue=""
          render={({ field }) => <RichTextEditor value={field.value ?? ''} onChange={field.onChange} />}
        />
      )
    case AttributeType.COLOR:
      return (
        <Controller
          name={fullName as Path<ProductFormData>}
          control={control}
          render={({ field }) => (
            <Chrome
              color={field.value}
              onChange={(color) => field.onChange(color.hexa)}
            />
          )}
        />
      )
  }
}

export default ProductAttributeCustomValue;

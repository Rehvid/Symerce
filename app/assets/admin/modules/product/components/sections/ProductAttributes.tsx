import React from 'react';
import { Control, Controller } from 'react-hook-form';
import FormSection from '@admin/shared/components/form/FormSection';
import FormGroup from '@admin/shared/components/form/FormGroup';
import MultiSelect from '@admin/shared/components/form/select/MultiSelect';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import { ProductFormDataInterface } from '@admin/modules/product/interfaces/ProductFormDataInterface';

interface ProductAttributesProps {
  control: Control<ProductFormDataInterface>;
  formData?: ProductFormDataInterface;
}

const ProductAttributes: React.FC<ProductAttributesProps> = ({formData, control}) => {
  const attributes = Object.values(formData?.optionAttributes || {});

  if (attributes.length <= 0) {
    return null;
  }

  return (
    <FormSection title="Atrybuty">
      {Object.entries(formData.optionAttributes).map(([key, optionValue]) => (
        <FormGroup
          key={key}
          label={<InputLabel label={optionValue['label']}  />}
        >
          <Controller
            key={key}
            name={`attributes[${optionValue['name']}]`}
            control={control}
            defaultValue={[]}
            render={({ field }) => (
              <MultiSelect
                options={optionValue['options'] || []}
                selected={field.value}
                onChange={(value, checked) => {
                  const newValue = checked
                    ? [...field.value, value]
                    : field.value.filter((v) => v !== value);
                  field.onChange(newValue);
                }}
              />
            )}
          />
        </FormGroup>
      ))}
    </FormSection>
  )
}

export default ProductAttributes;

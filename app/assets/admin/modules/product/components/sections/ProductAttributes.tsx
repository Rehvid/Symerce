import React from 'react';
import { Control, Controller, Path, UseFormRegister, UseFormSetValue, useWatch } from 'react-hook-form';
import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { ProductFormData } from '@admin/modules/product/interfaces/ProductFormData';
import { DynamicFields } from '@admin/common/components/form/DynamicFields';
import Switch from '@admin/common/components/form/input/Switch';
import ProductAttributeCustomValue from '@admin/modules/product/components/ProductAttributeCustomValue';
import { ProductFormContext } from '@admin/modules/product/interfaces/ProductFormContext';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';

interface ProductAttributesProps {
  control: Control<ProductFormData>;
  formData?: ProductFormData;
  formContext?: ProductFormContext;
  setValue: UseFormSetValue<ProductFormData>;
  register: UseFormRegister<ProductFormData>;
}

const ProductAttributes: React.FC<ProductAttributesProps> = ({formContext, control, register, setValue}) => {
  const attributes = Object.values(formContext?.availableAttributes || {});

  if (attributes.length <= 0) {
    return null;
  }

    const customAttributesValues = useWatch({
        control,
        name: 'customAttributes' as Path<ProductFormData>,
    });

  return (
    <FormSection title="Atrybuty">
      {Object.entries(formContext?.availableAttributes || []).map(([key, optionValue]) => {
        const namePrefix = `attributes[${optionValue.name}]`;
        const customValueName = `customAttributes[${optionValue.name}]`;
        const isCustomValue = customAttributesValues?.[optionValue.name];

        return (
          <FormGroup
            key={key}
            label={<InputLabel label={optionValue.label} />}
            additionalClasses="border-b border-gray-100 pb-5"
          >
            <Controller
              name={customValueName as Path<ProductFormData>}
              control={control}
              defaultValue={false}
              render={({ field }) => (
                <FormGroup label={<InputLabel label="Użyj własnej wartości" />} additionalClasses="mb-5">
                  <Switch
                    checked={field.value}
                    onChange={(e) => {
                      const checked = e.target.checked;
                      field.onChange(checked);

                      setValue(namePrefix as Path<ProductFormData>, []);
                    }}
                  />
                </FormGroup>
              )}
            />

            {isCustomValue ? (
              <DynamicFields
                name={namePrefix}
                control={control}
                renderItem={(_index, innerPrefix) => (
                  <div className="space-y-2 flex flex-col gap-4">
                    <ProductAttributeCustomValue
                      type={optionValue.type}
                      name={innerPrefix as Path<ProductFormData>}
                      control={control}
                      register={register}
                    />
                  </div>
                )}
              />
            ) : (
              <ControlledReactSelect
                  name={namePrefix as Path<ProductFormData>}
                  control={control}
                  options={optionValue.options || []}
                  isMulti={true}
              />
            )}
          </FormGroup>
        );
      })}
    </FormSection>
  );
}

export default ProductAttributes;

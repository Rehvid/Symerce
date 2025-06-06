import React from 'react';
import { Control, Controller } from 'react-hook-form';
import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { ProductFormDataInterface } from '@admin/modules/product/interfaces/ProductFormDataInterface';
import { DynamicFields } from '@admin/common/components/form/DynamicFields';
import Switch from '@admin/common/components/form/input/Switch';
import ReactSelect from '@admin/common/components/form/reactSelect/ReactSelect';
import ProductAttributeCustomValue from '@admin/modules/product/components/ProductAttributeCustomValue';

interface ProductAttributesProps {
  control: Control<ProductFormDataInterface>;
  formData?: ProductFormDataInterface;
}

const ProductAttributes: React.FC<ProductAttributesProps> = ({formData, control, register, watch, setValue}) => {
  const attributes = Object.values(formData?.availableAttributes || {});

  if (attributes.length <= 0) {
    return null;
  }

  return (
    <FormSection title="Atrybuty">
      {Object.entries(formData.availableAttributes).map(([key, optionValue]) => {
        const namePrefix = `attributes[${optionValue.name}]`;
        const customValueName = `customAttributes[${optionValue.name}]`;
        const isCustomValue = watch(customValueName);

        return (
          <FormGroup
            key={key}
            label={<InputLabel label={optionValue.label} />}
            additionalClasses="border-b border-gray-100 pb-5"
          >
            <Controller
              name={customValueName}
              control={control}
              defaultValue={false}
              render={({ field }) => (
                <FormGroup label={<InputLabel label="Użyj własnej wartości" />} additionalClasses="mb-5">
                  <Switch
                    checked={field.value}
                    onChange={(e) => {
                      const checked = e.target.checked;
                      field.onChange(checked);

                      setValue(namePrefix, []);
                    }}
                  />
                </FormGroup>
              )}
            />

            {isCustomValue ? (
              <DynamicFields
                name={namePrefix}
                control={control}
                register={register}
                renderItem={(index, innerPrefix) => (
                  <div className="space-y-2 flex flex-col gap-4">
                    <ProductAttributeCustomValue
                      type={optionValue.type}
                      name={innerPrefix}
                      control={control}
                      register={register}
                    />
                  </div>
                )}
              />
            ) : (
              <Controller
                name={namePrefix}
                control={control}
                defaultValue={[]}
                render={({ field, fieldState }) => (
                  <ReactSelect
                    options={optionValue.options || []}
                    value={field.value}
                    onChange={(option) => {
                      field.onChange(option);
                    }}
                    hasError={fieldState.invalid}
                    errorMessage={fieldState.error?.message}
                    isMulti={true}
                  />
                )}
              />
            )}
          </FormGroup>
        );
      })}
    </FormSection>
  );
}

export default ProductAttributes;

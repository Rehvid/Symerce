import React from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import FormGroup from '@admin/shared/components/form/FormGroup';
import { Control, Controller, FieldErrors, UseFormRegister } from 'react-hook-form';
import { ProductFormData } from '@admin/modules/product/components/ProductFormBody';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import Select from '@admin/shared/components/form/select/Select';
import { validationRules } from '@admin/utils/validationRules';
import { hasAnyFieldError } from '@admin/shared/utils/formUtils';
import MultiSelect from '@admin/shared/components/form/select/MultiSelect';


interface ProductCategorizationProps {
  control: Control<ProductFormData>;
  fieldErrors: FieldErrors<ProductFormData>;
  formData?: ProductFormData;
}

const ProductCategorization : React.FC<ProductCategorizationProps> = ({ control, fieldErrors, formData }) => {
  return (
    <FormSection title="Kategoryzacja" forceOpen={hasAnyFieldError(fieldErrors, ['mainCategory'])} >
      <FormGroup
        label={<InputLabel isRequired={true} label="Główna kategoria" htmlFor="mainCategory"  />}
      >
        <Controller
          name="mainCategory"
          control={control}
          defaultValue={null}
          rules={{
            ...validationRules.required(),
          }}
          render={({ field }) => (
              <Select
                hasError={!!fieldErrors?.mainCategory}
                errorMessage={fieldErrors?.mainCategory?.message}
                options={formData?.optionCategories || []}
                selected={field.value}
                onChange={(value) => {
                  field.onChange(value);
                }}
              />
          )}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel label="Kategorie" htmlFor="categories"  />}
      >
        <Controller
          name="categories"
          control={control}
          defaultValue={[]}
          render={({ field }) => (
              <MultiSelect
                options={formData?.optionCategories || []}
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

      <FormGroup label={<InputLabel label="Tagi" htmlFor="tags"  />} >
        <Controller
          name="tags"
          control={control}
          defaultValue={[]}
          render={({ field }) => (
              <MultiSelect
                options={formData?.optionTags || []}
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
    </FormSection>
  )
}

export default ProductCategorization;

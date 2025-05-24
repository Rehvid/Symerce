import React, { useEffect, useState } from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import FormGroup from '@admin/shared/components/form/FormGroup';
import { Control, Controller, FieldErrors } from 'react-hook-form';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import Select from '@admin/shared/components/form/select/Select';
import { validationRules } from '@admin/utils/validationRules';
import { hasAnyFieldError } from '@admin/shared/utils/formUtils';
import MultiSelect from '@admin/shared/components/form/select/MultiSelect';
import { ProductFormDataInterface } from '@admin/modules/product/interfaces/ProductFormDataInterface';


interface ProductCategorizationProps {
  control: Control<ProductFormDataInterface>;
  fieldErrors: FieldErrors<ProductFormDataInterface>;
  formData?: ProductFormDataInterface;
}

type MainCategory = {
  label: string,
  value: number,
}

const ProductCategorization : React.FC<ProductCategorizationProps> = ({ control, fieldErrors, formData, watch }) => {

  const [mainCategories, setMainCategories] = useState<MainCategory[]>([]);

  useEffect(() => {
    const currentCategories = watch().categories;
    if (currentCategories && Array.isArray(currentCategories)) {
      const filteredOptionCategories = formData?.optionCategories.filter(optionCategory =>
        currentCategories.includes(optionCategory.value)
      );

     setMainCategories(filteredOptionCategories);
    }
  }, [watch().categories]);

  console.log(formData);


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
                options={mainCategories}
                selected={field.value}
                onChange={(value) => {
                  field.onChange(value);
                }}
              />
          )}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel label="Kategorie" htmlFor="categories"  isRequired={true} />}
      >
        <Controller
          name="categories"
          control={control}
          defaultValue={[]}
          rules={{
            ...validationRules.required(),
          }}
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

import React, { useEffect, useState } from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import { Control, Controller, FieldErrors, useWatch } from 'react-hook-form';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import Select from '@admin/common/components/form/select/Select';
import { validationRules } from '@admin/common/utils/validationRules';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import MultiSelect from '@admin/common/components/form/select/MultiSelect';
import { ProductFormData } from '@admin/modules/product/interfaces/ProductFormData';
import Description from '@admin/common/components/Description';
import { ProductFormContext } from '@admin/modules/product/interfaces/ProductFormContext';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { SelectOption } from '@admin/common/types/selectOption';


interface ProductCategorizationProps {
  control: Control<ProductFormData>;
  fieldErrors: FieldErrors<ProductFormData>;
  formContext?: ProductFormContext;
}

const ProductCategorization : React.FC<ProductCategorizationProps> = ({ control, fieldErrors, formContext }) => {

  const [mainCategories, setMainCategories] = useState<SelectOption[]>([]);
  const selectedCategories = useWatch({ control, name: 'categories' });

  useEffect(() => {
      if (selectedCategories && Array.isArray(selectedCategories)) {
          const filtered = formContext?.availableCategories.filter((cat) =>
              selectedCategories.includes(cat.value)
          );

          setMainCategories(filtered || []);
      }
  }, [selectedCategories]);

  return (
    <FormSection title="Kategoryzacja" forceOpen={hasAnyFieldError(fieldErrors, ['mainCategory'])} >
      <FormGroup
        label={<InputLabel isRequired={true} label="Główna kategoria" htmlFor="mainCategory"  />}
        description={<Description> Wybór kategorii dodaje możliwe opcje, spośród których można wybrać główną kategorię produktu.</Description>}
      >
        <ControlledReactSelect
            name="mainCategory"
            control={control}
            options={mainCategories}
            isMulti={false}
            rules={{
                ...validationRules.required(),
            }}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel label="Kategorie" htmlFor="categories"  isRequired={true} />}
      >
          <ControlledReactSelect
              name="categories"
              control={control}
              options={formContext?.availableCategories || []}
              isMulti={true}
              rules={{
                  ...validationRules.required(),
              }}
          />
      </FormGroup>
    </FormSection>
  )
}

export default ProductCategorization;

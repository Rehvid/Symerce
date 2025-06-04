import React from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import { Control, Controller, FieldErrors } from 'react-hook-form';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import { validationRules } from '@admin/utils/validationRules';
import Select from '@admin/shared/components/form/select/Select';
import { ProductFormDataInterface } from '@admin/modules/product/interfaces/ProductFormDataInterface';
import MultiSelect from '@admin/shared/components/form/select/MultiSelect';
import InputField from '@admin/shared/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import Description from '@admin/shared/components/Description';

interface ProductLogisticsProps {
  control: Control<ProductFormDataInterface>;
  fieldErrors: FieldErrors<ProductFormDataInterface>;
  formData?: ProductFormDataInterface;
}

const ProductSeo: React.FC<ProductLogisticsProps> = ({ control, fieldErrors, formData, register }) => {
  return (
    <FormSection title="SEO">
      <FormGroup
        label={<InputLabel label="Przyjazny URL" htmlFor="slug" />}
        description={<Description>Automacznie generowany z nazwy, jeżeli nic nie zostanie podane.</Description>}
      >
        <InputField
          type="text"
          id="slug"
          hasError={!!fieldErrors?.slug}
          errorMessage={fieldErrors?.slug?.message}
          {...register('slug')}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel label="Meta tytuł" htmlFor="metaTitle"  />}
      >
        <InputField
          type="text"
          id="metaTitle"
          hasError={!!fieldErrors?.metaTitle}
          errorMessage={fieldErrors?.metaTitle?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('metaTitle')}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel label="Meta opis" htmlFor="metaDescription"  />}
      >
        <textarea {...register('metaDescription')} className="w-full rounded-lg border border-gray-300 p-2 transition-all focus:ring-4 focus:border-primary focus:border-1 focus:outline-hidden focus:ring-primary-light" />
      </FormGroup>


      <FormGroup label={<InputLabel label="Tagi" htmlFor="tags"  />} >
        <Controller
          name="tags"
          control={control}
          defaultValue={[]}
          render={({ field }) => (
            <MultiSelect
              options={formData?.availableTags || []}
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

export default ProductSeo;

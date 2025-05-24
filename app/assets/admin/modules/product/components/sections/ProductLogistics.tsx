import React from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import { Control, Controller, FieldErrors } from 'react-hook-form';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import { validationRules } from '@admin/utils/validationRules';
import Select from '@admin/shared/components/form/select/Select';
import { ProductFormDataInterface } from '@admin/modules/product/interfaces/ProductFormDataInterface';

interface ProductLogisticsProps {
  control: Control<ProductFormDataInterface>;
  fieldErrors: FieldErrors<ProductFormDataInterface>;
  formData?: ProductFormDataInterface;
}

const ProductLogistics: React.FC<ProductLogisticsProps> = ({ control, fieldErrors, formData }) => {
  return (
    <FormSection title="Logistyka">
      <FormGroup
        label={<InputLabel isRequired={true} label="Producent"  />}
      >
        <Controller
          name="vendor"
          control={control}
          defaultValue={null}
          render={({ field }) => (
            <div>
              <Select
                options={formData?.optionVendors || []}
                selected={field.value}
                onChange={(value) => {
                  field.onChange(value);
                }}
              />
            </div>
          )}
        />
      </FormGroup>
      <FormGroup
        label={<InputLabel isRequired={true} label="Czas Dostawy" />}
      >
        <Controller
          name="deliveryTime"
          control={control}
          defaultValue={null}
          rules={{
            ...validationRules.required(),
          }}
          render={({ field }) => (
              <Select
                options={formData?.optionDeliveryTimes || []}
                selected={field.value}
                onChange={(value) => {
                  field.onChange(value);
                }}
                isRequired
                hasError={!!fieldErrors?.deliveryTime}
                errorMessage={fieldErrors?.deliveryTime?.message}
              />
          )}
        />
      </FormGroup>
    </FormSection>
  )
}

export default ProductLogistics;

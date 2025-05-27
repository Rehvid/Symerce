import React from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import { Control, Controller, FieldErrors } from 'react-hook-form';
import { validationRules } from '@admin/utils/validationRules';
import Select from '@admin/shared/components/form/select/Select';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputField from '@admin/shared/components/form/input/InputField';
import Description from '@admin/shared/components/Description';
import { OrderFormDataInterface } from '@admin/modules/order/interfaces/OrderFormDataInterface';
import { FormContextInterface } from '@admin/shared/interfaces/FormContextInterface';

interface OrderInformationProps {
  control: Control<OrderFormDataInterface>;
  fieldErrors: FieldErrors<OrderFormDataInterface>;
  isEditMode: boolean,
  formData?: OrderFormDataInterface;
  formContext?: FormContextInterface;
}

const OrderInformation: React.FC<OrderInformationProps> = ({
 control,
 fieldErrors,
 isEditMode,
 formContext,
 formData
}) => {
  return (
    <FormSection title="Podstawowe informacje">
      <FormGroup
        label={<InputLabel isRequired={true} label="Status" htmlFor="status"  />}
      >
        <Controller
          name="status"
          control={control}
          defaultValue={null}
          rules={{
            ...validationRules.required(),
          }}
          render={({ field }) => (
            <Select
              hasError={!!fieldErrors?.status}
              errorMessage={fieldErrors?.status?.message}
              options={formContext?.availableStatuses || []}
              selected={field.value}
              onChange={(value) => {
                field.onChange(value);
              }}
            />
          )}
        />
      </FormGroup>
      <FormGroup
        label={<InputLabel isRequired={true} label="Krok w zamówieniu" htmlFor="checkoutStep"  />}
      >
        <Controller
          name="checkoutStep"
          control={control}
          defaultValue={null}
          rules={{
            ...validationRules.required(),
          }}
          render={({ field }) => (
            <Select
              hasError={!!fieldErrors?.checkoutStep}
              errorMessage={fieldErrors?.checkoutStep?.message}
              options={formContext?.availableCheckoutSteps || []}
              selected={field.value}
              onChange={(value) => {
                field.onChange(value);
              }}
            />
          )}
        />
      </FormGroup>
      {isEditMode && (
        <FormGroup
          label={<InputLabel label="UUID" htmlFor="street"  />}
          description={<Description>Automatycznie generowana wartość, nie ma możliwości edycji.</Description>}
        >
          <InputField
            type="text"
            id="invoiceStreet"
            disabled
            readOnly
            defaultValue={formData.uuid}
          />
        </FormGroup>
      )}
    </FormSection>
  )
}

export default OrderInformation;

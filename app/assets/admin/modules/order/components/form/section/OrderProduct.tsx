import React, { useState } from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import { DynamicFields } from '@admin/common/components/form/DynamicFields';
import InputField from '@admin/common/components/form/input/InputField';
import Select from '@admin/common/components/form/select/Select';
import { Control, Controller, FieldErrors, UseFormRegister } from 'react-hook-form';
import { validationRules } from '@admin/common/utils/validationRules';
import { OrderFormDataInterface } from '@admin/modules/order/interfaces/OrderFormDataInterface';
import { FormContextInterface } from '@admin/common/interfaces/FormContextInterface';

interface OrderProductProps {
  register: UseFormRegister<OrderFormDataInterface>;
  control: Control<OrderFormDataInterface>;
  fieldErrors: FieldErrors<OrderFormDataInterface>;
  formContext?: FormContextInterface;
}

const OrderProduct: React.FC<OrderProductProps> = ({
  register,
  control,
  fieldErrors,
  formContext
}) => {
  return (
    <FormSection title="Produkty w zamówieniu">
      <DynamicFields
        name="products"
        control={control}
        register={register}
        renderItem={(index, namePrefix) => (
          <div className="space-y-2 flex flex-col gap-4">
            <Controller
              name={`${namePrefix}.productId`}
              control={control}
              defaultValue={null}
              rules={{
                ...validationRules.required(),
              }}
              render={({ field }) => (
                <Select
                  options={formContext?.availableProducts || []}
                  selected={field.value}
                  onChange={(value) => {
                    field.onChange(value);
                  }}
                />
              )}
            />
            <InputField
              {...register(`${namePrefix}.quantity`, {
                ...validationRules.required(),
              })}
              placeholder="Ilość"
              type="number"
              hasError={!!fieldErrors?.products?.[index]?.quantity}
              errorMessage={fieldErrors?.products?.[index]?.quantity?.message}
            />
          </div>
        )}
      />
    </FormSection>
  )
}

export default OrderProduct;

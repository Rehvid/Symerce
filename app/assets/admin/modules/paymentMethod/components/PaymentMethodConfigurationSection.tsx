import FormSection from '@admin/shared/components/form/FormSection';
import { hasAnyFieldError } from '@admin/shared/utils/formUtils';
import InputField from '@admin/shared/components/form/input/InputField';
import { validationRules } from '@admin/utils/validationRules';
import { DynamicFields } from '@admin/shared/components/form/DynamicFields';
import React from 'react';

const PaymentMethodConfigurationSection = ({register, fieldErrors, control}) => (
  <FormSection title="Dodatkowa konfiguracja" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>
      <DynamicFields
        name="config"
        control={control}
        register={register}
        renderItem={(index, namePrefix) => (
          <div className="space-y-2 flex flex-col gap-4">
            <InputField
              {...register(`${namePrefix}.key`, {
                ...validationRules.required(),
              })}
              placeholder="Klucz konfiguracji"
              type="text"
              hasError={!!fieldErrors?.config?.[index]?.key}
              errorMessage={fieldErrors?.config?.[index]?.key?.message}
            />
            <InputField
              {...register(`${namePrefix}.value`, {
                ...validationRules.required(),
              })}
              placeholder="Wartość konfiguracji"
              type="text"
              hasError={!!fieldErrors?.config?.[index]?.value}
              errorMessage={fieldErrors?.config?.[index]?.value?.message}
            />
          </div>
        )}
      />
  </FormSection>
)

export default PaymentMethodConfigurationSection;
